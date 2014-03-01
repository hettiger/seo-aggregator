<?php namespace Hettiger\SeoAggregator\Providers;

use Hettiger\SeoAggregator\Robots;
use Hettiger\SeoAggregator\Support\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SeoAggregatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('hettiger/seo-aggregator');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        App::bind('robots', function()
        {
            $helpers = new Helpers();

            return new Robots($helpers);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}