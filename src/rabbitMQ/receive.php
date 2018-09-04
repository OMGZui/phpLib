<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/9/4
 * Time: 17:47
 */

namespace OMGZui\RabbitMQ;
require '../bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$con = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $con->channel();
$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
