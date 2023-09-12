<?php

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;
class Mqtt {
	
 
	public function Message() {
		//$client = new Mosquitto\Client();
		//$client = new MqttClient();
		$mqtt = new MqttClient($server, $port, $clientId);

		
		$client->onConnect(function($code, $message) use ($client) {
			var_dump($code);
			var_dump($message);
			$client->subscribe("LXBSERVER",0);   //订阅LXBSERVER主题
		});
		
		$client->onMessage(function($message) use($client,$service){
 
			$msg = trim($message->payload);
			echo bin2hex($msg)."|";   //如果和硬件通讯时,这里的msg需要将字符转换成16进制数据
            $msg = strtoupper($msg);
            $client->publish("LXBSERVER2","hello world",0);  //向LXBSERVER2主题发送消息
        });
		$client->connect('127.0.0.1', 1883);
		$client->loopForever();
	}
}
 
 
$mqtt = new Mqtt();
 
$mqtt->Message();
?>
