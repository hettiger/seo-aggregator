<?php namespace Hettiger\SeoAggregator\Facades;

use Illuminate\Support\Facades\Facade;

class Sitemap extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'seo-aggregator.sitemap';
    }

}
