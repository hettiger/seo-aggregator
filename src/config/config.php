<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Fix Protocol and Host
    |--------------------------------------------------------------------------
    |
    | Here you may specify a fix protocol and domain for your sitemap.xml
    | and robots.txt contents. This may help if the $_SERVER['HTTP_HOST']
    | variable is not available on your server. Specifying a protocol will
    | protect you from duplicate content issues you could get with some
    | search engines.
    |
    */

    'protocol'  => 'http', // 'http' or 'https'

    'host'      => null, // 'domain.tld' or null to make the app guess

    /*
    |--------------------------------------------------------------------------
    | Eloquent Model Field Settings
    |--------------------------------------------------------------------------
    |
    | When you generate a sitemap from an Eloquent Model, SEO Aggregator will
    | automatically get all required data from your Model. Here you may specify
    | the field names SEO Aggregator should be looking for. Be aware, if the
    | fields you set here don't exist SEO Aggregator will fail.
    |
    */

    'fields' => array(

        'loc'       => 'slug',
        'lastmod'   => 'updated_at',

    ),


);
