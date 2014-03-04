## Basics

For any PHP App

### Installation

#### If you already use Composer to handle your Dependencies

Require this package with [Composer](https://getcomposer.org) and update your dependencies.

[How should i require this package?](https://github.com/hettiger/seo-aggregator/blob/master/readme.md#require-with-composer--current-suggestion)

#### If you're not using Composer yet

Download this package and place it anywhere in your app. Once thats done you'll need to install it following these
simple instructions:

Please be aware that the following terminal commands could change by time. Make sure to check the documentation of
[Composer](https://getcomposer.org) if something goes wrong or if you're not on a *nix System.

##### On *nix Systems run the following commands from the packages root:

    curl -sS https://getcomposer.org/installer | php

    php composer.phar install --no-dev

##### If you want you could now remove composer even thought I don't suggest to do so:

    rm composer.phar
    
If you remove `composer.phar` you'll need to install it again once you'd like to update the package.

##### Require the autoloaded classes in your App:

```php
require_once __DIR__ . 'path/to/package/vendor/autoload.php';
```

This will take care of loading in the needed classes for you. You can place it anywhere in your App. Just make sure this
is executed before you're starting to use the package.

### Setup

Following code demonstrates how to setup everything so you can begin generating your `sitemap.xml` or `robots.txt`
contents. You can put this code anywhere in your app.

##### Load the Helpers

```php
$helpers = new Hettiger\SeoAggregator\Support\Helpers;
```

##### Setup Sitemap

```php
$sitemap = new Hettiger\SeoAggregator\Sitemap($helpers);
```

##### Setup Robots

```php
$robots = new Hettiger\SeoAggregator\Robots($helpers);
```
    
#### I want https and a fixed domain

```php
$sitemap = new Hettiger\SeoAggregator\Sitemap($helpers, 'https', 'domain.tld');

$robots = new Hettiger\SeoAggregator\Robots($helpers, 'https', 'domain.tld');
```
	
You can always define a fixed protocol and domain during setup.
