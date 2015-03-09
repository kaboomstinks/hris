<?php

class login_model extends CI_Model {

	public function login(){
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		// ORIGINAL QUERY
		// $is_active = $this->db->select('*')
							  // ->from('tbl_logins')
							  // ->join('tbl_employee_info', 'tbl_logins.username = tbl_employee_info.emp_code')
							  // ->where('username', $username)
							  // ->where('is_active', 0)
							  // ->get();
		$is_active = $this->db->select('a.emp_id,a.emp_code,a.username,a.password,a.role_id,b.emp_id,b.is_active as `is_active`')
												->from('tbl_logins a')
												->join('tbl_employee_info b','a.username = b.emp_code')
												 ->where('a.username',$username)
												//->where('b.is_active', 0)
												->get();		
		$values = array('username' => $username, 'password' => md5($password));
		$query = $this->db->get_where('tbl_logins', $values);
		$row = $query->row_array();
		// if ($is_active->num_rows() >  0) {
		// 	if($query->num_rows() > 0){
		// 		$this->session->set_userdata('usersession', $row['username']);
		// 		$this->session->set_userdata('credential', $row['role_id']);
		// 		$this->session->set_userdata('userid_session', $row['id']);
		// 		return 1;
		// 	}else{
		// 		return 0;
		// 	}
		// }elseif($is_active->num_rows() == 0){
		// 	return 2;
		// }
		
		
		$res = $is_active->row_array();
		$is_active_r = 0;
		if(isset($res['is_active']) && $res['is_active'] == 1){
			$is_active_r = 1;
		}
	
		if($is_active_r  == 1){
			return 3;   // deactivated
		}elseif ($is_active->num_rows() >  0) {   // is still active
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