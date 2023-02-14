<?php
    class Data extends CI_Controller {
        /*public function __construct() {
	    parent::__construct();
	    $this->load->model('member');
	}*/

	public function index() { // 查看
	    $this->load->model('member');
	    $data['member'] = $this->member->get_data();
	    //$data['title'] = 'member';
	    $this->load->view('header', $data);
	    //redirect($_SERVER['HTTP_REFERER']); // 重整頁面
	}


	public function del() { // 刪除
	    $this->load->model('member');
	    $this->member->del_data();
	    redirect($_SERVER['HTTP_REFERER']); // 重整頁面
	}

	public function create() { // main 
	    $this->load->model('member');
	    $data['member'] = $this->member->get_data();
	    //$data['title'] = 'member';
	    $this->load->view('header', $data);
	    // form
	    $this->load->helper('form');
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name', '內容', 'required');

	    if ($this->form_validation->run() === FALSE) {
		//$this->load->view('success');
		if ($this->input->post('submit') == 'delete' && $this->input->post('del_id')) { // 刪除
		    $this->del();
		}
		if ($this->input->post('submit') == 'update' && $this->input->post('update_id')) { // 更新
		    $this->update();
		}
		if ($this->input->post('submit') == 'detail') { // 細節
		    $this->detail();
		}
		if ($this->input->post('submit') == 'search') { // 細節
		    $this->search();
		}
	    }
	    
	    else {
	        $this->member->set_data();
		redirect($_SERVER['HTTP_REFERER']); // 重整頁面
		$this->load->view('success');
	    }
	} 

	public function update() { // 更新
	    $this->load->model('member');
	    $this->member->update_data();
	    redirect($_SERVER['HTTP_REFERER']); // 重整頁面
	}

	public function test() {
	    $this->load->model('member');
	    $data['member'] = $this->member->get_data();
	    //$data['title'] = 'member';
	    $this->load->view('header', $data);
	}

	public function detail() {
	    $data['member'] = $this->member->detail_data();
	    $this->load->view('detail', $data);
	}   

	public function search() {
	    $data['member'] = $this->member->search_data();
	    $this->load->view('search', $data);
	}
    }
?>
