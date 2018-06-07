<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/7
 * Time: 11:50
 */

namespace OMGZui\Func;

class Func
{
    public function __construct()
    {
    }

    // call_user_func — 把第一个参数作为回调函数调用
    // 第一个参数 callback 是被调用的回调函数，其余参数是回调函数的参数。
    public function callUserFunc()
    {
    }

    public static function vv($type)
    {
        dump("You wanted a $type haircut, no problem");
    }
}