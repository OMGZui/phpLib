<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/16
 * Time: 14:54
 */

namespace Tests\Routing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{

    public function testBasicDispatchingOfRoutes()
    {
        $router = $this->getRouter();
        $router->get('foo/bar', function () {
            return 'hello';
        });
        $this->assertEquals('hello', $router->dispatch(Request::create('foo/bar', 'GET'))->getContent());

        $router->post('foo/bar', function () {
            return 'post hello';
        });
        $this->assertEquals('post hello', $router->dispatch(Request::create('foo/bar', 'POST'))->getContent());

    }


    public function testControllerClosureMiddleware()
    {
        $router = $this->getRouter();
        $router->get('foo/bar', [
            'uses' => 'Tests\Routing\RouteTestClosureMiddlewareController@index',
            'middleware' => 'foo',
        ]);
        $router->aliasMiddleware('foo', function ($request, $next) {
            $request['foo-middleware'] = 'foo-middleware';

            return $next($request);
        });

        $this->assertEquals(
            'index-foo-middleware-controller-closure',
            $router->dispatch(Request::create('foo/bar', 'GET'))->getContent()
        );
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Route for [foo/bar] has no action.
     */
    public function testFluentRouting()
    {
        $router = $this->getRouter();
        $router->get('foo/bar')->uses(function () {
            return 'middleware';
        })->middleware('Tests\Routing\RouteTestControllerMiddleware');
        $this->assertEquals('middleware', $router->dispatch(Request::create('foo/bar', 'GET'))->getContent());
        $this->assertContains('Tests\Routing\RouteTestControllerMiddleware', $router->getCurrentRoute()->middleware());

        $router->get('foo/bar');
        $router->dispatch(Request::create('foo/bar', 'GET'));
    }

    public function testFluentRoutingWithControllerAction()
    {
        $router = $this->getRouter();
        $router->get('foo/bar')->uses('Tests\Routing\RouteTestControllerStub@index');
        $this->assertEquals('Hello World', $router->dispatch(Request::create('foo/bar', 'GET'))->getContent());

        $router = $this->getRouter();
        $router->group(['namespace' => 'App'], function ($router) {
            $router->get('foo/bar')->uses('Tests\Routing\RouteTestControllerStub@index');
        });
        $action = $router->getRoutes()->getRoutes()[0]->getAction();
        $this->assertEquals('App\Tests\Routing\RouteTestControllerStub@index', $action['controller']);
    }

    public function testMatchesMethodAgainstRequests()
    {
        $request = Request::create('foo/bar', 'GET');
        $route = new Route('GET', 'foo/{bar}', function () {
        });
        $this->assertTrue($route->matches($request));

    }

    public function testRouteRedirect()
    {
        $router = $this->getRouter();
        $router->get('contact_us', function () {
            throw new \Exception('Route should not be reachable.');
        });
        $router->redirect('contact_us', 'contact', 302);

        $response = $router->dispatch(Request::create('contact_us', 'GET'));
        $this->assertTrue($response->isRedirect('contact'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    protected function getRouter()
    {
        $container = new Container();

        $router = new Router(new Dispatcher(), $container);

        $container->singleton(Registrar::class, function () use ($router) {
            return $router;
        });

        return $router;
    }

}

class RouteTestClosureMiddlewareController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $response = $next($request);

            return $response->setContent(
                $response->content().'-'.$request['foo-middleware'].'-controller-closure'
            );
        });
    }

    public function index()
    {
        return 'index';
    }
}

class RouteTestControllerMiddleware
{
    public function handle($request, $next)
    {
        $_SERVER['route.test.controller.middleware'] = true;
        $response = $next($request);
        $_SERVER['route.test.controller.middleware.class'] = get_class($response);

        return $response;
    }
}

class RouteTestControllerStub extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return 'Hello World';
    }
}
