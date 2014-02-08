<?php namespace Hettiger\SeoAggregator;

use \Mockery as m;

class RobotsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Mockery\Mock
     */
    private $helpers;

    protected function setUp()
    {
        parent::setUp();

        $this->helpers = m::mock('Hettiger\SeoAggregator\Helpers');
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

        $robots->disallowCollection(array(
            array(
                'foo' => 'bar'
            )
        ));
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

    public function test_can_request_robots_directives_considering_one_disallowed_paths()
    {
        $robots = new Robots($this->helpers);
        $robots->disallowPath('/foo');

        $e = 'User-agent: *' . PHP_EOL . 'Disallow: /foo';
        $a = $robots->getRobotsDirectives();

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

}
