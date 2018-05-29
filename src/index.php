<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 10:03
 */

namespace OMGZui;

use OMGZui\Obj\objFunc;
use OMGZui\Str\useStr;

require_once __DIR__ . '/bootstrap.php';

// Str使用
$str = new useStr('  我是1个疯子，有医生开的证明ya  ');
dump($str->get()->trim());

echo "------------------------ 1 ------------------------<br>";

// 魔术方法
$obj = new objFunc();//__construct __destruct
dump($obj);
echo $obj;//__toString
print $obj;//__toString
$obj();//__invoke
dump(is_callable($obj));//__invoke
$obj->foo();// __call
$obj::foo();// __callStatic
$obj->foo = 100;// __set
echo $obj->foo;// __get
isset($obj->foo);// __isset
unset($obj->foo);// __unset
$obj_new = clone $obj;// __clone
dump($obj_new);
echo "------------------------ 2 ------------------------<br>";
$start = memory_get_usage();
$arr = [];
//$arr = range(1, 1000000);
//for ($i = 1; $i < 1000000; $i++) {
//    $arr[] = $i;
//}

$arr = xRange(1000000);

$end = memory_get_usage();
echo ($end - $start) / 1000 . "kb<br>";

foreach ($arr as $n => $item) {
    if ($n < 10)
    {
        echo $item;
    }
}

function xRange($n = 1000000)
{
    for ($i = 1; $i < $n; $i++) {
        yield $i;
    }
}