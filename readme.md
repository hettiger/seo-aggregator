## SEO Aggregator

[![Latest Stable Version](https://poser.pugx.org/hettiger/seo-aggregator/version.png)](https://packagist.org/packages/hettiger/seo-aggregator) [![Build Status](https://travis-ci.org/hettiger/seo-aggregator.png?branch=master)](https://travis-ci.org/hettiger/seo-aggregator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/badges/quality-score.png?s=51d0f6f08bc4f4f905d34bd633ccbecdb04cfdc0)](https://scrutinizer-ci.com/g/hettiger/seo-aggregator/) [![License](https://poser.pugx.org/hettiger/seo-aggregator/license.png)](https://packagist.org/packages/hettiger/seo-aggregator)

Generate sitemap.xml and robots.txt files in Laravel or any PHP Application with ease.

This package allows you throwing [Eloquent Models](https://github.com/illuminate/database) at it in order to generate
sitemap.xml + robots.txt files. It is mainly desired for use with [Laravel 4](http://laravel.com). Anyways it's
developed with the whole PHP Community in mind.

### Brief Example for Usage with Laravel 4

```php
$collection = Pages::all();

Sitemap::addCollection($collection, 'url-prefix');

return Response::make(Sitemap::getSitemapXml())
    ->header('Content-Type', 'text/xml');
```

### Documentation

The Documentation can be found [here](docs/index.md).

If you have any Problems with the Documentation please open an Issue.

### Require with Composer – Current Suggestion:

```js
// composer.json

"require": {
    "php": ">=5.4.0",
    "hettiger/seo-aggregator": "1.1.*",
    // ...
},
```

#### Version Numbers

An Update is always considered safe on changes regarding the last digit of the Version Number. Never update when the
first or second digit has changed without looking into the [Release Notes](release-notes.md).

| Versions | Laravel compatibility | PHP compatibility |
| -------- | --------------------- | ----------------- |
| 1.1.*    | Laravel 4.2           | HHVM, 5.4+        |
| 1.0.*    | Laravel 4.1           | 5.3+              |
| 0.\*.*   | Laravel 4.1           | 5.3+              |

### License

SEO Aggregator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
