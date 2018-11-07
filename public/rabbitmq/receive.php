<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('172.17.0.1', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('SMS', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
  echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('SMS', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
