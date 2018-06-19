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
use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{

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