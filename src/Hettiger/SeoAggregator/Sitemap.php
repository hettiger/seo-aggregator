<?php namespace Hettiger\SeoAggregator;

use Hettiger\SeoAggregator\Interfaces\SitemapInterface;
use Hettiger\SeoAggregator\Support\CustomObject;

class Sitemap extends Generator implements SitemapInterface {

    protected $links;
    protected $collections;
    protected $lines;

    /**
     * Add a link to the sitemap
     *
     * @param string $link
     * @param \DateTime $updated_at
     * @return void
     */
    public function addLink($link, $updated_at)
    {
        $link_object = new CustomObject;
        $link_object->link = $link;
        $link_object->updated_at = $updated_at;

        $this->links[] = $link_object;
    }

    /**
     * Add a collection of links to the sitemap
     *
     * @param object $collection
     * @param string $url_prefix
     * @return void
     */
    public function addCollection($collection, $url_prefix = null)
    {
        foreach ( $collection as $link ) {
            $link->prefix = $url_prefix;
        }

        $this->collections[] = $collection;
    }

    /**
     * Add one line to the output
     *
     * @param string $line
     * @return void
     */
    protected function addLine($line)
    {
        $this->lines[] = $line;
    }

    /**
     * Iterate through a collection and add lines accordingly
     *
     * @param object $collection
     */
    protected function iterateCollection($collection)
    {
        $loc = $this->field_names['loc'];
        $lastmod = $this->field_names['lastmod'];

        foreach ( $collection as $link ) {
            if ( ! is_null($link->prefix) ) {
                $link->prefix .= '/';
            }

            $this->addLine('<url>');
            $this->addLine('<loc>');
            $this->addLine($this->helpers->url(
                $link->prefix . $link->$loc,
                $this->protocol,
                $this->host
            ));
            $this->addLine('</loc>');
            $this->addLine('<lastmod>' . date_format($link->$lastmod, 'Y-m-d') . '</lastmod>');
            $this->addLine('</url>');
        }
    }

    /**
     * Generate the content of all links for the sitemap
     *
     * @return void
     */
    protected function generateLinks()
    {
        if ( ! is_null($this->links) ) {
            foreach ( $this->links as $link ) {
                $this->addLine('<url>');
                $this->addLine('<loc>');
                $this->addLine($this->helpers->url(
                    $link->link,
                    $this->protocol,
                    $this->host
                ));
                $this->addLine('</loc>');
                $this->addLine('<lastmod>' . date_format($link->updated_at, 'Y-m-d') . '</lastmod>');
                $this->addLine('</url>');
            }
        }
    }

    /**
     * Generate the content of all collections for the sitemap
     *
     * @return void
     */
    protected function generateCollections()
    {
        if ( ! is_null($this->collections) ) {
            foreach ( $this->collections as $collection ) {
                $this->iterateCollection($collection);
            }
        }
    }

    /**
     * Get the content for the sitemap.xml file
     *
     * @return string
     */
    public function getSitemapXml()
    {
        $this->addLine('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

        $this->generateLinks();
        $this->generateCollections();

        $this->addLine('</urlset>');

        $output = implode('', $this->lines);

        return $output;
    }

}
