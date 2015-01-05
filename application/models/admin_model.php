<?php 

class admin_model extends CI_Model {
	
	/*public function getSearch(){
	
		$search = $this->input->get('search');
		$fieldname = $this->input->get('fieldname');
		$sort = $this->input->get('sort');
		
		$this->db->select('*, tbl_logins.id as tl_id');
		$this->db->from('tbl_logins');
		$this->db->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id', 'inner');
		$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id', 'inner');

		$this->db->like('tbl_employee_info.company', $search);
		$this->db->or_like('tbl_logins.username', $search);
		$this->db->or_like('tbl_person_info.lastname', $search);
		$this->db->or_like('tbl_person_info.firstname', $search);
		$this->db->or_like('tbl_person_info.middlename', $search);

		$this->db->order_by($fieldname, $sort); 
		$query = $this->db->get();
		$htmlsearch = '';
		
		foreach($query->result_array() as $row){
		
			$htmlsearch .= '<tr id='.$row['tl_id'].'>';
			$htmlsearch .= '<td>' .$row['company'].'</td>';
			$htmlsearch .= '<td>' .$row['username'].'</td>';
			$htmlsearch .= '<td>' .$row['lastname'].'</td>';
			$htmlsearch .= '<td>' .$row['firstname'].'</td>';
			$htmlsearch .= '<td>' .$row['middlename'].'</td>';
			$htmlsearch .= '<td align="center" colspan="2"><a class="printpdf btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> PDF</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="edituser btn btn-warning" target="_blank" href=../employee/employee_edit?username='.$row['username'].'><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>';
			$htmlsearch .= '</tr>';
	
		}
		
		return $htmlsearch;
		
	
	}*/
	
	
	/*public function getUsersTable(){
		$htmltable = '';
		$query = $this->db->select('emp_id, username')
						  ->limit($limit, $start)
						  ->get('tbl_logins');
		
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
			
			$htmltable .= '<tr id='.$emp_id.'><td>'.$company.'</td><td>'.$username.'</td><td>'.$lastname.'</td><td>'.$firstname.'</td><td>'.$middlename.'</td><td><a class="printpdf btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> View PDF</a></td><td><a class="edituser btn btn-warning" target="_blank" href=../employee/employee_edit?username='.$username.'><span class="glyphicon glyphicon-pencil"></span> Edit</a></td></tr>';
		}
		return $htmltable;
	}*/

	public function UserTable_record_count() {
        return $this->db->count_all("tbl_logins");
    }

    
    public function get_company() {
        return $this->db->select('*')
        				->from('tbl_company')
        				->get()
        				->result_array();
    }

	
	//====================================================Add User================================================//
	
	public function adduser(){
		$fname = trim($this->input->post('fname'));
		$mname = trim($this->input->post('mname'));
		$lname = trim($this->input->post('lname'));
		$username = trim($this->input->post('username'));
		$company = $this->input->post('company');
		$department = $this->input->post('department');
		$restday = $this->input->post('restday');
		$emp_code = $username; 	
		$password = md5($username);
		$role = $this->input->post('role');
		$shift = $this->input->post('shift');
		$updatedby = $this->session->userdata['usersession'];

		$v = array('username' => $username);
		$q = $this->db->get_where('tbl_logins', $v);
		if ($q->num_rows() == 0) {  // if inserted username isn't found in tbl_logins

				$values = array('firstname' => $fname, 'middlename' => $mname, 'lastname' => $lname, 'updated_by' => $updatedby);
				$query = $this->db->insert('tbl_person_info', $values);
				$tbl_person_id = $this->db->insert_id();
				
				if($tbl_person_id) {
				
					$values2 = array('emp_id' => $tbl_person_id, 'emp_code' => $emp_code, 'username' => $username, 'password' => $password, 'role_id' => $role);
					$query2 = $this->db->insert('tbl_logins', $values2);
					$tbl_logins_id = $this->db->insert_id();
					
					if($tbl_logins_id){
					
						$values3 = array('emp_id' => $tbl_person_id, 'emp_code' => $emp_code, 'employer' => $company, 'company' => $company, 'department' => $department, 'shift' => $shift, 'rest_day' => $restday, 'updated_by' => $updatedby);
						$query3 = $this->db->insert('tbl_employee_info', $values3);
						$tbl_employee_id = $this->db->insert_id();
						
						if($tbl_employee_id){
							
							$values4 = array('emp_id' => $tbl_person_id);
							$query4 = $this->db->insert('tbl_employee_emergency_info', $values4);
							$tbl_emergency_id = $this->db->insert_id();
							
							if($tbl_emergency_id){
							
								$values5 = array('emp_id' => $tbl_person_id);
								$query5 = $this->db->insert('tbl_employee_beneficiaries', $values5);
								$tbl_beneficiary_id = $this->db->insert_id();
								
								if($tbl_beneficiary_id){
									$status = '{"success":1111,"msg":"Successfully inserted into person,login,employee,emergency and beneficiary table"}';
								} else {
									$status = '{"success":11110,"msg":"Successfully inserted into person,login, employee and emergency table but not on beneficiary table"}';	
								}
							
								
							}else {
								$status = '{"success":1110,"msg":"Successfully inserted into person,login and employee table but not on emergency table"}';	
							}
							
							
						} else {
							$status = '{"success":110,"msg":"Successfully inserted into person,login table but not on employee table"}';	
						}
					
					} else {
						$status = '{"success":10,"msg":"Successfully inserted into person table but not on login and employee table"}';
					}
					
				} else {
					$status = '{"success":100000,"msg":"Unable to insert into person, login and employee table"}';
				}
				
					
			} else {
				$status = '{"success":0, "msg":"Inserted username is already taken"}';
			}
				return $status;

		}



		
	
