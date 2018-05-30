<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 10:03
 */

namespace OMGZui;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OMGZui\Obj\objFunc;
use OMGZui\Str\useStr;

require_once __DIR__ . '/bootstrap.php';

// Str使用
$str = new useStr('  我是1个疯子，有医生开的证明ya  ');
dump($str->get()->trim());

echoS(1);

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

echoS(2);

$start = memory_get_usage();
$arr = [];
//$arr = range(1, 1000000);
//for ($i = 1; $i < 1000000; $i++) {
//    $arr[] = $i;
//}

$arr = xRange(1000000);

$end = memory_get_usage();
echo ($end - $start) / 1000 . "kb<br>";

echoS(3);
$ss = Str::random();
dump(Str::upper($ss));
dump(Str::title($ss));

$arr = [
    [
        'id' => 90,
        'age' => 200
    ],
    [
        'id' => 2,
        'age' => 100
    ],
    [
        'id' => 200,
        'age' => -100
    ],
];

$col = new Collection($arr);
dump($col);
dump($col->all() === $arr);
dump($col->toArray() === $arr);
dump($col->toJson() === json_encode($arr));

dump(Arr::random($arr));