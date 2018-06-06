<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/6
 * Time: 22:13
 */
namespace Tests\Log;

use Illuminate\Log\Logger;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class LoggerTest extends TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testMethodsPassErrorAdditionsToMonolog()
    {
        $writer = new Logger($monolog = m::mock('Monolog\Logger'));
        $monolog->shouldReceive('error')->once()->with('foo', []);

        $writer->error('foo');
    }
}