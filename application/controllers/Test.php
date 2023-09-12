<?php
    use \PhpMqtt\Client\MqttClient;
    use \PhpMqtt\Client\ConnectionSettings;
    class Test extends CI_controller {
	    public function __construct() {
	        parent::__construct();
	        $this->load->library('base');
	    }	    

        /*public function index()
        {
            $test='ci 3.0.3   smarty 3.1.27 配置成功';
            $this->base->v->assign('test',$test);
            $this->base->v->display('test.html');
        }*/

	    public function index() { // 查看
	        $this->load->view('mqtt_main');
        }

	    public function sendMqtt() {
            require('vendor/autoload.php');
	        try {
                //$requestData = json_decode(file_get_contents('php://input'), true);
	            $test_a = $this->input->post('a');
	            //$all_input = $this->input->post();

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

                $mqtt->connect($connectionSettings, $clean_session);
                //printf("client connected\n");

                $mqtt->publish('Rocky', $test_a, 0);

                $mqtt->disconnect();
                var_dump($test_a);
            }
	       catch(e) {
		        var_dump($e);
	        }
	    }

	    public function getMqtt() {
            require('vendor/autoload.php');
	        try {
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
                $mqtt->registerLoopEventHandler(function (MqttClient $mqtt, float $elapsedTime) {
                    if ($elapsedTime >= 10) {
                        //print "Killing since we never got a topic!";
                        $mqtt->interrupt();
                    }
                });

                $mqtt->connect($connectionSettings, $clean_session);
                $mqtt->subscribe('Rocky', function ($topic, $message) use ($mqtt) {
                    printf($message);
	                exit();
                }, 0);

                $mqtt->loop(true);

                $mqtt->disconnect();
            }
	       catch(e) {
		        var_dump($e);
	        }
	    }
    }
?>

