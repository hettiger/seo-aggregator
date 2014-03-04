## Basics

For Laravel 4

### Installation

Require this package with [Composer](https://getcomposer.org) and update your dependencies.

[How should i require this package?](https://github.com/hettiger/seo-aggregator/blob/master/readme.md#require-with-composer--current-suggestion)

#### Registration of the ServiceProvider

```php
// app/config/app.php

'providers' => array(

    // ...

    'Hettiger\SeoAggregator\Providers\SeoAggregatorServiceProvider',

);
```

Now run following terminal command from your Laravel 4 App root:

    php artisan dump-autoload

#### Registration of the Aliases

```php
// app/config/app.php

'aliases' => array(

    // ...

    'Robots'    => 'Hettiger\SeoAggregator\Facades\Robots',
    'Sitemap'   => 'Hettiger\SeoAggregator\Facades\Sitemap',

);
```

Now run following terminal command from your Laravel 4 App root:

    php artisan dump-autoload

### Configuration

Here's a quick overview of the options SEO Aggregator provides:

* Fix Protocol and Host

* Eloquent Model Field Settings

Have a look at the file `src/config/config.php` for more information.

#### How can I customize the Configuration?

Publish the configuration so you can make changes:

    php artisan config:publish hettiger/seo-aggregator

Once this is done your configuration file is located here:

    app/config/packages/hettiger/seo-aggregator/config.php

The configuration file is self explaining.
