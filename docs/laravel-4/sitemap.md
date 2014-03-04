## Sitemap

For Laravel 4

### Adding single Links

```php
// Prepare data for the lastmod tag
$date_time = new DateTime('now');
```

We need some data for the lastmod tag. Have a read about the
[DateTime Class](http://www.php.net/manual/en/class.datetime.php) if you're stuck on this...

```php
// Add a single Link
Sitemap::addLink('foo/bar', $date_time);
```

You can do this anywhere in your App.

#### Output for the above Example:

    ...
    <url>
        <loc>http://domain.tld/foo/bar</loc>
        <lastmod>2014-03-02</lastmod>
    </url>
    ...

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### Adding an Eloquent Models Links

```php
$collection = Pages::all();

// Add the Collection with a URL Prefix (The prefix can be omitted)
Sitemap::addCollection($collection, 'prefix');
```

You can do this anywhere in your App but be aware... The Eloquent Model must have fields providing the data for the
`<loc>...</loc>` and `<lastmod>...</lastmod>` tags. (Defaults are `'slug'` and `'updated_at'`) You can set the field
names in the configuration if your database schema differs from the defaults. If you run into trouble you could always
do a `foreach()` with single Links thought...

#### Output will be something like this:

    <url>
        <loc>http://domain.tld/prefix/foo</loc>
        <lastmod>2014-03-02</lastmod>
    </url>
    <url>
        <loc>http://domain.tld/prefix/bar</loc>
        <lastmod>2014-03-02</lastmod>
    </url>

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### How to publish the generated contents

You basically need to set the correct HTTP Header, set the desired links and echo out the output.

#### Example:

```php
// Set the correct HTTP Header
header('Content-Type: ' . 'text/xml');

// Prepare data for the lastmod tag
$date_time = new DateTime('now');

// Set the desired links
Sitemap::addLink('foo', $date_time);
Sitemap::addLink('bar', $date_time);

// Echo out the output
echo Sitemap::getSitemapXml();
```

#### Output for the above example:

    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>http://intranet.dev/foo</loc>
            <lastmod>2014-03-02</lastmod>
        </url>
        <url>
            <loc>http://intranet.dev/bar</loc>
            <lastmod>2014-03-02</lastmod>
        </url>
    </urlset>

#### Where do I put this?

Well I don't care ... :-)

I guess you could do this in a controller... Just make sure this is being executed when someone requests
`domain.tld/sitemap.xml`
