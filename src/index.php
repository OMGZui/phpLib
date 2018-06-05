<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 10:03
 */

namespace OMGZui;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OMGZui\File\File;
use OMGZui\Obj\objFunc;
use OMGZui\Str\useStr;

require_once __DIR__ . '/bootstrap.php';

echoS(1, '字符串操作');
// Str使用
$str = new useStr('  我是1个疯子，有医生开的证明ya  ');
dump($str->get()->trim());

echoS(2, '魔术方法');

// 魔术方法
$obj = new objFunc();//__construct __destruct
dump($obj);
//echo $obj;//__toString
//print $obj;//__toString
//$obj();//__invoke
//dump(is_callable($obj));//__invoke
//$obj->foo();// __call
//$obj::foo();// __callStatic
//$obj->foo = 100;// __set
//echo $obj->foo;// __get
//isset($obj->foo);// __isset
//unset($obj->foo);// __unset
//$obj_new = clone $obj;// __clone
//dump($obj_new);

echoS(3, '协程yield');

$start = memory_get_usage();
$arr = [];
//$arr = range(1, 1000000);
//for ($i = 1; $i < 1000000; $i++) {
//    $arr[] = $i;
//}

$arr = xRange(1000000);

$end = memory_get_usage();
echo ($end - $start) / 1000 . "kb<br>";

echoS(4, '集合和数组');
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
//dump($col->all() === $arr);
//dump($col->toArray() === $arr);
//dump($col->toJson() === json_encode($arr));
dump(Arr::random($arr));

echoS(5, '文件系统');
$path = '../public/test.txt';
$dir = '../public';
$content = Carbon::now().PHP_EOL;

$file = new File();
$file->append($path, $content);
dump($file->name($path));
dump($file->files($dir));

echoS(6, '配置config');
$config = new Repository();
$config->set('name', 'omgzui');
$config->set('id', '2');
$config->set('age', '25');
dump($config->get('name'));
dump($config->get(['name', 'id', 'age']));
dump($config);

echoS(7, '');
