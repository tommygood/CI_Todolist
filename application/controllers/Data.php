<?php
    class Data extends CI_Controller {
        public function __construct() {
	    parent::__construct();
	    $this->load->model('member');
	    $this->load->library('base');
	}

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
	    //$this->load->view('header', $data);
	    //$data['title'] = 'member';
	    // form
	    $this->load->helper('form');
	    $this->load->library('form_validation');
	    //$this->form_validation->set_rules('name', '內容', 'required');

	    if ($this->form_validation->run() === FALSE) {
		//$this->load->view('success');
		if ($this->input->post('submit') == 'delete') { // 刪除
		    $this->del();
	    	    $this->load->view('header', $data);
		}
		if ($this->input->post('submit') == 'update') { // 更新
		    $this->update($this->input->post('update_id'));
		}
		if ($this->input->post('submit') == 'detail') { // 細節
		    $this->detail();
		}
		if ($this->input->post('submit') == 'search') { // 細節
	    	    $this->load->view('header', $data);
		    $this->search();
		}
		if ($this->input->post('submit') == 'add') { // 細節
	            $this->member->set_data();
		    redirect($_SERVER['HTTP_REFERER']); // 重整頁面
		}
	    }
	    
	    else {
	        $this->member->set_data();
		redirect($_SERVER['HTTP_REFERER']); // 重整頁面
		$this->load->view('success');
	    }
	} 

	public function update($id) { // 更新
	    //$this->load->model('member');
	    //$this->member->update_data();
	    //redirect($_SERVER['HTTP_REFERER']); // 重整頁面
	    $data['user_id'] = $id;
	    $this->load->view('update', $data);
	}

	public function test() {
	    $this->load->model('member');
	    $data['member'] = $this->member->get_data();
	    //$data['title'] = 'member';
	    $this->load->view('header', $data);
	}

	public function update_data() {
	    $this->load->model('member');
	    $this->member->update_data();
	    $this->test();
	}

	public function detail() {
	    $data['member'] = $this->member->detail_data();
	    $this->load->view('detail', $data);
	}   

	public function search() {
	    $data['member'] = $this->member->search_data();
            $this->base->v->assign('test', '123');
            $this->base->v->assign('member',$data);
            $this->base->v->display('search.html');
	    //$this->load->view('search', $data);
	}
    }
?>
