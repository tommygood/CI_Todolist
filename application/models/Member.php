<?php
    class Member extends CI_Model {
        public function __construct() {
	    $this->load->database();
	}

	public function get_data($slug = FALSE) {
	    $query = $this->db->get('member');
	    return $query->result_array();
	}

	public function set_data() {
	    $this->load->helper('url');
	    $data = array(
		'name' => $this->input->post('name'),
		'sex' => $this->input->post('sex'),
		'birth' => $this->input->post('birth')
	    );
	    return $this->db->insert('member', $data);
	}

	public function del_data() {
	    $this->load->helper('url');
	    $data = array(
		'id' => $this->input->post('delete_id')
	    );
	    $this->db->where('id', $data['id']);
	    $this->db->delete('member');
	}

	public function update_data() {
	    $this->load->helper('url');
	    $data = array(
		'id' => $this->input->post('user_id'),
		'name' => $this->input->post('name'),
		'sex' => $this->input->post('sex'),
		'birth' => $this->input->post('birth')
	    );
	    $this->db->where('id', $data['id']);
	    $this->db->update('member', $data);
	    //$this->db->delete('member');
	}

	public function detail_data() {
	    $this->load->helper('url');
	    $data = array(
		'id' => $this->input->post('detail_id'),
	    );
	    $this->db->where('id', $data['id']);
	    $detail = '123';
	    $query = $this->db->get('member');
	    return $query->result_array();
	}

	public function search_data() {
	    $this->load->helper('url');
	    $data = array(
		'id' => $this->input->post('search_id')
	    );
	    $this->db->where('name', $data['id']);
	    $query = $this->db->get('member');
	    return $query->result_array();
	}
    }
?>
