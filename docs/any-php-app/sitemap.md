## Sitemap

For any PHP App

### Adding single Links

```php
// Prepare data for the lastmod tag
$date_time = new DateTime('now');
```

We need some data for the `<lastmod>...</lastmod>` tag. Have a read about the
[DateTime Class](http://www.php.net/manual/en/class.datetime.php) if you're stuck on this...

```php
// Add a single Link
$sitemap->addLink('foo/bar', $date_time);
```

You can do this anywhere in your App. Just make sure you've setup everything before execution.

#### Output for the above Example:

    ...
    <url>
        <loc>http://domain.tld/foo/bar</loc>
        <lastmod>2014-03-02</lastmod>
    </url>
    ...

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### Adding many Links

Well you probably guessed it... :-) You would just do something like:

```php
foreach ( $array_of_links as $link ) {
    $sitemap->addLink($link['slug'], $link['date_time']);
}
```

### How to publish the generated contents

You basically need to set the correct HTTP Header, set the desired links and echo out the output.

#### Example:

```php
// Set the correct HTTP Header
header('Content-Type: ' . 'text/xml');

// Setup
$helpers = new Hettiger\SeoAggregator\Support\Helpers;
$sitemap = new Hettiger\SeoAggregator\Sitemap($helpers, 'http', 'domain.tld');

// Prepare data for the lastmod tag
$date_time = new DateTime('now');

// Set the desired links
$sitemap->addLink('foo', $date_time);
$sitemap->addLink('bar', $date_time);

// Echo out the output
echo $sitemap->getSitemapXml();
```

In this example we did the Setup which could be done elsewhere too. As long as you have access to the `$sitemap`
variable when setting the links and generating the output everything will be fine.

#### Output for the above example:

    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>http://domain.tld/foo</loc>
            <lastmod>2014-03-02</lastmod>
        </url>
        <url>
            <loc>http://domain.tld/bar</loc>
            <lastmod>2014-03-02</lastmod>
        </url>
    </urlset>

#### Where do I put this?

Well I don't care ... :-)

I guess you could do this in a controller... Just make sure this is being executed when someone requests
`domain.tld/sitemap.xml`
