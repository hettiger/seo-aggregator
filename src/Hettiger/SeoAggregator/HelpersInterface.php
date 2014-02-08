<?php namespace Hettiger\SeoAggregator;

interface HelpersInterface {

    /**
     * Get the full URL to a given path
     * (e.g. //domain.tld/path)
     *
     * @param string $path
     * @return string
     */
    public function url($path);

}
