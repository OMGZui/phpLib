<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 14:48
 */

if (!function_exists('xRange'))
{
    function xRange($n = 1000000)
    {
        for ($i = 1; $i < $n; $i++) {
            yield $i;
        }
    }
}

if (!function_exists('echoS'))
{
    function echoS($n = 1)
    {
        echo "------------------------ $n ------------------------<br>";
    }
}