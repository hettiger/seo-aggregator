<?php namespace Hettiger\SeoAggregator\Interfaces;

interface HelpersInterface {

    /**
     * Get the full URL to a given path
     * (e.g. //domain.tld/path)
     *
     * @param string $path
     * @param string $protocol
     * @param null|string $host
     * @return string
     */
    public function url($path, $protocol = 'http', $host = null);

}
