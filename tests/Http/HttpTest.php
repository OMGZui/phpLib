<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/8
 * Time: 10:01
 */
namespace Tests\Http;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class HttpTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testRootMethod()
    {
        $request = Request::create('http://example.com/foo/bar/script.php?test');
        $this->assertEquals('http://example.com', $request->root());
    }

    /**
     * @dataProvider segmentProvider
     */
    public function testSegmentMethod($path, $segment, $expected)
    {
        $request = Request::create($path, 'GET');
        $this->assertEquals($expected, $request->segment($segment, 'default'));
    }

    public function segmentProvider()
    {
        return [
            ['', 1, 'default'],
            ['foo/bar//baz', '1', 'foo'],
            ['foo/bar//baz', '2', 'bar'],
            ['foo/bar//baz', '3', 'baz'],
        ];
    }

}