<?php namespace Hettiger\SeoAggregator\Interfaces;

interface RobotsInterface {

    /**
     * @param HelpersInterface $helpers
     * @param string $protocol
     * @param null|string $host
     * @param array $field_names
     * @return RobotsInterface
     */
    function __construct($helpers, $protocol = 'http', $host = null, $field_names = array());

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
     * @param object $collection
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
