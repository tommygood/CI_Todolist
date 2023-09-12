<?php
require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

$server   = '172.20.10.8';
$port     = 1883;
$clientId = rand(5, 15);
$username = 'emqx_user';
$password = null;
$clean_session = false;

$connectionSettings  = new ConnectionSettings();
$connectionSettings
  ->setUsername($username)
  ->setPassword(null)
  ->setKeepAliveInterval(60)
  ->setLastWillTopic('emqx/test/last-will')
  ->setLastWillMessage('client disconnect')
  ->setLastWillQualityOfService(1);
$mqtt = new MqttClient($server, $port, $clientId);

pcntl_async_signals(true);
pcntl_signal(SIGINT, function (int $signal, $info) use ($mqtt) {
	    $mqtt->interrupt();
});

$mqtt->connect($connectionSettings, $clean_session);
printf("client connected\n");

$mqtt->publish('Rocky', 'Hello World!', 0);

$mqtt->subscribe('Rocky', function ($topic, $message) use ($mqtt) {
	    printf("Received message on topic [%s]: %s\n", $topic, $message);
	    //echo json_encode($mqtt);
	    /*pcntl_signal();
	    $mqtt->exitLoops();
	    $mqtt->disconnect();
	    $mqtt->loop(false);*/
	    //$mqtt->interrput();
	    exit();
}, 0);
$mqtt->loop(true);
$mqtt->disconnect();