	//===============================================End Add User======================================================//

	/*public function getAttendance($id){

		//$attend = $this->db->get('tbl_daily_attendance')->row_array();
		$this->db->select('tbl_daily_attendance.id,
						   tbl_daily_attendance.type,
						   tbl_daily_attendance.reason,
						   tbl_daily_attendance.date_filed,
						   tbl_daily_attendance.remark,
						   tbl_employee_info.emp_code
						   ')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->where('tbl_daily_attendance.id', $id);

		$attend_all = $this->db->get()->result_array();
		
		return $attend_all;
	}*/
	
	public function AttendanceTable_record_count($type) {
		$query = $this->db->query("SELECT * FROM tbl_daily_attendance WHERE type = '$type'");
		return $query->num_rows();
    }

	public function getAttendanceTable($limit, $start, $search, $fieldname, $sort, $type){
   		$thisquery = "SELECT *, tbl_departments.dep_name, tbl_daily_attendance.id as tda_id FROM tbl_daily_attendance 
						INNER JOIN tbl_employee_info ON tbl_daily_attendance.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						WHERE tbl_daily_attendance.type = '{$type}' 
						AND (tbl_employee_info.company LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_daily_attendance.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%')";

		 if (($fieldname && $sort) != (null || '')) {
		 	$fieldname == 'firstname' ? $fieldname = 'tbl_person_info.firstname' : $fieldname = 'tbl_daily_attendance.date_filed'; 

		 	$thisquery .= "ORDER BY $fieldname $sort";
		 }else {
		 	$thisquery .= "ORDER BY tbl_daily_attendance.created_at DESC";
		 }

		 $thisquery .= " LIMIT {$start}, {$limit}";
		 $getAttendanceTable = $this->db->query($thisquery);

		 if ($getAttendanceTable->num_rows() > 0) {
             foreach ($getAttendanceTable->result() as $row) {
                 $data[] = $row;
             }
             return $data;
         }
        return false;
	}

	public function editAttendanceForm() {
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_daily_attendance.*, tbl_person_info.firstname, tbl_person_info.lastname')
						  ->join('tbl_person_info', 'tbl_daily_attendance.emp_id = tbl_person_info.id')
						  ->get_where('tbl_daily_attendance', array('tbl_daily_attendance.id' => $id));
		$row = $query->row_array();

		$datefiled = date("m/d/Y g:i a", $row['date_filed']);
		$fullname = $row['firstname'].' '.$row['lastname'];
		
		$data = array(
			'fullname' => $fullname,
			'emp_id' => $row['emp_id'],
			'emp_code' => $row['emp_code'],
			'type' => $row['type'],
			'date_filed' => $datefiled,
			'reason' => $row['reason'],
			'remark' => $row['remark']
			);
			
		return $data;	
	}
	

	public function getAttendanceLate(){

		//$attend = $this->db->get('tbl_daily_attendance')->row_array();

		$this->db->select('*, tbl_daily_attendance.id as tda_id')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->where('tbl_daily_attendance.type', 'Late');

		$attend_late = $this->db->get()->result_array();
		return $attend_late;
	}

	public function getAttendanceAwol(){

		//$attend = $this->db->get('tbl_daily_attendance')->row_array();

		$this->db->select('*, tbl_daily_attendance.id as tda_id')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->where('tbl_daily_attendance.type', 'Awol');

		$attend_awol = $this->db->get()->result_array();
		
		return $attend_awol;
	}

	public function getAttendanceAbsent(){

		//$attend = $this->db->get('tbl_daily_attendance')->row_array();

		$this->db->select('*, tbl_daily_attendance.id as tda_id')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->where('tbl_daily_attendance.type', 'Absent');

		$attend_awol = $this->db->get()->result_array();
		
		return $attend_awol;
	}

	public function insertAttendanceForm(){
		$emp_code = $this->input->post('emp_code');
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$emp_id  = $getThisID->row_array();
		
		$date_filed = strtotime($this->input->post('datefiled'));
		$remark = $this->input->post('remark');
		$type = $this->input->post('type');
		$reason = $this->input->post('reason');
		$updatedby = $this->session->userdata['usersession'];

		$data = array(
		   'emp_id' => $emp_id['emp_id'],
		   'emp_code' => $emp_code,
		   'date_filed' => $date_filed,
		   'remark' => $remark,
		   'type' => $type,
		   'reason' => $reason,
		   'updated_by' => $updatedby
		);

		$this->db->insert('tbl_daily_attendance', $data); 
		$aid = $this->db->insert_id();

		if($aid){
			$this->session->set_flashdata('notification', 'Successfully saved');
		} else {
			$this->session->set_flashdata('notification', 'Failed to save');
		}		
	}

	public function update_status($status){
		$updatedby = $this->session->userdata['usersession'];

		$this->db->where('id', $status['id'])->update('tbl_daily_attendance', array('status' => $status['status'], 'updated_by' => $updatedby)); 
	}
	
	public function updateAttendanceForm(){
				
		$emp_code = $this->input->post('emp_code');
		$emp_id = $this->input->post('emp_id');
		$id = $this->input->post('recID');
		$type = $this->input->post('type');
		$datefiled = strtotime($this->input->post('datefiled'));
		$reason = $this->input->post('reason');
		$remark = $this->input->post('remark');
		$updatedby = $this->session->userdata['usersession'];

		$data = array(
			   'emp_id' => $emp_id,
               'emp_code' => $emp_code,
			   'type' => $type,
			   'date_filed' => $datefiled,
               'reason' => $reason,
			   'remark' => $remark,
		   	   'updated_by' => $updatedby
            );

		$this->db->where('id', $id);
		$this->db->update('tbl_daily_attendance', $data); 
		
		if($this->db->affected_rows() > 0){
			$status = '{"success" : 1}';
		} else {
			$status = '{"success" : 0}';
		}
				
		return $status;		
	}
	
	public function deleteAttendanceForm() {
		$id = $this->input->post('id');
		$this->db->delete('tbl_daily_attendance', array('id' => $id));
	}
	
	
	//---------------------------------------------------------- LEAVE FORM ----------------------------------------------------------//
	public function LeaveTable_record_count($status) {
		$query = $this->db->query("SELECT * FROM tbl_leaves WHERE status = $status");
		return $query->num_rows();
    }

   	public function getLeaveTable($limit, $start, $search, $fieldname, $sort, $status){

   		$thisquery = "SELECT *, tbl_departments.dep_name, tbl_leaves.id as lid FROM tbl_leaves 
						INNER JOIN tbl_employee_info ON tbl_leaves.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id 
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						WHERE tbl_leaves.status = '{$status}' 
						AND (tbl_employee_info.company LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_leaves.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%' 
						OR tbl_leaves.type LIKE '%{$search}%')";
						
		
		 if (($fieldname && $sort) != (null || '')) {
		 	$fieldname == 'firstname' ? $fieldname = 'tbl_person_info.firstname' : $fieldname = 'tbl_leaves.date_from';

		 	$thisquery .= "ORDER BY $fieldname $sort";
		 } else {
		 	$thisquery .= "ORDER BY tbl_leaves.created_at DESC";
		 }

		 $thisquery .= " LIMIT {$start}, {$limit}";
		 $getLeaveTable = $this->db->query($thisquery);
		  
		 if ($getLeaveTable->num_rows() > 0) {
             foreach ($getLeaveTable->result() as $row) {
                 $row->date_from = date('m/d/Y', strtotime($row->date_from));
                 $row->date_to = date('m/d/Y', strtotime($row->date_to));

                 $data[] = $row;
             }
             return $data;
         }
        return false;
	}

	public function getLeaveApproved($limit, $start){
		$this->db->select('*, tbl_leaves.id as tl_id');
		$this->db->from('tbl_leaves');
		$this->db->join('tbl_employee_info', 'tbl_leaves.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_leaves.emp_id = tbl_person_info.id');
		//$this->db->limit($limit, $start);
		$this->db->where('tbl_leaves.status', '1');

		$leave_approved = $this->db->get()->result_array();
		return $leave_approved;
	}

	public function getLeaveApproved_count() {

        return $this->db->where('status', '1')->count_all_results('tbl_leaves');
    }

	public function getLeaveDenied($limit, $start){
		$this->db->select('*, tbl_leaves.id as tl_id');
		$this->db->from('tbl_leaves');
		$this->db->join('tbl_employee_info', 'tbl_leaves.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_leaves.emp_id = tbl_person_info.id');
		//$this->db->limit($limit, $start);
		$this->db->where('tbl_leaves.status', '0');

		$leave_denied = $this->db->get()->result_array();
		return $leave_denied;
	}

	public function getLeaveDenied_count() {
        return $this->db->where('status', '0')->count_all_results('tbl_leaves');
    }

	public function getLeavePending($limit, $start){
		$this->db->select('*, tbl_leaves.id as tl_id');
		$this->db->from('tbl_leaves');
		$this->db->join('tbl_employee_info', 'tbl_leaves.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_leaves.emp_id = tbl_person_info.id');
		//$this->db->limit($limit, $start);
		$this->db->where('tbl_leaves.status', '2');

		$leave_pending = $this->db->get()->result_array();
		return $leave_pending;
	}

	public function getLeavePending_count() {
        return $this->db->where('status', '2')->count_all_results('tbl_leaves');
    }

	public function insertLeaveForm() {

		$emp_code = $this->input->post('emp_code');
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$emp_id  = $getThisID->row_array();

		$date_filed = strtotime($this->input->post('datefiled'));
		$reason = $this->input->post('emp_reason');
		$type = $this->input->post('emp_type');
		$remark = $this->input->post('emp_remark');
		$approval = $this->input->post('emp_approval');
		$numleave = $this->input->post('numleave');
		$leavepay = $this->input->post('leavepay');
		$updatedby = $this->session->userdata['usersession'];
		
		$begindate = $this->input->post('begindate');
		$fbdate = substr($begindate, 0, 10);       // this gets the date part of the whole datetime
		$date_from = date('Y-m-d', strtotime($fbdate)); // format it to yyyy-mm-dd
		
		$enddate = $this->input->post('enddate');
		$fedate = substr($enddate, 0, 10); 		   // this gets the date part of the whole datetime
		$date_to = date('Y-m-d', strtotime($fedate));   // format it to yyyy-mm-dd

		$t_from = substr($begindate, 11,8);
		$t_to = substr($enddate, 11,8);
		
		$time_from = date("H:i a", strtotime($t_from));
		$time_to = date("H:i a", strtotime($t_to));

		$id = $emp_id['emp_id'];
		$data = array(
			'emp_id' => $id,
			'emp_code' => $emp_code,
			'date_filed' => $date_filed,
			'date_from' => $date_from,
			'time_from' => $time_from,
			'date_to' => $date_to,
			'time_to' => $time_to,
			'reason' => $reason,
			'numleave' => $numleave,
			'leavepay' => $leavepay,
			'type' => $type,
			'remark' => $remark,
			'status' => $approval,
			'updated_by' => $updatedby
		);
		$this->db->insert('tbl_leaves', $data);
		$lid = $this->db->insert_id();

		if($lid){
			$this->session->set_flashdata('notification', 'Successfully saved');
		} else {
			$this->session->set_flashdata('notification', 'Failed to save');
		}
	}

	public function insertChangeSchedForm(){
		$emp_code = $this->input->post('emp_code');
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$emp_id  = $getThisID->row_array();

		$date_filed = strtotime($this->input->post('datefiled'));
		$approval = $this->input->post('emp_approval');
		$changetype = $this->input->post('changetype');
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

		$id = $emp_id['emp_id'];

		$data = array(
			'emp_id' => $id,
			'emp_code' => $emp_code,
			'date_filed' => $date_filed,
			'date_from' => $date_from,
			'time_from' => $time_from,
			'date_to' => $date_to,
			'time_to' => $time_to,
			'changetype' => $changetype,
			'status' => $approval,
			'updated_by' => $updatedby
			);

		$this->db->insert('tbl_changesched', $data);
		$cid = $this->db->insert_id();

		if($cid){
			$this->session->set_flashdata('notification', 'Successfully saved');
		} else {
			$this->session->set_flashdata('notification', 'Failed to save');
		} 
	}



	
	/*   Temporarily commented 
	
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
	}*/

	public function updateLeaveForm(){
		$emp_code = $this->input->post('emp_code');
		$id = $this->input->post('recID');
		$emp_id = $this->input->post('emp_id');
		$datefiled = strtotime($this->input->post('datefiled'));
		$reason = $this->input->post('emp_reason');
		$type = $this->input->post('emp_type');
		$remark = $this->input->post('emp_remark');
		$numleave = $this->input->post('numleave');
		$leavepay = $this->input->post('leavepay');
		$approval = $this->input->post('emp_approval');
		$updatedby = $this->session->userdata['usersession'];

		$begindate = $this->input->post('begindate');
		$fbdate = substr($begindate, 0, 10);       // this gets the date part of the whole datetime
		$date_from = date('Y-m-d', strtotime($fbdate)); // format it to yyyy-mm-dd
		
		$enddate = $this->input->post('enddate');
		$fedate = substr($enddate, 0, 10); 		   // this gets the date part of the whole datetime
		$date_to = date('Y-m-d', strtotime($fedate));   // format it to yyyy-mm-dd

		$t_from = substr($begindate, 11,8);
		$t_to = substr($enddate, 11,8);
		
		$time_from = date("H:i a", strtotime($t_from));
		$time_to = date("H:i a", strtotime($t_to));
		
		$data = array(
			'emp_id' => $emp_id,
			'emp_code' => $emp_code,
			'reason' => $reason,
			'date_filed' => $datefiled,
			'date_from' => $date_from,
			'time_from' => $time_from,
			'date_to' => $date_to,
			'time_to' => $time_to,
			'type' => $type,
			'remark' => $remark,
			'status' => $approval,
			'numleave' => $numleave,
			'leavepay' => $leavepay,
			'updated_by' => $updatedby
		);

		$this->db->where('id', $id);
		$this->db->update('tbl_leaves', $data); 

		if($this->db->affected_rows() > 0){
			$status = '{"success" : 1}';
		} else {
			$status = '{"success" : 0}';
		}
				
		return $status;		
	}

	public function editLeaveForm() {
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_leaves.*, tbl_person_info.firstname, tbl_person_info.lastname')
						  ->join('tbl_person_info', 'tbl_leaves.emp_id = tbl_person_info.id')
						  ->get_where('tbl_leaves', array('tbl_leaves.id' => $id));

		$row = $query->row_array();
		
		$datefiled = date("m/d/Y h:i a", $row['date_filed']);
	
		$d_from = $row['date_from'].' '.$row['time_from'];
		$d_to = $row['date_to'].' '.$row['time_to'];
		
		$date_from = date("m/d/Y h:i a", strtotime($d_from));
		$date_to = date("m/d/Y h:i a", strtotime($d_to));
		$fullname = $row['firstname'].' '.$row['lastname'];
		
		$data = array(
			'emp_id' => $row['emp_id'],
			'fullname' => $fullname,
			'emp_code' => $row['emp_code'],
			'date_filed' => $datefiled,
			'date_from' => $date_from,
			'date_to' => $date_to,
			'reason' => $row['reason'],
			'type' => $row['type'],
			'remark' => $row['remark'],
			'status' => $row['status'],
			'numleave' => $row['numleave'],
			'leavepay' => $row['leavepay']
			);
			
		return $data;	
	}

	public function deleteLeaveForm() {
		$id = $this->input->post('id');
		$this->db->delete('tbl_leaves', array('id' => $id));
	}
	//------------------------------------------------------- END OF LEAVE FORM --------------------------------------------------------//
	
	//--------------------------------------------------------CHANGE SCHEDULE-----------------------------------------------------------//

	public function getChangeSchedTable($status, $fieldname, $sort){


		$this->db->select('*, tbl_departments.dep_name, tbl_changesched.id as cid');
		$this->db->from('tbl_changesched');
		$this->db->join('tbl_employee_info', 'tbl_changesched.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id');
		$this->db->join('tbl_departments', 'tbl_departments.id = tbl_employee_info.department');
		$this->db->where('tbl_changesched.status', $status);
		
		 if(($fieldname && $sort) != '') {
		 	$fieldname == 'firstname' ? $fieldname = 'tbl_person_info.firstname' : $fieldname = 'tbl_changesched.date_from';

		 	$this->db->order_by($fieldname, $sort);
		 } else {
		 	$this->db->order_by('tbl_changesched.created_at', 'DESC');
		 }

	// fn_print_die($status, $sort, $fieldname);


		 $getChangeSchedTable = $this->db->get();
		
		 if ($getChangeSchedTable->num_rows() > 0) {
             foreach ($getChangeSchedTable->result() as $row) {
                 $row->date_from = date('m/d/Y', strtotime($row->date_from));
                 $row->date_to = date('m/d/Y', strtotime($row->date_to));

                 $data[] = $row;
             }
             return $data;
         }
        return false;
	}

	public function updateChangeSchedForm(){
		$id = $this->input->post('recID');
		$emp_code = $this->input->post('emp_code');
		$emp_id = $this->input->post('emp_id');

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
		
		$data = array(
			'emp_id' => $emp_id,
			'emp_code' => $emp_code,
			'date_filed' => $datefiled,
			'date_from' => $date_from,
			'time_from' => $time_from,
			'date_to' => $date_to,
			'time_to' => $time_to,
			'changetype' => $changetype,
			'status' => $approval,
			'updated_by' => $updatedby
		);

		$this->db->where('id', $id);
		$this->db->update('tbl_changesched', $data); 
		
		if($this->db->affected_rows() > 0){
			$status = '{"success" : 1}';
		} else {
			$status = '{"success" : 0}';
		}
				
		return $status;		
	}

	public function editChangeSchedForm(){
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_changesched.*, tbl_person_info.firstname, tbl_person_info.lastname')
						  ->join('tbl_person_info', 'tbl_changesched.emp_id = tbl_person_info.id')
						  ->get_where('tbl_changesched', array('tbl_changesched.id' => $id));
		$row = $query->row_array();
		$fullname = $row['firstname'].' '.$row['lastname'];

		$datefiled = date("m/d/Y h:i a", $row['date_filed']);
	
		$d_from = $row['date_from'].' '.$row['time_from'];
		$d_to = $row['date_to'].' '.$row['time_to'];
		
		$date_from = date("m/d/Y h:i a", strtotime($d_from));
		$date_to = date("m/d/Y h:i a", strtotime($d_to));

		$data = array(
			'fullname' => $fullname,
			'emp_id' => $row['emp_id'],
			'emp_code' => $row['emp_code'],
			'date_filed' => $datefiled,
			'date_from' => $date_from,
			'date_to' => $date_to,
			'changetype' => $row['changetype'],
			'status' => $row['status']
			);

		return $data;
	}

	public function deleteChangeSchedForm() {
		$id = $this->input->post('id');
		$this->db->delete('tbl_changesched', array('id' => $id));
	}

	//--------------------------------------------------------END OF OFFSET FORM--------------------------------------------------------//


	//------------------------------------------------------- REQUEST FORM -------------------------------------------------------//

	public function getRequestTable($limit, $start, $search, $fieldname, $sort){
		$search = $this->input->get('search');
		$this->db->select('*, tbl_request.id as rid');
		$this->db->from('tbl_request');
		$this->db->join('tbl_employee_info', 'tbl_request.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id');
		$this->db->like('tbl_employee_info.company', $search);
		$this->db->or_like('tbl_employee_info.department', $search);
		$this->db->or_like('tbl_employee_info.position', $search);
		$this->db->or_like('tbl_request.emp_code', $search);
		$this->db->or_like('tbl_person_info.firstname', $search);
		$this->db->or_like('tbl_person_info.middlename', $search);
		$this->db->or_like('tbl_request.purpose', $search);
		$this->db->limit($limit, $start);

		if (($fieldname && $sort) != (null || '')) {
			$this->db->order_by('tbl_person_info.firstname', $sort);
		} else {
			$this->db->order_by('tbl_request.created_at', 'DESC');
		}

		$getRequestTable = $this->db->get();

		if ($getRequestTable->num_rows() > 0) {
            foreach ($getRequestTable->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}

	public function search_handler($searchterm){

		if($searchterm){
			$this->session->set_userdata('search', $searchterm);
			return $searchterm;
		} elseif($this->session->userdata('search')){
			$searchterm = $this->session->userdata('search');
			return $searchterm;
		} else {
		 	$searchterm = '';
			return $searchterm;
		}		
		
	}
	
	public function getUserSearchTable($search, $limit, $start, $fieldname, $sort){
		$this->db->select('*, tbl_company.company_name, tbl_logins.id as tl_id, tbl_logins.emp_id as tl_emp');
		$this->db->from('tbl_logins');
		$this->db->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id');
		$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id');
		$this->db->join('tbl_company', 'tbl_company.id = tbl_employee_info.company');
		$this->db->like('tbl_company.company_name', $search);
		$this->db->or_like('tbl_logins.username', $search);
		$this->db->or_like('tbl_person_info.lastname', $search);
		$this->db->or_like('tbl_person_info.firstname', $search);
		$this->db->or_like('tbl_person_info.middlename', $search);
		$this->db->limit($limit, $start);


		if (($fieldname && $sort) != (null || '')) {
			$this->db->order_by($fieldname, $sort);
		}
		$getUserTable = $this->db->get();

		if ($getUserTable->num_rows() > 0) {
            foreach ($getUserTable->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}

	public function RequestTable_record_count($search) {


		$getRequestTable = $this->db->select('*, tbl_request.id as rid')
									->from('tbl_request')
									->join('tbl_employee_info', 'tbl_request.emp_id = tbl_employee_info.emp_id')
									->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id')
									->join('tbl_company', 'tbl_company.id = tbl_employee_info.company')
									->like('tbl_company.company_name', $search)
									->or_like('tbl_employee_info.department', $search)
									->or_like('tbl_employee_info.position', $search)
									->or_like('tbl_request.emp_code', $search)
									->or_like('tbl_person_info.firstname', $search)
									->or_like('tbl_person_info.middlename', $search)
									->or_like('tbl_request.purpose', $search)
									->get()
									->num_rows();

        return $getRequestTable;
        fn_print_die($getRequestTable);
    }
	
	public function UsersTable_record_count($search) {

		$getUserTable = $this->db->select('*, tbl_company.company_name, tbl_logins.id as tl_id, tbl_logins.emp_id as tl_emp')
								 ->from('tbl_logins')
								 ->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id')
								 ->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id')
								 ->join('tbl_company', 'tbl_company.id = tbl_employee_info.company')
								 ->like('tbl_company.company_name', $search)
								 ->or_like('tbl_logins.username', $search)
								 ->or_like('tbl_person_info.lastname', $search)
								 ->or_like('tbl_person_info.firstname', $search)
								 ->or_like('tbl_person_info.middlename', $search)
								 ->get()
								 ->num_rows();
        return $getUserTable;
    }
	/*public function getRequestTable() {
		$htmltable = '';
		$this->db->select('*');
		$this->db->from('tbl_person_info');
		$this->db->join('tbl_employee_info', 'tbl_person_info.id = tbl_employee_info.emp_id');
		$this->db->join('tbl_request', 'tbl_employee_info.emp_id = tbl_request.emp_id');
		//$this->db->order_by('topictime', 'DESC');
		$query = $this->db->get();
		//$query = $this->db->get('topics', 'topic.accountid = account.accountid','left');
		//return $query->result_array();
		foreach($query->result_array() as $row) {
			$company = $row['employer'];
			$department = $row['department'];
			$position = $row['position'];
			$id = $row['id'];
			$name = $row['nickname'];
			$purpose = $row['purpose'];
			$date = $row['date_filed'];

			if($purpose == 0) { $thispurpose = "Under Time"; }
			else if ($purpose == 1) { $thispurpose = "Tardiness"; }
			else { $thispurpose = "Non Punching"; }
			$htmltable .= '<tr id=' .$id. '>
				<td>' .$company. '</td><td>' .$department. '</td><td>' .$position. '</td><td>' .$id. '</td><td>' .$name. '</td><td>' .$thispurpose. '</td><td>' .$date. '</td>
				<td><a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
				<td><a class="deletelink btn btn-default"><span class="glyphicon glyphicon-trash"></span> Delete</a></td>
			</tr>';
			//<input type="submit" name="action[createrequest]" class="deletelink btn btn-primary" value="Delete" />
		}

		return $htmltable;
	}*/

	public function insertRequestForm() {

		$emp_code = $this->input->post('emp_code');
		$date_filed = strtotime($this->input->post('datefiled'));
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code));
		$emp_id  = $getThisID->row_array();
		$updatedby = $this->session->userdata['usersession'];
	
		$purpose = $this->input->post('emp_purpose');
		$reason = $this->input->post('emp_reason');
		$remark = $this->input->post('emp_remark');
		$approval = $this->input->post('emp_approval');
		
		$id = $emp_id['emp_id'];
		$data = array(
			'id' => NULL,
			'emp_id' => $id,
			'emp_code' => $emp_code,
			'date_filed' => $date_filed,
			'purpose' => $purpose,
			'reason' => $reason,
			'remark' => $remark,
			'status' => $approval,
			'updated_by' => $updatedby
		);
		$this->db->insert('tbl_request', $data);
		$rid = $this->db->insert_id();

		if($rid){
			$this->session->set_flashdata('notification', 'Successfully saved');
		} else {
			$this->session->set_flashdata('notification', 'Failed to save');
		}
		
	}
	
	public function updateRequestForm(){
				
		$emp_code = $this->input->post('emp_code');
		$emp_id = $this->input->post('emp_id');
		$id = $this->input->post('recID');
		$purpose = $this->input->post('emp_purpose');
		$datefiled = strtotime($this->input->post('datefiled'));
		$reason = $this->input->post('emp_reason');
		$remark = $this->input->post('emp_remark');
		$approval = $this->input->post('emp_approval');
		$updatedby = $this->session->userdata['usersession'];
		
		$data = array(
			   'emp_id' => $emp_id,
               'emp_code' => $emp_code,
			   'date_filed' => $datefiled,
               'purpose' => $purpose,
               'reason' => $reason,
			   'status' => $approval,
			   'remark' => $remark,
			   'updated_by' => $updatedby
            );

		$this->db->where('id', $id);
		$this->db->update('tbl_request', $data); 
		
		if($this->db->affected_rows() > 0){
			$status = '{"success" : 1}';
		} else {
			$status = '{"success" : 0}';
		}
				
		return $status;		
	}

	public function editRequestForm() {
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_request.*, tbl_person_info.firstname, tbl_person_info.lastname')
						  ->join('tbl_person_info', 'tbl_request.emp_id = tbl_person_info.id')
						  ->get_where('tbl_request', array('tbl_request.id' => $id));
		
		$row = $query->row_array();
		$fullname = $row['firstname'].' '.$row['lastname'];
		
		$datefiled = date("m/d/Y h:i a", $row['date_filed']);

		$data = array(
			'fullname' => $fullname,
			'emp_id' => $row['emp_id'],
			'emp_code' => $row['emp_code'],
			'date_filed' => $datefiled,
			'purpose' => $row['purpose'],
			'reason' => $row['reason'],
			'status' => $row['status'],
			'remark' => $row['remark']
			);
			
		return $data;	
	}

	public function deleteRequestForm() {
		$id = $this->input->post('id');
		$this->db->delete('tbl_request', array('id' => $id));
	}

	public function getAllCompany(){
		$query = $this->db->get('tbl_company');
		$data = $query->result_array();
		return $data;
	}

	public function editCompany(){
		$id = $this->input->post('id');
		$query = $this->db->get_where('tbl_company', array('id' => $id));
		$row = $query->row_array();

		$data = array('company_name' => $row['company_name'], 'company_abbr' => $row['company_abbr']);
		return $data;
	}

	public function deleteCompany(){
		$id = $this->input->post('id');
		$query = $this->db->delete('tbl_company', array('id' => $id));
		
		if($query){
			return '{"success": 1}'; 
		} else {
			return '{"success": 0}'; 
		}
	}

	public function addCompany(){
		$company_name = $this->input->post('company_name');
		$company_abbr = $this->input->post('company_abbr');

		$values = array('company_name' => $company_name, 'company_abbr' => $company_abbr);
		$this->db->insert('tbl_company', $values);
		$cID = $this->db->insert_id();

		if($cID) {
			return '{"success": 1, "msg": "Succesfully added a company"}'; 
		} else {
			return '{"success": 0, "msg": "Failed to add a company"}'; 
		}
	}

	public function updateCompany(){
		$id = $this->input->post('recID');
		$company_name = $this->input->post('company_name');
		$company_abbr = $this->input->post('company_abbr');

		$values = array('company_name' => $company_name, 'company_abbr' => $company_abbr);

		$this->db->where('id', $id);
		$this->db->update('tbl_company', $values);

		if($this->db->affected_rows() > 0){
			return '{"success": 1, "msg": "Succesfully updated a company"}';
		} else {
			return '{"success": 0, "msg": "Failed to update a company"}';
		}
	}

	public function getAllDepartment(){
		$query = $this->db->get('tbl_departments');
		$data = $query->result_array();
		return $data;
	}

	public function addDepartment(){
		$company_id = $this->input->post('company_id');
		$department_name = $this->input->post('department_name');
		$department_abbr = $this->input->post('department_abbr');

		$values = array('company_id' => $company_id, 'dep_name' => $department_name, 'dep_abbr' => $department_abbr);
		$this->db->insert('tbl_departments', $values);
		$did = $this->db->insert_id();

		if($did){
			return '{"success": 1, "msg": "Successfully added a department"}';
		} else {
			return '{"success": 0, "msg": "Failed to add a department"}';
		}
	}

	public function updateDepartment(){
		$id = $this->input->post('recID');
		$company_id = $this->input->post('company_id');
		$department_name = $this->input->post('department_name');
		$department_abbr = $this->input->post('department_abbr');

		$values = array('company_id' => $company_id, 'dep_name' => $department_name, 'dep_abbr' => $department_abbr);
		$this->db->where('id', $id);
		$this->db->update('tbl_departments', $values);

		if($this->db->affected_rows() > 0){
			return '{"success": 1, "msg": "Successfully updated a department"}';
		} else {
			return '{"success": 0, "msg": "Failed to update a department"}';
		}
	}

	public function editDepartment(){
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_departments.*, tbl_company.id as cid')
						  ->join('tbl_company', 'tbl_departments.company_id = tbl_company.id')
						  ->get_where('tbl_departments', array('tbl_departments.id' => $id));

		$row = $query->row_array();

		$data = array('dep_name' => $row['dep_name'], 'dep_abbr' => $row['dep_abbr'], 'company_id' => $row['cid']);
		return $data;
	}

	public function deleteDepartment(){
		$id = $this->input->post('id');
		$query = $this->db->delete('tbl_departments', array('id' => $id));

		if($query){
			return '{"success": 1}';
		} else {
			return '{"success": 0}';
		}	
	}

	public function getAllBenefit(){
		$query = $this->db->select('tbl_benefits.*, tbl_person_info.firstname, tbl_person_info.lastname, tbl_benefits.id as bid')
						  ->from('tbl_benefits')
						  ->join('tbl_person_info', 'tbl_benefits.emp_id = tbl_person_info.id')
						  ->get();

		$data = $query->result_array();
		return $data;
	}

	public function getSuggest(){
		$query = $this->db->select('tbl_person_info.id, tbl_person_info.firstname, tbl_person_info.lastname, tbl_logins.emp_code, tbl_benefits.emp_id')
					      ->from('tbl_person_info')
					      ->join('tbl_logins', 'tbl_person_info.id = tbl_logins.emp_id')
					      ->join('tbl_benefits', 'tbl_benefits.emp_id = tbl_logins.emp_id', 'left')
					      ->get();
		
		$row = $query->result_array();
		foreach($row as $r) { 
			$r['text'] = $r['firstname'].' '.$r['lastname'];

			$arr[] = $r;

		}
		return json_encode($arr);
	}

	public function getNameSuggest(){
		$query = $this->db->select('tbl_person_info.id, tbl_person_info.firstname, tbl_person_info.lastname, tbl_employee_info.emp_code')
				 ->from('tbl_person_info')
				 ->join('tbl_employee_info', 'tbl_person_info.id = tbl_employee_info.emp_id')
				 ->get();

		$row = $query->result_array();
		foreach ($row as $r) {
			$r['text'] = $r['firstname'].' '.$r['lastname'];

			$arr[] = $r;
		}

		return json_encode($arr);
	}



	public function editBenefit(){
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_benefits.*, tbl_person_info.firstname, tbl_person_info.lastname, tbl_benefits.id as bid')
						  ->join('tbl_person_info', 'tbl_benefits.emp_id = tbl_person_info.id')
						  ->get_where('tbl_benefits', array('tbl_benefits.id' => $id));

		$row = $query->row_array();
		$data = array('employee_name' => $row['firstname'].' '.$row['lastname'], 'hmo' => $row['hmo'], 'phone' => $row['phone'], 'gas' => $row['gas'], 'travel' => $row['travel'], 'entertainment' => $row['entertainment'], 'leaves' => $row['leaves']);
		return $data;
	}

	public function addBenefit(){
		$emp_id = $this->input->post('employee_id');
		$leaves = $this->input->post('leaves');
		$hmo = $this->input->post('hmo');
		$phone = $this->input->post('phone');
		$gas = $this->input->post('gas');
		$travel = $this->input->post('travel');
		$ent = $this->input->post('ent');

		$values = array('emp_id' => $emp_id, 'leaves' => $leaves, 'hmo' => $hmo, 'phone' => $phone, 'gas' => $gas, 'travel' => $travel, 'entertainment' => $ent);
		$this->db->insert('tbl_benefits', $values);
		$bid = $this->db->insert_id();

		if($bid) {
			return '{"success": 1, "msg": "Successfully added a record"}';
		} else {
			return '{"success": 0, "msg": "Failed to add a record"}';
		}
	}

	public function updateBenefit(){
		$id = $this->input->post('recID');
		$leaves = $this->input->post('leaves');
		$hmo = $this->input->post('hmo');
		$phone = $this->input->post('phone');
		$gas = $this->input->post('gas');
		$travel = $this->input->post('travel');
		$ent = $this->input->post('ent');

		$values = array('leaves' => $leaves, 'hmo' => $hmo, 'phone' => $phone, 'gas' => $gas, 'travel' => $travel, 'entertainment' => $ent);
		$this->db->where('id', $id);
		$this->db->update('tbl_benefits', $values);

		if($this->db->affected_rows() > 0){
			return '{"success": 1, "msg": "Successfully updated a record"}';
		} else {
			return '{"success": 0, "msg": "Failed to update a record"}';
		}
	}

	public function deleteBenefit(){
		$id = $this->input->post('id');
		$query = $this->db->delete('tbl_benefits', array('id' => $id));

		if($query){
			return '{"success": 1}';
		} else {
			return '{"success": 0}';
		}	
	}


	
/*	public function getdata() {
		$status = $this->input->get('status');
		
		$this->db->select('*, tbl_daily_attendance.id as tda_id')
				->from('tbl_daily_attendance')
				->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				->where('tbl_daily_attendance.type', $status)
				->like('tbl_employee_info.company', $compan)
				->like('tbl_employee_info.department', $company)
				->like('tbl_employee_info.department', $company)
				->like('tbl_employee_info.department', $company)
				->like('tbl_employee_info.position', $company);
		
				 
		$result = mysql_query("SELECT *, tbl_daily_attendance.id as tda_id FROM tbl_daily_attendance 
						INNER JOIN tbl_employee_info ON tbl_daily_attendance.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_daily_attendance.type = $status
						AND (tbl_employee_info.company LIKE '%$search%'
						OR tbl_employee_info.department LIKE '%$search%'
						OR tbl_employee_info.position LIKE '%$search%'
						OR tbl_daily_attendance.emp_code LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_daily_attendance.reason LIKE '%$search%')") or die(mysql_error());
	}*/
	/*
	$result = mysql_query("SELECT *, tbl_logins.id as tl_id FROM tbl_logins 
						INNER JOIN tbl_employee_info ON tbl_logins.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_employee_info.company LIKE '%$search%'
						OR tbl_logins.username LIKE '%$search%'	
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						ORDER BY $fieldname $sort") or die(mysql_error());
						
	$this->db->select('*. tbl_logins.id as tl_id')
			->from('tbl_logins')
			->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
			->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
			->where('tbl_logins.type', $status)*/
}