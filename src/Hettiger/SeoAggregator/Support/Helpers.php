<?php namespace Hettiger\SeoAggregator\Support;

use Hettiger\SeoAggregator\Interfaces\HelpersInterface;

class Helpers implements HelpersInterface {

    /**
     * Get the full URL to a given path
     * (e.g. //domain.tld/path)
     *
     * @param string $path
     * @param string $protocol
     * @param null|string $host
     * @return string
     */
    public function url($path, $protocol = 'http', $host = null)
    {
        if ( is_null($host) ) {
            $host = $_SERVER['HTTP_HOST'];
        }

        return $protocol . '://' . $host . '/' . $path;
    }

}
