<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/22
 * Time: 14:25
 */

namespace Tests\Routing;

use Mockery as m;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

class RouteRegistrarTest extends TestCase
{

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    public function setUp()
    {
        parent::setUp();

        $this->router = new Router(m::mock(Dispatcher::class), Container::getInstance());
    }

    public function tearDown()
    {
        m::close();
    }

    public function testMiddlewareFluentRegistration()
    {
        $this->router->middleware(['one', 'two'])->get('users', function () {
            return 'all-users';
        });

        $this->seeResponse('all-users', Request::create('users', 'GET'));
        $this->assertEquals(['one', 'two'], $this->getRoute()->middleware());

    }

    protected function seeResponse($content, Request $request)
    {
        $route = $this->getRoute();

        $this->assertTrue($route->matches($request));

        $this->assertEquals($content, $route->bind($request)->run());
    }

    protected function getRoute()
    {
        return last($this->router->getRoutes()->get());
    }


}