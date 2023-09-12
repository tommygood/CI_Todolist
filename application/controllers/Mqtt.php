<?php
    class Mqtt extends CI_Controller {
        public function __construct() {
	    parent::__construct();
	    $this->load->model('member');
	    $this->load->library('base');
	}

	public function index() { // 查看
	    $this->load->view('mqtt_main');
	}
    }
?>
