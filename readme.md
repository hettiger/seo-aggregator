## SEO Aggregator

[![Latest Stable Version](https://poser.pugx.org/hettiger/seo-aggregator/version.png)](https://packagist.org/packages/hettiger/seo-aggregator) [![Build Status](https://travis-ci.org/hettiger/seo-aggregator.png?branch=master)](https://travis-ci.org/hettiger/seo-aggregator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/badges/quality-score.png?s=51d0f6f08bc4f4f905d34bd633ccbecdb04cfdc0)](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/) [![License](https://poser.pugx.org/hettiger/seo-aggregator/license.png)](https://packagist.org/packages/hettiger/seo-aggregator)

Automatically generate sitemap.xml and robots.txt files with ease.

This package aims to allow you throwing [Eloquent Models](https://github.com/illuminate/database) at it and generate sitemap.xml + robots.txt files for you. It is mainly desired for use with [Laravel 4](http://laravel.com). Anyways it's developed with the whole PHP Community in mind :-)

###### Warning

This package is still at an early stage of development. We're missing the complete functionality for generating a sitemap at this time. Anyways the master branch and tagged versions are considered stable and can be used. Once the sitemap generator is done this package will be optimized for use with [Laravel 4](http://laravel.com). (Which doesn't mean you couldn't use it already)

### Usage

I know this is far from a good documentation but since this package is very small I'm pretty sure it will suit your needs.

#### Robots Directives

##### Generate your robots.txt file contents

	header('Content-Type: ' . 'text/plain');
	
	// Setup
	$helpers = new Hettiger\SeoAggregator\Helpers;
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

	Sitemap: http://intranet.dev/sitemap.xml
	
##### Why those Allow statements?

This package is desiered for use with "Pretty URLs". See this discussion at [StackOverflow](http://stackoverflow.com/questions/21367853/pretty-urls-and-robots-txt) for more information.

If you don't aggree with this at all or want some completely different output you can always extend the Robots class.

##### I want https and a fix domain

	// Setup
	$helpers = new Helpers;
    $robots = new Robots($helpers, 'https', 'domain.tld');
    
You can always define protocol and domain during setup.

##### Throw an Eloquent Model at it

	$collection = Pages::all();

    $robots->disallowCollection($collection);
    
The Eloquent Model must have a field called 'slug' for this to work. If it doesn't you may want to extend the Robots class and overwrite the protected function iterateDisallowedCollection().

##### Warning

For now you should either provide your own sitemap.xml file or generate your robots directives like this:

	// Omit the Sitemap Link
	$robots->getRobotsDirectives();
	
#### I need more help!

You might want to have a look at the packages tests. I'm pretty sure these will help you!

### License

SEO Aggregator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
