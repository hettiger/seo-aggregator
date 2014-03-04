## Robots

For any PHP App

### Disallow single Paths

```php
$robots->disallowPath('/foo-bar');
```

You can do this anywhere in your App. Just make sure you've setup everything before execution.

#### Output for the above Example:

    ...
    Disallow: /foo-bar
    ...

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### Disallow many Paths

Well you probably guessed it... :-) You would just do something like:

```php
foreach ( $array_of_paths as $path ) {
    $robots->disallowPath('/' . $path);
}
```

### How to publish the generated contents

You basically need to set the correct HTTP Header, set the desired directives and echo out the output.

#### Example:

```php
// Set the correct HTTP Header
header('Content-Type: ' . 'text/plain');

// Setup
$helpers = new Hettiger\SeoAggregator\Support\Helpers;
$robots = new Hettiger\SeoAggregator\Robots($helpers, 'http', 'domain.tld');

// Set the desired directives
$robots->disallowPath('/foo');
$robots->disallowPath('/bar');

// Echo out the output
echo $robots->getRobotsDirectives(true);
```

In this example we did the Setup which could be done elsewhere too. As long as you have access to the `$robots` variable
when setting the directives and generating the output everything will be fine.

#### Output for the above Example:

    User-agent: *
    Disallow: /foo
    Disallow: /bar

    Sitemap: http://domain.tld/sitemap.xml

#### Where do I put this?

Well I don't care ... :-)

I guess you could do this in a controller... Just make sure this is being executed when someone requests
`domain.tld/robots.txt`

### Adding a Link to the Sitemap

I hope the difference is self explaining...

#### Generate the robots.txt contents WITHOUT a Link to the Sitemap:

```php
$robots->getRobotsDirectives();
```

#### Generate the robots.txt contents WITH a Link to the Sitemap:

```php
$robots->getRobotsDirectives(true);
```
