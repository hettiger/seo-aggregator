<?php namespace Hettiger\SeoAggregator;

class Robots implements RobotsInterface {

    protected $disallowed_paths;
    protected $disallowed_collections;

    /**
     * Disallow a path for robots
     *
     * @param string $path
     */
    public function disallowPath($path)
    {
        $this->disallowed_paths[] = $path;
    }

    /**
     * Disallow a collection of paths for robots
     *
     * @param array|object $collection
     * @param string $url_prefix
     */
    public function disallowCollection($collection, $url_prefix = null)
    {
        foreach ( $collection as $path ) {
            $path['prefix'] = $url_prefix;
        }

        $this->disallowed_collections[] = $collection;
    }

    /**
     * Get the content for the robots.txt file
     *
     * TODO Does not take care of disallowed paths yet
     * TODO Does not take care of disallowed collections yet
     * TODO Does not take care of the sitemap yet
     *
     * @param bool $sitemap
     * @return string
     */
    public function getRobotsDirectives($sitemap = false)
    {
        $lines[] = 'User-agent: *';

        $output = implode(PHP_EOL, $lines);

        return $output;
    }

}