<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/14
 * Time: 21:46
 */

namespace Test\Pipeline;

use Illuminate\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;
use Closure;

class PipelineTest extends TestCase
{
    public function testPipelineBasicUsage()
    {
        $pipeTwo = function ($piped, $next) {
            $_SERVER['__test.pipe.two'] = $piped;

            return $next($piped);
        };

        $result = (new Pipeline(new \Illuminate\Container\Container))
            ->send('foo')
            ->through([PipelineTestPipeOne::class, $pipeTwo])
            ->then(function ($piped) {
                return $piped;
            });
        $this->assertEquals('foo', $result);
        $this->assertEquals('foo', $_SERVER['__test.pipe.one']);
        $this->assertEquals('foo', $_SERVER['__test.pipe.two']);

        unset($_SERVER['__test.pipe.one']);
        unset($_SERVER['__test.pipe.two']);
    }

    public function testPipe()
    {
        $pipe1 = function ($poster, Closure $next) {
            $poster += 1;
//            $_SERVER['__test.pipe.one1'] = $poster;
//            $_SERVER['__test.pipe.one2'] = $next($poster);
            return $next($poster);
        };

        $pipe2 = function ($poster, Closure $next) {
            if ($poster > 7) {
                return $poster;
            }

            $poster += 3;
//            $_SERVER['__test.pipe.two1'] = $poster;
//            $_SERVER['__test.pipe.two2'] = $next($poster);
            return $next($poster);
        };

        $pipe3 = function ($poster, Closure $next) {
            $result = $next($poster);
//            $_SERVER['__test.pipe.three1'] = $poster;
//            $_SERVER['__test.pipe.three2'] = $result;
//            $_SERVER['__test.pipe.three3'] = $result * 2;
            return $result * 2;
        };

        $pipe4 = function ($poster, Closure $next) {
            $poster += 2;
//            $_SERVER['__test.pipe.four1'] = $poster;
//            $_SERVER['__test.pipe.four2'] = $next($poster);
            return $next($poster);
        };

        $pipes = [$pipe1, $pipe2, $pipe3, $pipe4];

        function dispatcher($poster, $pipes)
        {
            return (new Pipeline())
                ->send($poster)
                ->through($pipes)
                ->then(function ($poster) {
                    return $poster;
                });
        }

        $this->assertEquals(14, dispatcher(1, $pipes));
//        dump($_SERVER['__test.pipe.one1']);
//        dump($_SERVER['__test.pipe.one2']);
//        dump($_SERVER['__test.pipe.two1']);
//        dump($_SERVER['__test.pipe.two2']);
//        dump($_SERVER['__test.pipe.three1']);
//        dump($_SERVER['__test.pipe.three2']);
//        dump($_SERVER['__test.pipe.three3']);
//        dump($_SERVER['__test.pipe.four1']);
//        dump($_SERVER['__test.pipe.four2']);
        $this->assertEquals(8, dispatcher(7, $pipes));
    }
}

class PipelineTestPipeOne
{
    public function handle($piped, $next)
    {
        $_SERVER['__test.pipe.one'] = $piped;

        return $next($piped);
    }

    public function differentMethod($piped, $next)
    {
        return $next($piped);
    }
}