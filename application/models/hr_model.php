<?php 

class hr_model extends CI_Model {

	public function login(){
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$values = array('username' => $username, 'password' => md5($password));
		$query = $this->db->get_where('logins', $values);
		$row = $query->row_array();
	
		
		if($query->num_rows() > 0){
			$this->session->set_userdata('usersession', $row['username']);
			$this->session->set_userdata('credential', $row['is_admin']);
			return true;
		}
		
		return false;
	}

	public function get_emp_detail($data){
		$username = array('username' => $data['usersession']);
		$query = $this->db->get_where('logins', $username);
		$row = $query->row_array();

		$user_id = array('user_id' =>$row['id']);
		$id = array('id' =>$row['id']);

		$data['emp_data'] = $this->db->get_where('employee_data', $user_id)->row_array();
		$data['emp_req'] = $this->db->get_where('employee_req', $user_id)->row_array();
		$data['emp_benef'] = $this->db->get_where('employee_beneficiaries', $user_id)->row_array();
		$data['emp_ei'] = $this->db->get_where('employee_emergency_info', $user_id)->row_array();
		$data['user'] = $this->db->get_where('logins', $id)->row_array();
		return $data;
	}

	public function save_emp($data, $username){
		if ($data['emp_data']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('logins', $user_name);
			$row = $query->row_array();
			$id = array('user_id' => $row['id']);
			$this->db->where($id);
			$this->db->update('employee_data', $data['emp_data']); 
		}
		if ($data['emp_benef']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('logins', $user_name);
			$row = $query->row_array();
			$id = array('user_id' => $row['id']);
			$this->db->where($id);
			$this->db->update('employee_beneficiaries', $data['emp_benef']); 
		}
		if ($data['emp_req']) {
			$user_name = array('username' => $username);
			$query = $this->db->get_where('logins', $user_name);
			$row = $query->row_array();
			$id = array('user_id' => $row['id']);
			$this->db->where($id);
			$this->db->update('employee_req', $data['emp_req']); 
		}
		if ($data['emp_ei']) {
			var_dump($data['emp_ei']);
			$user_name = array('username' => $username);
			$query = $this->db->get_where('logins', $user_name);
			$row = $query->row_array();
			$id = array('user_id' => $row['id']);
			$this->db->where($id);
			$this->db->update('employee_emergency_info', $data['emp_ei']); 
		}

	}

	public function logout(){
		$this->session->unset_userdata('usersession');
		$this->session->unset_userdata('credential');
		$this->session->sess_destroy();
	}
	
	public function getUsersTable(){
		$htmltable = '';
		$query = $this->db->select('emp_id, username')->get('tbl_logins');
		
		foreach($query->result_array() as $row){
			
			$emp_id = $row['emp_id'];
			$username = $row['username'];
			
			$query2 = $this->db->select('company')->get_where('tbl_employee_info', array('emp_id' => $emp_id));
			$row2 = $query2->row_array();
			$company = $row2['company'];
			
			$query3 = $this->db->select('firstname, middlename, lastname')->get_where('tbl_person_info', array('id' => $emp_id));
			$row3 = $query3->row_array();
			$firstname = $row3['firstname'];
			$middlename = $row3['middlename'];
			$lastname = $row3['lastname'];
			
			$htmltable .= '<tr id='.$emp_id.'><td>'.$company.'</td><td>'.$username.'</td><td>'.$lastname.'</td><td>'.$firstname.'</td><td>'.$middlename.'</td><td><a class="printpdf btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> View PDF</a></td><td><a class="edituser btn btn-warning" target="_blank" href=employee_edit?username='.$username.'><span class="glyphicon glyphicon-pencil"></span> Edit</a></td></tr>';
		}
		
		return $htmltable;
		
	}

}