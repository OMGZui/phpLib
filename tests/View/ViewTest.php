<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/25
 * Time: 15:36
 */

namespace Tests\View;

use Mockery as m;
use Illuminate\View\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testDataCanBeSetOnView()
    {
        $view = $this->getView();
        $view->with('foo', 'bar')->with(['baz' => 'boom']);
        $this->assertEquals(['foo' => 'bar', 'baz' => 'boom'], $view->getData());

        $view = $this->getView();
        $view->withFoo('bar')->withBaz('boom');
        $this->assertEquals(['foo' => 'bar', 'baz' => 'boom'], $view->getData());

    }

    public function testRenderProperlyRendersView()
    {
        $view = $this->getView(['foo' => 'bar']);
        $view->getFactory()->shouldReceive('incrementRender')->once()->ordered();
        $view->getFactory()->shouldReceive('callComposer')->once()->ordered()->with($view);
        $view->getFactory()->shouldReceive('getShared')->once()->andReturn(['shared' => 'foo']);
        $view->getEngine()->shouldReceive('get')->once()->with('path', ['foo' => 'bar', 'shared' => 'foo'])->andReturn('contents');
        $view->getFactory()->shouldReceive('decrementRender')->once()->ordered();
        $view->getFactory()->shouldReceive('flushStateIfDoneRendering')->once();

        $callback = function (View $rendered, $contents) use ($view) {
            $this->assertEquals($view, $rendered);
            $this->assertEquals('contents', $contents);
        };

        $this->assertEquals('contents', $view->render($callback));
    }


    protected function getView($data = [])
    {
        return new View(
            m::mock('Illuminate\View\Factory'),
            m::mock(\Illuminate\Contracts\View\Engine::class),
            'view',
            'path',
            $data
        );
    }

}