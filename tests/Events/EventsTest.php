<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/16
 * Time: 15:32
 */
namespace Tests\Events;

use Illuminate\Events\Dispatcher;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class EventsTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testBasicEventExecution()
    {
        unset($_SERVER['__event.test']);
        $d = new Dispatcher();
        $d->listen('foo', function ($foo) {
            $_SERVER['__event.test'] = $foo;
        });
        $d->fire('foo', ['bar']);
        $this->assertEquals('bar', $_SERVER['__event.test']);
    }

}