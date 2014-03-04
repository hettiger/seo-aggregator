<?php namespace Hettiger\SeoAggregator;

use \Hettiger\SeoAggregator\Support\Helpers;
use \Mockery as m;
use \ArrayObject;

class RobotsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Mockery\Mock
     */
    private $helpers;

    protected function setUp()
    {
        parent::setUp();

        $this->helpers = m::mock('Hettiger\SeoAggregator\Support\Helpers');
    }

    protected function tearDown()
    {
        parent::tearDown();

        m::close();
    }

    public function test_can_disallow_paths()
    {
        $robots = new Robots($this->helpers);

        $robots->disallowPath('foo');
    }

    public function test_can_disallow_collection()
    {
        $robots = new Robots($this->helpers);
        $collection = new ArrayObject;

        $collection->append((object) array(
            'foo' => 'bar'
        ));

        $robots->disallowCollection($collection);
    }

    public function test_can_request_robots_directives()
    {
        $robots = new Robots($this->helpers);

        $e = 'User-agent: *';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_with_sitemap_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers);

        $e = 'User-agent: *' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_providing_protocol_and_host()
    {
        $helpers = new Helpers;
        $robots = new Robots($helpers, 'http', 'domain.tld');

        $e = 'User-agent: *' . PHP_EOL . PHP_EOL . 'Sitemap: http://domain.tld/sitemap.xml';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_one_disallowed_path()
    {
        $robots = new Robots($this->helpers);
        $robots->disallowPath('/foo');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_one_disallowed_path_and_sitemap_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers);
        $robots->disallowPath('/foo');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_multiple_disallowed_paths()
    {
        $robots = new Robots($this->helpers);
        $robots->disallowPath('/foo');
        $robots->disallowPath('/bar');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo' . PHP_EOL . 'Disallow: /bar';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_multiple_disallowed_paths_and_sitemap_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers);
        $robots->disallowPath('/foo');
        $robots->disallowPath('/bar');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo' . PHP_EOL
            . 'Disallow: /bar' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_one_disallowed_collection()
    {
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection);

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /bar' . PHP_EOL . 'Allow: /bar-';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_one_disallowed_collection_and_sitemap_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection);

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /bar' . PHP_EOL
            . 'Allow: /bar-' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_one_disallowed_collection_with_prefix()
    {
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection, 'prefix');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /prefix/bar' . PHP_EOL . 'Allow: /prefix/bar-';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_multiple_disallowed_collections()
    {
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'foo'
        ));

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection);

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo' . PHP_EOL . 'Allow: /foo-'
            . PHP_EOL . 'Disallow: /bar' . PHP_EOL . 'Allow: /bar-';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_multiple_disallowed_collections_and_sitemap_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'foo'
        ));

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection);

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo' . PHP_EOL . 'Allow: /foo-'
            . PHP_EOL . 'Disallow: /bar' . PHP_EOL . 'Allow: /bar-' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_considering_multiple_disallowed_collections_with_prefix()
    {
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'foo'
        ));

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection, 'prefix');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /prefix/foo' . PHP_EOL . 'Allow: /prefix/foo-'
            . PHP_EOL . 'Disallow: /prefix/bar' . PHP_EOL . 'Allow: /prefix/bar-';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_robots_directives_with_a_mix_of_all_features()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'slug'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'slug' => 'foo'
        ));

        $collection->append((object) array(
            'slug' => 'bar'
        ));

        $robots->disallowCollection($collection, 'prefix');
        $robots->disallowPath('/foo-bar');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /prefix/foo' . PHP_EOL . 'Allow: /prefix/foo-'
            . PHP_EOL . 'Disallow: /prefix/bar' . PHP_EOL . 'Allow: /prefix/bar-'
            . PHP_EOL . 'Disallow: /foo-bar' . PHP_EOL . PHP_EOL . 'Sitemap: url';
        $a = $robots->getRobotsDirectives(true);

        $this->assertEquals($e, $a);
    }

    public function test_can_set_field_name()
    {
        $robots = new Robots($this->helpers, 'http', null, array('loc' => 'loc'));
        $collection = new ArrayObject;

        $collection->append((object) array(
            'loc' => 'bar'
        ));

        $robots->disallowCollection($collection);

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /bar' . PHP_EOL . 'Allow: /bar-';
        $a = $robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

}
