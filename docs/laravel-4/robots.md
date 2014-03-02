## Robots

For Laravel 4

### Disallow single Paths

    Robots::disallowPath('/foo-bar');

You can do this anywhere in your App.

#### Output for the above Example:

    ...
    Disallow: /foo-bar
    ...

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### Disallow an Eloquent Models Links

    $collection = Pages::all();

    // Disallow the Collection with a URL Prefix (The prefix can be omitted)
    Robots::disallowCollection($collection, 'prefix');

You can do this anywhere in your App but be aware... The Eloquent Model must have a field called 'slug' for this to
work. If you run into trouble you could always do a foreach() with single Paths thought...

#### Output will be something like this:

    ...
    Disallow: /prefix/foo
    Allow: /prefix/foo-
    Disallow: /prefix/bar
    Allow: /prefix/bar-
    ...

Why those Allow Statements? Well your Laravel App is probably using "Pretty URLs" ... See this discussion at
[StackOverflow](http://stackoverflow.com/questions/21367853/pretty-urls-and-robots-txt) for more information.

Be aware that running this method itself won't output anything. It's just saving the data into memory so it can be
accessed once needed.

### How to publish the generated contents

You basically need to set the correct HTTP Header, set the desired directives and echo out the output.

#### Example:

    // Set the correct HTTP Header
    header('Content-Type: ' . 'text/plain');

    // Set the desired directives
    Robots::disallowPath('/foo');
    Robots::disallowPath('/bar');

    // Echo out the output
    echo Robots::getRobotsDirectives(true);

#### Output for the above Example:

    User-agent: *
    Disallow: /foo
    Disallow: /bar

    Sitemap: http://domain.tld/sitemap.xml

#### Where do I put this?

Well I don't care ... :-)

I guess you could do this in a controller... Just make sure this is being executed when someone requests
domain.tld/robots.txt

### Adding a Link to the Sitemap

I hope the difference is self explaining...

#### Generate the robots.txt contents WITHOUT a Link to the Sitemap:

    Robots::getRobotsDirectives();

#### Generate the robots.txt contents WITH a Link to the Sitemap:

    Robots::getRobotsDirectives(true);
