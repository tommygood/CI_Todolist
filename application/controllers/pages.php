<?php
    class Pages extends CI_Controller {
        public function view($page = 'home') {
	    if (! file_exists('application/views/'.$page.'.php')) {
		show_404();
	    }

	    $data['title'] = ucfirst($page);
	    $this->load->view('header', $data);
	    $this->load->view($page, $data);
	    $this->load->view('footer', $data);
	}
    }
?>
