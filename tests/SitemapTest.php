<?php namespace Hettiger\SeoAggregator;

use \Hettiger\SeoAggregator\Support\Helpers;
use \Mockery as m;
use \ArrayObject;
use \DateTime;

class SitemapTest extends \PHPUnit_Framework_TestCase {

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

    public function test_can_add_links()
    {
        $sitemap = new Sitemap($this->helpers);

        $sitemap->addLink('foo', new DateTime('now'));
    }

    public function test_can_add_collections()
    {
        $sitemap = new Sitemap($this->helpers);
        $collection = new ArrayObject;

        $collection->append((object) array(
            'foo' => 'bar'
        ));

        $sitemap->addCollection($collection);
    }

    public function test_can_request_sitemap_xml()
    {
        $sitemap = new Sitemap($this->helpers);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_one_link()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $sitemap = new Sitemap($this->helpers);

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $sitemap->addLink('foo', $date_time);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_one_link_providing_protocol_and_host()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld');

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $sitemap->addLink('foo', $date_time);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_multiple_links()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $sitemap = new Sitemap($this->helpers);

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $sitemap->addLink('foo', $date_time);
        $sitemap->addLink('bar', $date_time);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_multiple_links_providing_protocol_and_host()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld');

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $sitemap->addLink('foo', $date_time);
        $sitemap->addLink('bar', $date_time);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/bar</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_one_collection()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $sitemap = new Sitemap($this->helpers, 'http', null, array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_one_collection_providing_protocol_and_host()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld', array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/bar</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_one_collection_and_prefix()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld', array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection, 'prefix');

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/prefix/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/prefix/bar</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_multiple_collections()
    {
        $this->helpers->shouldReceive('url')->andReturn('url');
        $sitemap = new Sitemap($this->helpers, 'http', null, array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>url</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_multiple_collections_providing_protocol_and_host()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld', array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo1',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar1',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo2',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar2',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/foo1</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/bar1</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/foo2</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/bar2</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_multiple_collections_and_multiple_prefixes()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld', array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo1',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar1',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection, 'pre1');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo2',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar2',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection, 'pre2');

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/pre1/foo1</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/pre1/bar1</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/pre2/foo2</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/pre2/bar2</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_request_sitemap_xml_with_a_mix_of_all_features()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'https', 'domain.tld', array(
            'loc'       => 'slug',
            'lastmod'   => 'updated_at'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $sitemap->addLink('test', $date_time);

        $collection = new ArrayObject;
        $collection->append((object) array(
            'slug' => 'foo',
            'updated_at' => $date_time
        ));
        $collection->append((object) array(
            'slug' => 'bar',
            'updated_at' => $date_time
        ));

        $sitemap->addCollection($collection, 'prefix');

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>https://domain.tld/test</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/prefix/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '<url>'
            . '<loc>https://domain.tld/prefix/bar</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

    public function test_can_set_field_names()
    {
        $helpers = new Helpers;
        $sitemap = new Sitemap($helpers, 'http', 'domain.tld', array(
            'loc'       => 'loc',
            'lastmod'   => 'lastmod'
        ));

        $date_time = new DateTime('now');
        $date_time_formatted = date_format($date_time, 'Y-m-d');

        $collection = new ArrayObject;
        $collection->append((object) array(
            'loc' => 'foo',
            'lastmod' => $date_time
        ));

        $sitemap->addCollection($collection);

        $e = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url>'
            . '<loc>http://domain.tld/foo</loc>'
            . '<lastmod>' . $date_time_formatted . '</lastmod>'
            . '</url>'
            . '</urlset>';
        $a = $sitemap->getSitemapXml();

        $this->assertEquals($e, $a);
    }

}
