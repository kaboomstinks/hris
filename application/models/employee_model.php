<?php 

class employee_model extends CI_Model {	

	public function get_emp_detail($data){
		$username = array('username' => $data['usersession']);
		$query = $this->db->get_where('tbl_logins', $username);
		$row = $query->row_array();

		$employee_id = array('id' =>$row['emp_id']);
		$id = array('emp_id' =>$row['emp_id']);

		$data['emp_pi'] = $this->db->get_where('tbl_person_info', $employee_id)->row_array();
		$data['emp_ei'] = $this->db->select('*')
								   ->join('tbl_company', 'tbl_employee_info.employer = tbl_company.id', 'inner')
								   ->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id', 'inner')
								   ->where('tbl_employee_info.id', $row['emp_id'])
								   ->get('tbl_employee_info')
								   ->row_array();
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

	public function getAllShift(){
		$emp_id = $this->input->post('emp_id');
		$html = '';
	
		$getShiftRecords = $this->db->order_by('created_at', 'DESC')->get_where('emp_shift_rec', array('emp_id' => $emp_id));
		$record = $getShiftRecords->num_rows(); 		

		if($record){
			
			foreach($getShiftRecords->result_array() as $s) {
				
			 	$effective_date = $s['shift_effect_date'];
				$new_shift = $s['new_shift'];
				$id = $s['id'];

				$shift_effect_date = date('m/d/Y', strtotime($effective_date));

				if($new_shift == 1){
					$start_time = '8:00 - 17:00';
				} elseif ($new_shift == 2){
					$start_time = '16:00 - 01:00';
				}else {
					$start_time = '9:00 - 18:00';	
				}

				$html .= "<tr id=$id>";
				$html .= "<td>$id</td>";
			 	$html .= "<td>$shift_effect_date</td>";
				$html .= "<td>$start_time</td>";
				$html .= "<td align='center'><button class='btn btn-warning editshift'>Edit</button>&nbsp;&nbsp;<button class='btn btn-danger deleteshift'>Delete</button></td>";
				$html .= "</tr>";
			}

		} else {
			$html .= "&nbsp;&nbsp;No Shift History";
		}

		 return $html;	
	}

	public function addNewShift(){
		$new_shift = $this->input->post('newshift');
		$effective_date = $this->input->post('effective_date');
		$shift_effect_date = date('Y-m-d', strtotime($effective_date));
		$shift_remarks = $this->input->post('shift_remarks');
		$emp_id = $this->input->post('emp_id');
		$updated_by = $this->session->userdata['usersession'];

	 	$values = array('emp_id' => $emp_id, 'shift_effect_date' => $shift_effect_date, 'new_shift' => $new_shift, 'shift_remarks' => $shift_remarks, 'updated_by' => $updated_by);
	 	$this->db->insert('emp_shift_rec', $values);
	 	$id = $this->db->insert_id();

	 	if($id){
	 		$response = array('success' => 1, 'msg' => 'Succesfully Saved');
	 	} else {
	 		$response = array('success' => 0, 'msg' => 'Failed to Save');
	 	}

	 	return $response;
	}

	public function getNewShiftRecord(){
		$id = $this->input->post('id');
		$query = $this->db->get_where('emp_shift_rec', array('id' => $id));
		$row = $query->row_array();

		$shift_effect_date = date('m/d/Y', strtotime($row['shift_effect_date']));

		$data = array('new_shift' => $row['new_shift'], 'effective_date' => $shift_effect_date, 'shift_remarks' => $row['shift_remarks']);
		return $data;
	}	

	public function updateNewShift(){
		$id = $this->input->post('recID');
		$new_shift = $this->input->post('newshift');
		$effective_date = $this->input->post('effective_date');
		$shift_effect_date = date('Y-m-d', strtotime($effective_date));
		$shift_remarks = $this->input->post('shift_remarks');
		$updated_by = $this->session->userdata['usersession'];

		$values = array('shift_effect_date' => $shift_effect_date, 'new_shift' => $new_shift, 'shift_remarks' => $shift_remarks, 'updated_by' => $updated_by);

		$this->db->where('id', $id);
		$this->db->update('emp_shift_rec', $values);

		if($this->db->affected_rows() > 0){
			return array("success" => 1, "msg" => "Succesfully Updated!");
		} else {
			return array("success" => 0, "msg" => "No changes have been made");
		}	
	}

	public function deleteNewShift(){
		$id = $this->input->post('id');
		$query = $this->db->delete('emp_shift_rec', array('id' => $id));

		if($query){
			return array("success" => 1, "msg" => "Succesfully Deleted");
		} else {
			return array("success" => 0, "msg" => "Failed to Delete");
		}	
	}

	// start of changesched functions

	public function getAllChangesched(){
		$emp_id = $this->input->post('emp_id');
		$html = '';

		$getChangeschedRecords = $this->db->order_by('created_at', 'DESC')->get_where('tbl_changesched', array('emp_id' => $emp_id, 'changetype' => 1));+

		$record = $getChangeschedRecords->num_rows();

		if($record){
			foreach ($getChangeschedRecords->result_array() as $c) {
				$d_from = date('m/d/Y', strtotime($c['date_from']));
				$d_to = date('m/d/Y', strtotime($c['date_to']));
				$id = $c['id'];
				
				if($c['status']){
					$status = 'Approved';
				} else {
					$status = 'Denied';
				}	

				$html .= "<tr id='$id'>";
				$html .= "<td>$d_from</td>";
				$html .= "<td>$d_to</td>";
				$html .= "<td>$status</td>";
				$html .= "<td align='center'><button class='btn btn-warning editchangesched'>Edit</button>&nbsp;&nbsp;<button class='btn btn-danger deletechangesched'>Delete</button></td>";
				$html .= "</tr>";
			}
		}else {
			$html .= "&nbsp;&nbsp;No Change Schedule History";
		}

		return $html;
	}
	
	public function addNewChangeSched(){
		$emp_id = $this->input->post('emp_id');
		$emp_code = $this->input->post('emp_code');
		$date_filed = strtotime($this->input->post('datefiled'));
		$approval = $this->input->post('emp_approval');
		$changetype = $this->input->post('changetype');
		$updatedby = $this->session->userdata['usersession'];
		$totalhours = $this->input->post('totalhours');
		$remarks = $this->input->post('remarks');
		
		$beginsched = $this->input->post('beginsched');
		$fbdate = substr($beginsched, 0, 10);       // this gets the date part of the whole datetime
		$date_from = date('Y-m-d', strtotime($fbdate)); // format it to yyyy-mm-dd
		
		$endsched = $this->input->post('endsched');
		$fedate = substr($endsched, 0, 10); 		   // this gets the date part of the whole datetime
		$date_to = date('Y-m-d', strtotime($fedate));   // format it to yyyy-mm-dd

		$t_from = substr($beginsched, 11,8);
		$t_to = substr($endsched, 11,8);
		
		$time_from = date("H:i a", strtotime($t_from));
		$time_to = date("H:i a", strtotime($t_to));

	 	$values = array(
				'emp_id' => $emp_id,
				'emp_code' => $emp_code,
				'date_filed' => $date_filed,
				'date_from' => $date_from,
				'time_from' => $time_from,
				'date_to' => $date_to,
				'time_to' => $time_to,
				'changetype' => $changetype,
				'status' => $approval,
				'totalhours' => $totalhours,
				'remarks' => $remarks,
				'updated_by' => $updatedby
				);

			$this->db->insert('tbl_changesched', $values);
			$cid = $this->db->insert_id();

	 	if($cid){
	 		$response = array('success' => 1, 'msg' => 'Succesfully Saved');
	 	} else {
	 		$response = array('success' => 0, 'msg' => 'Failed to Save');
	 	}

	 	return $response;
		
		
	}
	
	public function getNewChangeSchedRecord(){
		$id = $this->input->post('id');
		$query = $this->db->get_where('tbl_changesched', array('id' => $id));
		$row = $query->row_array();

		$datefiled = date("m/d/Y h:i a", $row['date_filed']);
	
		$d_from = $row['date_from'].' '.$row['time_from'];
		$d_to = $row['date_to'].' '.$row['time_to'];
		
		$date_from = date("m/d/Y h:i a", strtotime($d_from));
		$date_to = date("m/d/Y h:i a", strtotime($d_to));

		$data = array(
			'datefiled' => $datefiled,
			'date_from' => $date_from,
			'date_to' => $date_to,
			'changetype' => $row['changetype'],
			'status' => $row['status'],
			'totalhours' => $row['totalhours'],
			'remarks' => $row['remarks']
			);

		return $data;
	}
	
	public function updateNewChangeSched(){
		$id = $this->input->post('recID1');
		$emp_code = $this->input->post('emp_code');
		$emp_id = $this->input->post('emp_id');
		$remarks = $this->input->post('remarks');
		$totalhours = $this->input->post('totalhours');

		$datefiled = strtotime($this->input->post('datefiled'));
		$changetype = $this->input->post('changetype');
		$approval = $this->input->post('emp_approval');
		$updatedby = $this->session->userdata['usersession'];
		
		$beginsched = $this->input->post('beginsched');
		$fbdate = substr($beginsched, 0, 10);       // this gets the date part of the whole datetime
		$date_from = date('Y-m-d', strtotime($fbdate)); // format it to yyyy-mm-dd
		
		$endsched = $this->input->post('endsched');
		$fedate = substr($endsched, 0, 10); 		   // this gets the date part of the whole datetime
		$date_to = date('Y-m-d', strtotime($fedate));   // format it to yyyy-mm-dd

		$t_from = substr($beginsched, 11,8);
		$t_to = substr($endsched, 11,8);
		
		$time_from = date("H:i a", strtotime($t_from));
		$time_to = date("H:i a", strtotime($t_to));
		
		$values = array(
			'emp_id' => $emp_id,
			'emp_code' => $emp_code,
			'date_filed' => $datefiled,
			'date_from' => $date_from,
			'time_from' => $time_from,
			'date_to' => $date_to,
			'time_to' => $time_to,
			'changetype' => $changetype,
			'status' => $approval,
			'totalhours' => $totalhours,
			'remarks' => $remarks,
			'updated_by' => $updatedby
		);

		$this->db->where('id', $id);
		$this->db->update('tbl_changesched', $values); 

		if($this->db->affected_rows() > 0){
			return array("success" => 1, "msg" => "Succesfully Updated!");
		} else {
			return array("success" => 0, "msg" => "No changes have been made");
		}	
	}
	
	public function deleteNewChangeSched(){
		$id = $this->input->post('id');
		$query = $this->db->delete('tbl_changesched', array('id' => $id));

		if($query){
			return array("success" => 1, "msg" => "Succesfully Deleted");
		} else {
			return array("success" => 0, "msg" => "Failed to Delete");
		}	
	}
	public function get_employee_code(){
		$query = $this->db->select('emp_code')
									 ->from('tbl_employee_info');
									 
		$emp = $this->db->get()->result_array();
		// fn_print_die($emp);
		return $emp;
	}
	
}