<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/6
 * Time: 23:06
 */
namespace Tests\Support;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testStringCanBeLimitedByWords()
    {
        $this->assertEquals('Taylor...', Str::words('Taylor Otwell', 1));
        $this->assertEquals('Taylor___', Str::words('Taylor Otwell', 1, '___'));
        $this->assertEquals('Taylor Otwell', Str::words('Taylor Otwell', 3));
    }

    public function testLimit()
    {
        $this->assertEquals('Laravel is...', Str::limit('Laravel is a free, open source PHP web application framework.', 10));
        $this->assertEquals('这是一...', Str::limit('这是一段中文', 6));
    }
}