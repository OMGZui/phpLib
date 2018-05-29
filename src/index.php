<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 10:03
 */

namespace OMGZui;
use OMGZui\Str\useStr;

require_once __DIR__ . '/bootstrap.php';

// Str使用
$str = new useStr('  我是1个疯子，有医生开的证明ya  ');
dump($str->get()->trim());
dump($str->get()->length());