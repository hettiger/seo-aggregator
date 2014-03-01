<?php namespace Hettiger\SeoAggregator\Facades;

use Illuminate\Support\Facades\Facade;

class Robots extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'seo-aggregator.robots';
    }

}
