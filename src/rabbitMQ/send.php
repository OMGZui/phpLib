<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/9/4
 * Time: 17:41
 */

namespace OMGZui\RabbitMQ;
require '../bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 创建连接
$con = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $con->channel();

// 声明队列
$channel->queue_declare('hello', false, false, false, false);

$word = ($argc > 1) ? "$argv[0]-$argv[1]" : $argv[0];
$msg = new AMQPMessage($word);
//$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent {$word}\n";

// 关闭资源
$channel->close();
$con->close();