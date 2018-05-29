<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 14:49
 */
namespace Tests;

use OMGZui\Str\useStr;
use PHPUnit\Framework\TestCase;

class strTest extends TestCase
{
    public function testLength()
    {
        $str = '  我是1个疯子，有医生开的证明ya  ';
        $s = new useStr($str);
        $this->assertEquals($str, $s->get());
        $this->assertEquals(mb_strlen($str), $s->get()->length());
        $this->assertEquals(mb_strlen(trim($str)), $s->get()->trim()->length());
    }
}