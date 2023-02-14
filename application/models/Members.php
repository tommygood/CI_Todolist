<?php
    class Member extends CI_Model {
        public function __construct() {
	    $this->load->database();
	}

	public function get_data($slug = FALSE) {
	    if ($slug == FALSE) {
	        $query = $this->db->get('ci_test');
		return $query->result_array();
	    }
	}

	$query = $this->db->get_where('ci_test', array('slug' => $slug));
	return $query->row_array();
    }
?>
