<?php namespace Hettiger\SeoAggregator;

class Robots implements RobotsInterface {

    /**
     * @var Helpers
     */
    protected $helpers;

    protected $protocol;
    protected $host;

    protected $disallowed_paths;
    protected $disallowed_collections;
    protected $lines;

    /**
     * @param HelpersInterface $helpers
     * @param string $protocol
     * @param null|string $host
     * @return \Hettiger\SeoAggregator\Robots
     */
    function __construct($helpers, $protocol = 'http', $host = null)
    {
        $this->helpers = $helpers;

        $this->protocol = $protocol;
        $this->host = $host;
    }

    /**
     * Disallow a path for robots
     *
     * @param string $path
     * @return void
     */
    public function disallowPath($path)
    {
        $this->disallowed_paths[] = $path;
    }

    /**
     * Disallow a collection of paths for robots
     *
     * @param object $collection
     * @param string $url_prefix
     * @return void
     */
    public function disallowCollection($collection, $url_prefix = null)
    {
        foreach ( $collection as $path ) {
            $path->prefix = $url_prefix;
        }

        $this->disallowed_collections[] = $collection;
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
     * Generate the robots directives for disallowed collections
     *
     * @return void
     */
    protected function generateDisallowedCollections()
    {
        if ( ! is_null($this->disallowed_collections) ) {
            foreach ( $this->disallowed_collections as $collection ) {
                foreach ( $collection as $path ) {
                    if ( ! is_null($path->prefix) ) {
                        $path->prefix .= '/';
                    }

                    $this->addLine('Disallow: ' . '/' . $path->prefix . $path->slug);
                    $this->addLine('Allow: ' . '/' . $path->prefix . $path->slug . '-');
                }
            }
        }
    }

    /**
     * Generate the robots directives for disallowed paths
     *
     * @return void
     */
    protected function generateDisallowedPaths()
    {
        if ( ! is_null($this->disallowed_paths) ) {
            foreach ( $this->disallowed_paths as $path ) {
                $this->addLine('Disallow: ' . $path);
            }
        }
    }

    /**
     * Generate the sitemap link for robots.txt
     *
     * @param bool $sitemap
     * @return void
     */
    protected function generateSitemapLink($sitemap)
    {
        if ( $sitemap ) {
            $sitemap_link = PHP_EOL
                . 'Sitemap: '
                . $this->helpers->url(
                    'sitemap.xml',
                    $this->protocol,
                    $this->host
                );

            $this->addLine($sitemap_link);
        }
    }

    /**
     * Get the content for the robots.txt file
     *
     * @param bool $sitemap
     * @return string
     */
    public function getRobotsDirectives($sitemap = false)
    {
        $this->addLine('User-agent: *');

        $this->generateDisallowedCollections();
        $this->generateDisallowedPaths();
        $this->generateSitemapLink($sitemap);

        $output = implode(PHP_EOL, $this->lines);

        return $output;
    }

}
