<?php namespace Hettiger\SeoAggregator;

interface RobotsInterface {

    /**
     * @param HelpersInterface $helpers
     * @param string $protocol
     * @param null|string $host
     * @return \Hettiger\SeoAggregator\RobotsInterface
     */
    function __construct($helpers, $protocol = 'http', $host = null);

    /**
     * Disallow a path for robots
     *
     * @param string $path
     * @return void
     */
    public function disallowPath($path);

    /**
     * Disallow a collection of paths for robots
     *
     * @param array|object $collection
     * @param string $url_prefix
     * @return void
     */
    public function disallowCollection($collection, $url_prefix = null);

    /**
     * Get the content for the robots.txt file
     *
     * @param bool $sitemap
     * @return string
     */
    public function getRobotsDirectives($sitemap = false);

}
