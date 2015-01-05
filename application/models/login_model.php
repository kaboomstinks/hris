<?php

class login_model extends CI_Model {

	public function login(){
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$values = array('username' => $username, 'password' => md5($password));
		$query = $this->db->get_where('tbl_logins', $values);
		$row = $query->row_array();
	
		
		if($query->num_rows() > 0){
			$this->session->set_userdata('usersession', $row['username']);
			$this->session->set_userdata('credential', $row['role_id']);
			$this->session->set_userdata('userid_session', $row['id']);
			return true;
		}
		
		return false;
	}

	public function logout(){
		$this->session->sess_destroy();
	}
}