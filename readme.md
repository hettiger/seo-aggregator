## SEO Aggregator

[![Latest Stable Version](https://poser.pugx.org/hettiger/seo-aggregator/version.png)](https://packagist.org/packages/hettiger/seo-aggregator) [![Build Status](https://travis-ci.org/hettiger/seo-aggregator.png?branch=master)](https://travis-ci.org/hettiger/seo-aggregator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/badges/quality-score.png?s=51d0f6f08bc4f4f905d34bd633ccbecdb04cfdc0)](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/) [![License](https://poser.pugx.org/hettiger/seo-aggregator/license.png)](https://packagist.org/packages/hettiger/seo-aggregator)

Automatically generate sitemap.xml and robots.txt files with ease.

This package allows you throwing [Eloquent Models](https://github.com/illuminate/database) at it in order to generate sitemap.xml + robots.txt files. It is mainly desired for use with [Laravel 4](http://laravel.com). Anyways it's developed with the whole PHP Community in mind :-)

###### Warning

This package hast not yet been optimized for the use with [Laravel 4](http://laravel.com). (Which doesn't mean you couldn't use it already)

### Version Numbers

The first digit hits '1' when the package has reached all initial goals. After that it will only go up on complete rewrites. The second digit rises whenever an update comes with some heavy changes that could break your existing code. (Make sure to read the release notes before updating) The third digit is presenting minor changes that don't tend to break your existing code. None of these are limited in any way. A version number like 1.134.22 would be perfectly fine.

Current suggestion on how to add this package in your composer.json file: 

    "require": {
        "php": ">=5.3.0",
        "hettiger/seo-aggregator": "0.1.*",
        // ...
    },

### Usage

I know this is far from a good documentation but since this package is very small I'm pretty sure it will suit your needs.)

###### Note on the following code examples

I know the creation of collections and adding links to them seems pretty verbose. Dont worry thought ...! Theres no reason creating collections yourself! I just did it in the examples so you get a better understanding of what is happening and how the output is being generated.

As a [Laravel 4](http://laravel.com) user you would just throw your [Eloquent Models](https://github.com/illuminate/database) at the class which is described further on. If you're not using [Laravel 4](http://laravel.com) forget about collections and have a look at the following code. It could lead you on the right track:

	// Sitemap
	foreach ( $array_of_links as $link ) {
		$sitemap->addLink($link['slug'], $link['date_time']);
	}
	
	// Robots Directives
	foreach ( $array_of_links as $link ) {
		$robots->disallowPath('/' . $link['slug']);
	}

#### Sitemap

##### Generate your sitemap.xml file contents

	header('Content-Type: ' . 'text/xml');
	
	// Setup
	$helpers = new Hettiger\SeoAggregator\Support\Helpers;
    $sitemap = new Hettiger\SeoAggregator\Sitemap($helpers);
    
    // Prepare data for the lastmod tag
    $date_time = new DateTime('now');
    
    // Add a single Link
    $sitemap->addLink('foo/bar', $date_time);
    
    // Create a new Collection
    $collection = new ArrayObject;
    
    // Add Links to the Collection
    $collection->append((object) array(
    	'slug' => 'foo',
    	'updated_at' => $date_time
    ));
    
    $collection->append((object) array(
    	'slug' => 'bar',
        'updated_at' => $date_time
    ));
    
    // Add the Collection with a URL Prefix (The prefix can be omitted)
    $sitemap->addCollection($collection, 'prefix');
    
    // Echo out the sitemap.xml contents
    echo $sitemap->getSitemapXml();

##### Output for the example above

	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		<url>
			<loc>http://domain.tld/foo/bar</loc>
			<lastmod>2014-02-27</lastmod>
		</url>
		<url>
			<loc>http://domain.tld/prefix/foo</loc>
			<lastmod>2014-02-27</lastmod>
		</url>
		<url>
			<loc>http://domain.tld/prefix/bar</loc>
			<lastmod>2014-02-27</lastmod>
		</url>
	</urlset>

##### I want https and a fix domain

	// Setup
	$helpers = new Helpers;
	$sitemap = new Sitemap($helpers, 'https', 'domain.tld');
	
You can always define protocol and domain during setup.
	
##### Throw an Eloquent Model at it

	$collection = Pages::all();
	
	$sitemap->addCollection($collection);

The Eloquent Model must have a field called 'slug' and one called 'updated_at' for this to work. If it doesn't you may want to extend the Sitemap class and overwrite the protected function iterateCollection().

#### Robots Directives

##### Generate your robots.txt file contents

	header('Content-Type: ' . 'text/plain');
	
	// Setup
	$helpers = new Hettiger\SeoAggregator\Support\Helpers;
    $robots = new Hettiger\SeoAggregator\Robots($helpers);

	// Create a new Collection
    $collection = new ArrayObject;

	// Add Links to the Collection
    $collection->append((object) array(
        'slug' => 'foo'
    ));

    $collection->append((object) array(
        'slug' => 'bar'
    ));

	// Disallow the Collection with a URL Prefix (The prefix can be omitted)
    $robots->disallowCollection($collection, 'prefix');
    
    // Disallow a single Path
    $robots->disallowPath('/foo-bar');

	// Echo out the robots.txt file contents with a link to your sitemap
    echo $robots->getRobotsDirectives(true);

##### Output for the example above

	User-agent: *
	Disallow: /prefix/foo
	Allow: /prefix/foo-
	Disallow: /prefix/bar
	Allow: /prefix/bar-
	Disallow: /foo-bar

	Sitemap: http://domain.tld/sitemap.xml
	
##### Why those Allow statements?

This package is desiered for use with "Pretty URLs". See this discussion at [StackOverflow](http://stackoverflow.com/questions/21367853/pretty-urls-and-robots-txt) for more information.

If you don't aggree with this at all or want some completely different output you can always extend the Robots class and overwrite the protected function iterateDisallowedCollection().

##### I want https and a fix domain

	// Setup
	$helpers = new Helpers;
    $robots = new Robots($helpers, 'https', 'domain.tld');
    
You can always define protocol and domain during setup.

##### Throw an Eloquent Model at it

	$collection = Pages::all();

    $robots->disallowCollection($collection);
    
The Eloquent Model must have a field called 'slug' for this to work. If it doesn't you may want to extend the Robots class and overwrite the protected function iterateDisallowedCollection().

##### Omitting the Sitemap Link

In case you don't provide a sitemap.xml file for robots we've got you covered.

	// Omitting the Sitemap Link
	$robots->getRobotsDirectives();
	
#### I need more help!

You might want to have a look at the packages tests. I'm pretty sure these will help you!

### License

SEO Aggregator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
