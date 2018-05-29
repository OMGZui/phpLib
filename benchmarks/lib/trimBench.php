<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 11:16
 */

namespace Bench;

use OMGZui\Str\useStr;

class trimBench
{
    private $num = 1000000;

    public function benchTrim()
    {
        $str = new useStr();
        $str->get()->trim();
    }

    public function benchFor()
    {
        $n = 0;
        for ($i = 0; $i < $this->num; $i++) {
            $n++;
        }
    }

    public function benchWhile()
    {
        $n = 0;
        $i = 0;
        while ($i < $this->num) {
            $i++;
            $n++;
        }
    }
}