<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/7
 * Time: 09:33
 */
namespace Tests\Support;

use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon as BaseCarbon;
use DateTime;
use DateTimeInterface;

class CarbonTest extends TestCase
{
    protected $now;
    protected function setUp()
    {
        parent::setUp();
        Carbon::setTestNow($this->now = Carbon::create(2018, 6, 7, 9, 38, 50, 'PRC'));
    }

    protected function tearDown()
    {
        Carbon::setTestNow();
        Carbon::serializeUsing(null);
        parent::tearDown();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(DateTime::class, $this->now);
        $this->assertInstanceOf(DateTimeInterface::class, $this->now);
        $this->assertInstanceOf(BaseCarbon::class, $this->now);
        $this->assertInstanceOf(Carbon::class, $this->now);
    }

    public function testCarbonIsMacroAbleWhenCalledStatically()
    {
        Carbon::macro('twoDaysAgoAtNoon', function () {
            return Carbon::now()->subDays(2)->setTime(12, 0, 0);
        });
        $this->assertSame('2018-06-05 12:00:00', Carbon::twoDaysAgoAtNoon()->toDateTimeString());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method nonExistingStaticMacro does not exist.
     */
    public function testCarbonRaisesExceptionWhenStaticMacroIsNotFound()
    {
        Carbon::nonExistingStaticMacro();
    }

}