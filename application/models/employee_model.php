<?php 

class employee_model extends CI_Model {	

	public function get_emp_detail($data){
		$username = array('username' => $data['usersession']);
		$query = $this->db->get_where('tbl_logins', $username);
		$row = $query->row_array();

		$employee_id = array('id' =>$row['emp_id']);
		$id = array('emp_id' =>$row['emp_id']);

		$data['emp_pi'] = $this->db->get_where('tbl_person_info', $employee_id)->row_array();
		$data['emp_ei'] = $this->db->get_where('tbl_employee_info', $id)->row_array();
		$data['emp_emerg'] = $this->db->get_where('tbl_employee_emergency_info', $id)->row_array();
		$data['user'] = $this->db->get_where('tbl_logins', $id)->row_array();
		return $data;
	}
	
	public function fixTime($fulldate){
		
		$ftime = substr($fulldate, 11, 8);	// this gets the time part of the whole datetime
		$t = substr($ftime, 0, 5); //removes am or pm
		
		$find = 'am';
		$stringfound = strpos($ftime, $find);   // find am (string) in the whole time
		
			
		if($stringfound === false){                // if it was not found add 12 hours to the time    
			$timestamp = strtotime($t) + 3600*12;
			$newtime = date('H:i', $timestamp);
		} else {
			$newtime = $t;                         // if it was found retain the value of time in $t    
		}
		
		return $newtime;	
	}
	
	public function insertLeave(){
		$emp_code = $this->input->post('emp_code');
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$emp_id  = $getThisID->row_array();
		$id = $emp_id['emp_id'];
		$date_filed = strtotime($this->input->post('datefiled'));
		$reason = $this->input->post('emp_reason');
		$type = $this->input->post('emp_type');
		
		$begindate = $this->input->post('begindate');
		$fbdate = substr($begindate, 0, 10);       // this gets the date part of the whole datetime
		$date_from = date('Y-m-d', strtotime($fbdate)); // format it to yyyy-mm-dd
		
		$enddate = $this->input->post('enddate');
		$fedate = substr($enddate, 0, 10); 		   // this gets the date part of the whole datetime
		$date_to = date('Y-m-d', strtotime($fedate));   // format it to yyyy-mm-dd
		
		$time_from = $this->fixTime($begindate);
		$time_to = $this->fixTime($enddate);
	
			
			$data = array(	
				'emp_id' => $id,
				'emp_code' => $emp_code,
				'date_filed' => $date_filed,
				'date_from' => $date_from,
				'time_from' => $time_from,
				'date_to' => $date_to,
				'time_to' => $time_to,
				'reason' => $reason,
				'type' => $type,
				'status' => 2
			);
			$this->db->insert('tbl_leaves', $data);
			$rID = $this->db->insert_id();
			return $rID;
	}

	public function save_emp($data, $username){
		if ($data['emp_pi']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('tbl_logins', $user_name);
			$row = $query->row_array();
			$id = array('id' => $row['emp_id']);
			$this->db->where($id);
			$this->db->update('tbl_person_info', $data['emp_pi']); 
		}
		if ($data['emp_ei']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('tbl_logins', $user_name);
			$row = $query->row_array();
			$id = array('emp_id' => $row['emp_id']);
			$this->db->where($id);
			$this->db->update('tbl_employee_info', $data['emp_ei']); 
		}
		if ($data['emp_emerg']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('tbl_logins', $user_name);
			$row = $query->row_array();
			$id = array('emp_id' => $row['emp_id']);
			$this->db->where($id);
			$this->db->update('tbl_employee_emergency_info', $data['emp_emerg']); 
		}
		if ($data['user']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('tbl_logins', $user_name);
			$row = $query->row_array();
			$id = array('emp_id' => $row['emp_id']);

			$new_data_user = array(
				'password' => md5($data['user']['password'])
				);

			$this->db->where($id);
			$this->db->update('tbl_logins', $new_data_user); 
		}

	}

	public function get_dep(){
		
		$this->db->select('*')
				 ->from('tbl_departments');

		$departments = $this->db->get()->result_array();

		return $departments;
	}

	public function insertRequest() {
		$emp_code = $this->session->userdata['usersession'];
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$idFromDB  = $getThisID->row_array();
		$emp_id = $idFromDB['emp_id'];
		$date_filed = strtotime($this->input->post('datefiled'));
		$purpose = $this->input->post('emp_purpose');
		$reason = $this->input->post('emp_reason');

		$data = array(
			'id' => NULL,
			'emp_id' => $emp_id,
			'emp_code' => $emp_code,
			'date_filed' => $date_filed,
			'purpose' => $purpose,
			'reason' => $reason,
			'status' => 2
			);
		$this->db->insert('tbl_request', $data);
	}

}