<?php namespace Hettiger\SeoAggregator\Providers;

use \App;
use \Config;
use \Hettiger\SeoAggregator\Robots;
use \Hettiger\SeoAggregator\Sitemap;
use \Hettiger\SeoAggregator\Support\Helpers;
use \Illuminate\Support\ServiceProvider;

class SeoAggregatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	private $protocol;
	private $host;
	private $field_names;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('hettiger/seo-aggregator', null, __DIR__ . '/../../../../src');

		$this->protocol = Config::get('seo-aggregator::protocol');
		$this->host = Config::get('seo-aggregator::host');
		$this->field_names = Config::get('seo-aggregator::fields');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        App::bind('seo-aggregator.sitemap', function()
        {
            return new Sitemap(new Helpers, $this->protocol, $this->host, $this->field_names);
        });

        App::bind('seo-aggregator.robots', function()
        {
            return new Robots(new Helpers, $this->protocol, $this->host, $this->field_names);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return array(
            'seo-aggregator.sitemap',
            'seo-aggregator.robots'
        );
	}

}
