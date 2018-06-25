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

    public function testCanLimitMethodsOnRegisteredResource()
    {
        $this->router->resource('users', 'Tests\Routing\RouteRegistrarControllerStub')
            ->only('index', 'show', 'destroy');

        $this->assertCount(3, $this->router->getRoutes());

        $this->assertTrue($this->router->getRoutes()->hasNamedRoute('users.index'));
        $this->assertTrue($this->router->getRoutes()->hasNamedRoute('users.show'));
        $this->assertTrue($this->router->getRoutes()->hasNamedRoute('users.destroy'));
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

class RouteRegistrarControllerStub
{
    public function index()
    {
        return 'controller';
    }

    public function destroy()
    {
        return 'deleted';
    }
}
