<?php

class login_model extends CI_Model {

	public function login(){
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$is_active = $this->db->select('*')
							  ->from('tbl_logins')
							  ->join('tbl_employee_info', 'tbl_logins.username = tbl_employee_info.emp_code')
							  ->where('username', $username)
							  ->where('is_active', 0)
							  ->get();
		
		$values = array('username' => $username, 'password' => md5($password));
		$query = $this->db->get_where('tbl_logins', $values);
		$row = $query->row_array();
	
		if ($is_active->num_rows() >  0) {
			if($query->num_rows() > 0){
				$this->session->set_userdata('usersession', $row['username']);
				$this->session->set_userdata('credential', $row['role_id']);
				$this->session->set_userdata('userid_session', $row['id']);
				return 1;
			}else{
				return 0;
			}
		}elseif($is_active->num_rows() == 0){
			return 2;
		}
	}

	public function logout(){
		$this->session->sess_destroy();
	}
}