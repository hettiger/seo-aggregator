<?php namespace Hettiger\SeoAggregator;

class RobotsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Robots
     */
    private $robots;

    protected function setUp()
    {
        parent::setUp();

        $this->robots = new Robots;
    }

    public function test_can_disallow_paths()
    {
        $this->robots->disallowPath('foo');
    }

    public function test_can_disallow_collection()
    {
        $this->robots->disallowCollection(array(
            array(
                'foo' => 'bar'
            )
        ));
    }

    public function test_can_request_robots_directives()
    {
        $e = 'User-agent: *';
        $a = $this->robots->getRobotsDirectives();

        $this->assertEquals($e, $a);
    }

}
