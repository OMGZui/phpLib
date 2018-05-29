<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 10:07
 */

namespace OMGZui\Str;

use Str\Str;

class useStr
{
    private $str;
    public function __construct(string $str)
    {
        $this->str = $this->init($str);
    }

    private function init(string $str): Str
    {
        return Str::make($str);
    }

    public function get()
    {
        return $this->str;
    }

    public function trim()
    {
        return $this->str->trim();
    }

}