## SEO Aggregator

[![Latest Stable Version](https://poser.pugx.org/hettiger/seo-aggregator/version.png)](https://packagist.org/packages/hettiger/seo-aggregator) [![Build Status](https://travis-ci.org/hettiger/seo-aggregator.png?branch=master)](https://travis-ci.org/hettiger/seo-aggregator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/badges/quality-score.png?s=51d0f6f08bc4f4f905d34bd633ccbecdb04cfdc0)](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/) [![License](https://poser.pugx.org/hettiger/seo-aggregator/license.png)](https://packagist.org/packages/hettiger/seo-aggregator)

Generate sitemap.xml and robots.txt files in Laravel or any PHP Application with ease.

This package allows you throwing [Eloquent Models](https://github.com/illuminate/database) at it in order to generate sitemap.xml + robots.txt files. It is mainly desired for use with [Laravel 4](http://laravel.com). Anyways it's developed with the whole PHP Community in mind :-)

### Documentation

Take a look [here](docs/index.md) ;-)

### Version Numbers

The first digit hits '1' when the package has reached all initial goals. After that it will only go up on complete rewrites. The second digit rises whenever an update comes with some heavy changes that could break your existing code. (Make sure to read the release notes before updating) The third digit is presenting minor changes that don't tend to break your existing code. None of these are limited in any way. A version number like 1.134.22 would be perfectly fine.

Current suggestion on how to add this package in your composer.json file: 

    "require": {
        "php": ">=5.3.0",
        "hettiger/seo-aggregator": "0.1.*",
        // ...
    },

### License

SEO Aggregator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
