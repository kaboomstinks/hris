<?php 

class admin_model extends CI_Model {
	
	public function UserTable_record_count() {
		return $this->db->count_all("tbl_logins");
	}

    
    public function get_company() {
        return $this->db->select('*')
        				->from('tbl_company')   
        				->get()
        				->result_array();
    }

    public function allAttendanceViewGeneration(){
    	
    	$file_path  = (!empty($_GET['file'])) ? $_GET['file'] :  "";


		if (file_exists($file_path)) {

			$openFile = fopen(base_url().'document/biometrics_data.txt', 'r');
			// $getDatetimeNow = '2015/01/23';
			$tempnum = NULL;
			
			while (!feof($openFile)) {
				$arrM = explode('\n',fgets($openFile));
				$val = current($arrM);

				if(!strstr($val,'No')){         // looping not including the title headers

					while ($val) {
						$thisrow = explode('	', $val);
						$getLatestDate = explode('  ', $thisrow[6]);

						if($tempnum != $thisrow[2]){

								$query = $this->db->query("SELECT tbl_employee_info.emp_id, tbl_employee_info.emp_code, tbl_attendance_shift.id as shiftid FROM tbl_employee_info
															INNER JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
															WHERE bm_id = '" .$thisrow[2]. "'");
								$record = $query->num_rows();

								if($record){
									$r = $query->row_array();
									
									$datetime_txt = trim($thisrow[6]); 	// datetime from txt
									$time = $getLatestDate[1]; 			// time from text
									$emp_id = $r['emp_id'];
									$emp_code = $r['emp_code'];
									$shift = $r['shiftid'];
									

									if($r['shiftid'] == 1){  
										$shift_time_in = '8:00';
										$shift_time_iout = '17:00';
									} elseif($r['shiftid'] == 2) {
										$shift_time_in = '16:00';
										$shift_time_iout = '1:00';
									} else {
										$shift_time_in = '9:00';
										$shift_time_iout = '18:00';
									}


								
									//start of things
									
									$duplicate = $this->checkDuplicateInAllAttendRec($emp_id, $datetime_txt);
									
									if($duplicate['numrows'] == 0){
										$exist = $this->checkExist($emp_id);	
										$db_datetime_in = $exist['datetime_in'];	// datetime_in in tbl_allattendance_rec
										$db_datetime_out = $exist['datetime_out'];	// datetime_out in tbl_allattendance_rec
										$allattendance_id = $exist['id'];			// id of every record in tbl_allattendance_rec
										
										switch($shift){
											
											case 1:	   // am and mid shift have the same functions
											case 3: 
											
												if(empty($db_datetime_in)){           
													$this->insertTimeInAllAttendRec($emp_id, $emp_code, $shift, $datetime_txt);  
												} else {
													
													$existTimeInAllAttend = $this->checkExistTimeInAllAttend($emp_id, $datetime_txt);
													if($existTimeInAllAttend['datetime_in'] != $datetime_txt){
														$this->updateTimeOutAllAttend($datetime_txt, $allattendance_id);
													}
												}
												break;	
										}	
										
										
									}	 
								}										
						}

						$tempnum = $thisrow[2];
						$val = next ($arrM);
						
					}
				}
			}
		}
		
		
		// start of getting records from tbl_allattendance_rec
		
		$q = $this->db->query("SELECT tbl_allattendance_rec.emp_id, tbl_allattendance_rec.emp_code, tbl_allattendance_rec.shift, tbl_allattendance_rec.datetime_in, tbl_allattendance_rec.datetime_out, tbl_person_info.firstname, tbl_person_info.lastname, tbl_departments.dep_abbr 
								FROM tbl_allattendance_rec 
								LEFT JOIN tbl_person_info ON tbl_allattendance_rec.emp_id = tbl_person_info.id
								LEFT JOIN tbl_employee_info ON tbl_allattendance_rec.emp_id = tbl_employee_info.emp_id
								LEFT JOIN tbl_departments ON tbl_employee_info.department = tbl_departments.id
								ORDER BY datetime_in");
		$data = $q->result_array();
		return $data;
    }
	
	public function viewBy_AllAttendance(){
		$company = $this->input->post('company');
		$dep = $this->input->post('dep');
		$d = $this->input->post('date');
		$date = date('Y-m-d', strtotime($d));
		$html = "";
		
		if($d == ''){
			$date = '';
		}
		
		$q = "SELECT tbl_allattendance_rec.emp_id, tbl_allattendance_rec.emp_code, tbl_allattendance_rec.shift, tbl_allattendance_rec.datetime_in, tbl_allattendance_rec.datetime_out, tbl_person_info.firstname, tbl_person_info.lastname, tbl_departments.dep_abbr 
			FROM tbl_allattendance_rec 
			LEFT JOIN tbl_person_info ON tbl_allattendance_rec.emp_id = tbl_person_info.id
			LEFT JOIN tbl_employee_info ON tbl_allattendance_rec.emp_id = tbl_employee_info.emp_id
			LEFT JOIN tbl_departments ON tbl_employee_info.department = tbl_departments.id
			WHERE date(tbl_allattendance_rec.datetime_in) LIKE '%$date%'";
		
		
		if($company != 0){
			$q .= " AND tbl_employee_info.company = $company";
		}
		
		if($dep != 0 && $dep != null){
			$q .= " AND tbl_employee_info.department = $dep";
		}
		
		$q .= " ORDER BY tbl_allattendance_rec.datetime_in";
		
								
		$getAllBy = $this->db->query($q);
		$record = $getAllBy->num_rows();
			
		if($record){
			
			foreach($getAllBy->result_array() as $r){
			
				$fullname = $r['firstname'].' '.$r['lastname'];
				$emp_code = $r['emp_code'];
				$dep_abbr = $r['dep_abbr'];
				$shift_start = '08:00';
				$shift_end = '17:00';
				$shift_word = 'AM';
				
				
				if($r['shift'] == 2) {
					$shift_start = '16:00';
					$shift_end = '01:00';	
					$shift_word = 'PM';
				}

				if($r['shift'] == 3) {
					$shift_start = '09:00';
					$shift_end = '18:00';	
					$shift_word = 'Mid';
				} 		
				
				if($r['datetime_in'] == ''){
					$time_in = '';
				} else {
					$time_in = date('H:i', strtotime($r['datetime_in']));	
				}
				
				if($r['datetime_out'] == ''){
					$time_out = '';
				} else {
					$time_out = date('H:i', strtotime($r['datetime_out']));
				}
				
				$html .= '<tr>';
				$html .= '<td width="100px">'.$emp_code.'</td>';
				$html .= '<td width="175px">'.$fullname.'</td>';
				$html .= '<td width="100px">'.$r["dep_abbr"].'</td>';
				$html .= '<td width="50px">'.$shift_word.'</td>';
				$html .= '<td width="90px">'.$shift_start.'</td>';
				$html .= '<td width="90px">'.$shift_end.'</td>';
				$html .= '<td width="90px">'.$time_in.'</td>';
				$html .= '<td width="90px">'.$time_out.'</td>';
				$html .= '<td><a href="'.base_url().'admin/admin_personalattendance_cpanel?emp_code='.$emp_code.'" class="btn btn-default">Personal</a></td>';
				$html .= '</tr>';
			
			} 
			
		} else {
			$html .= 'No data...';
		}
							
		return $html;							
	}
	
	function checkDuplicateInAllAttendRec($emp_id, $datetime){			// check if there's such a record in tbl_allattendance_rec table with either datetime_in or datetime_out having values
	
		$q = mysql_query("SELECT * FROM tbl_allattendance_rec WHERE emp_id = '$emp_id' AND (datetime_in = '$datetime' OR datetime_out = '$datetime')");
		$data['row'] = mysql_fetch_assoc($q);
		$data['numrows'] = mysql_num_rows($q);
		return $data;
	}
	
	function checkExist($emp_id){		//check if it exists   
	
		$sql= "SELECT * FROM tbl_allattendance_rec WHERE emp_id = $emp_id AND (datetime_in = '' OR datetime_out = '')";
		$q = mysql_query($sql);
		$row = mysql_fetch_assoc($q);	
		return $row;
	}
	
	function insertTimeInAllAttendRec($emp_id, $emp_code, $shift, $datetime){			// insert datetime in datetime_in column
		mysql_query("INSERT INTO tbl_allattendance_rec(emp_id, emp_code, shift, datetime_in) VALUES ($emp_id, '$emp_code', $shift, '$datetime')");
	}
	
	function checkExistTimeInAllAttend($emp_id, $datetime){			// check if an employee has datetime_in value the same as datetime($datetime_txt) from txt
		
		$q = mysql_query("SELECT * FROM tbl_allattendance_rec WHERE emp_id = $emp_id AND datetime_in = '$datetime'");
		$row = mysql_fetch_assoc($q);
		return $row;
	}
	
	function updateTimeOutAllAttend($datetime, $id){
		mysql_query("UPDATE tbl_allattendance_rec SET datetime_out = '$datetime' WHERE id = $id");
	}
	
	
	public function personalAttendanceViewGeneration(){
		$emp_code = $this->input->get('emp_code');
		$q = $this->db->select('tbl_allattendance_rec.shift, tbl_allattendance_rec.datetime_in, tbl_allattendance_rec.datetime_out,  tbl_allattendance_rec.created_at,tbl_allattendance_rec.emp_code,tbl_person_info.firstname, tbl_person_info.lastname')
					  ->from('tbl_allattendance_rec')
					  ->join('tbl_person_info','tbl_allattendance_rec.emp_id = tbl_person_info.id')
					  ->where('emp_code ',$emp_code);
		$data =$q->get()->result_array();

		return $data;
		
	}
	
	public function personalAttendanceDateGeneration(){
		$emp_code = $this->input->post('employee_c');
		//==========DATE IN DATE FORMAT======/
		$din = $this->input->post('begindate');
		$date_in = trim(date('Y/m/d', strtotime($din)));
		
		$dout = $this->input->post('endsched');
		$date_out =trim(date('Y/m/d', strtotime($dout)));
		//===============================/
		$datetoday = new DateTime();
		$datenow = $datetoday->format('Y/m/d ');
			
		$defaultdate = (empty($date_out)?$date_out:$datenow);
	//	fn_print_r($date_out);
		//2nd query
		// $defaultdate = (empty($dout)?$dout:$datenow);
		//fn_print_die($emp_code,$date_in,$defaultdate);
		$html = "";
		if($date_out != '1970/01/01')
		{
		$personal_query = $this->db->query( "SELECT   r.shift,
														  (DATE_FORMAT(r.datetime_in, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_in, '%Y/%m/%d') <= '{$date_out}') ,
														  (DATE_FORMAT(r.datetime_out, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_out, '%Y/%m/%d') <= '{$date_out}') ,
														  r.datetime_in,
														  r.datetime_out,
														 r.emp_code,
														  r.created_at,
														  i.firstname,
														  i.lastname 
														   FROM  tbl_allattendance_rec r
															JOIN tbl_person_info i 
															ON r.emp_id = i.Id 
															 WHERE r.emp_code = '{$emp_code}'  AND
															(
																(DATE_FORMAT(r.datetime_in, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_in, '%Y/%m/%d') <= '{$date_out}') = 1
															) AND
															(
																(DATE_FORMAT(r.datetime_out, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_out, '%Y/%m/%d') <= '{$date_out}') = 1
															)
															
															" );
															
															
		}else{
				$personal_query = $this->db->query( "SELECT   r.shift,
														  (DATE_FORMAT(r.datetime_in, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_in, '%Y/%m/%d') <= '{$defaultdate}') ,
														  (DATE_FORMAT(r.datetime_out, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_out, '%Y/%m/%d') <= '{$defaultdate}') ,
														  r.datetime_in,
														  r.datetime_out,
														 r.emp_code,
														  r.created_at,
														  i.firstname,
														  i.lastname 
														   FROM  tbl_allattendance_rec r
															JOIN tbl_person_info i 
															ON r.emp_id = i.Id 
															 WHERE r.emp_code = '{$emp_code}'  AND
															(
																(DATE_FORMAT(r.datetime_in, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_in, '%Y/%m/%d') <= '{$defaultdate}') = 1
															) AND
															(
																(DATE_FORMAT(r.datetime_out, '%Y/%m/%d') >= '{$date_in}' AND DATE_FORMAT(r.datetime_out, '%Y/%m/%d') <= '{$defaultdate}') = 1
															)
															
															" );
															
	}
															 
		//fn_print_r($personal_query,$this->db->last_query());
		$getAllPersonal = $personal_query->result_array();

	if($getAllPersonal){
			//fn_print_die($getAllPersonal);
			foreach($getAllPersonal as $personalRecord){
			
			$d_shift = $personalRecord['shift'];
			$d_shift_name = $d_shift != 1 ? 'PM ' : 'AM';
			
			$d_shift = $personalRecord['shift'];
			$d_start = $d_shift != 1 ? '16:00 ' : '8:00';
			
			$d_shift = $personalRecord['shift'];
			$d_end = $d_shift != 1 ? '1:00 ' : '17:00';
			
			$dateformat=$personalRecord['datetime_in'];
			$dateformat_out = $personalRecord['datetime_out'];
			$datein = date('F d, Y',strtotime($dateformat));
			$time_format =  date('h:i',strtotime($dateformat));
			
			

			$dateout = date('F d, Y',strtotime($dateformat));
			$time_format_out =  date('h:i',strtotime($dateformat_out));
					//	fn_print_r($time_format_out);
				$html .= '<tr>';
				$html .= '<td width="113px">'.$datein.'</td>';
				$html .= '<td width="118px">'.$d_shift_name.'</td>';
				$html .= '<td width="95px">'.$d_start.'</td>';
				$html .= '<td width="115px">'.$d_end.'</td>';
				$html .= '<td width="80px">'.$time_format.'</td>';
				$html .= '<td width="60px">'.$time_format_out.'</td>';
				$html .= '</tr>';	

			}
		
	}else{
		$html .='No data....,';
	}	
									
		return $html;
	}
	
	public function get_personalinfo(){	
	$emp_codes = $this->input->get('emp_code');
	$query = $this->db->query("SELECT tbl_employee_info.emp_code, tbl_company.company_name, tbl_departments.dep_name, tbl_person_info.firstname, tbl_person_info.lastname
												FROM
													tbl_person_info
												LEFT JOIN
													tbl_employee_info
												ON
													tbl_person_info.id = tbl_employee_info.emp_id
												LEFT JOIN
													tbl_company
												ON
													tbl_employee_info.company = tbl_company.id
												LEFT JOIN
													tbl_departments
												ON
													tbl_employee_info.department = tbl_departments.id

												WHERE tbl_employee_info.emp_code ='$emp_codes';");
													
			$data = $query->result_array();
			return $data;
	
	}
	
	
	public function bioViewGeneration(){

		$file_path  = (!empty($_GET['file'])) ? $_GET['file'] :  "";
		
		if (file_exists($file_path)) {

			$openFile = fopen(base_url().$file_path, 'r');
			$getDatetimeNow = '2015/01/27';
			$tempnum = NULL;
			$bio_id_txt = array();
			$date_txt = array();
			$timein_txt = array();
			$datefetched ='';
			$thisrow = '';
			$idOntime = array();
			while (!feof($openFile)) {
				$arrM = explode('\n',fgets($openFile));
				$val = current($arrM);

				if(!strstr($val,'No')){         // looping not including the title headers

					while ($val) {
						$thisrow = explode("\t", $val);
						
						if (count($thisrow) == 7) // we only fetch that has complete array element
						{	
						
						
							$datefetched = explode(" ",$thisrow[6]);
							$temp_date_txt = $datefetched[0];
							$temp_time_in = date("H:i:s", strtotime($datefetched[2]));
							$morning_time = date("H:i",strtotime("8:00"));
							
							
							$shift = !empty($_GET['shift']) ? $_GET['shift'] : 1;
							$defaulttime = '08:00';
						
							if ($shift == 2)
							{
								$defaulttime = '16:00';
							}

							if($shift == 3){
								$defaulttime == '09:00';
							}
							
							if ( date("H:i",strtotime($defaulttime)) < date("H:i", strtotime($datefetched[2])))
							{	
								
							} else
							{
								$idOntime[] =  $thisrow[2]; // no late
							}
								$date_txt[] =  $datefetched[0];
								$timein_txt[] = $datefetched[2];
								$bio_id_txt[] = $thisrow[2];

						/*
						$thisrow = explode('	', $val);
						$getLatestDate = explode('  ', $thisrow[6]);

						if(($getDatetimeNow == $getLatestDate[0]) && ($tempnum != $thisrow[2])){

							$bio_id_txt[] = $thisrow[2];
							$date_txt[] = $getLatestDate[0];
							$timein_txt[] = $getLatestDate[1];		
						
						} */


							$tempnum = $thisrow[2];
						}
						$val = next ($arrM);
						
					}
				}
			}

		} else {
			//return '{"message" : "The file $file_path does not exist"}';
			return array();
		}						
		// var_dump($idOntime);die();
		

		/******************************** End of reading flat file	**********************************/	

														
		$getAllBioID = $this->db->query('SELECT DISTINCT bm_id FROM tbl_employee_info');
	
		foreach($getAllBioID->result_array() as $row2){
			$bio_id_db[] = $row2['bm_id'];
		} 

		$array_count2 = count($bio_id_db) - 1; 

		for ($j=0; $j <= $array_count2; $j++) { 
			$key = array_search($bio_id_db[$j], $bio_id_txt);  // will search if biometrics id from db is inside the biometrics id from textfile 
			$isIn = in_array($bio_id_db[$j], $bio_id_txt);


			if ($isIn)	{	

					$bio_data[] = $this->populateData('Late', $bio_id_txt, null, $timein_txt, $j, $key, $isIn);
					
			}else {
				
					$ispresent = array_search($bio_id_db[$j], $idOntime);

					 if (!$isIn)	
					{
						$bio_data[] = $this->populateData('Absent', null, $bio_id_db, null, $j, null, $isIn);
					 }
			}	
		}	

	
		return is_array($bio_data) ? $bio_data : array();
    }


    /******************************** End of population of data	**********************************/	

    public function populateData($stat, $bio_id_txt, $bio_id_db, $timein_txt, $j, $key, $isIn){

			
		$data['html'] = '';
			if($stat == 'Late'){
				$bm_id = $bio_id_txt[$key];
				$timein = $timein_txt[$key];
			}

			if($stat == 'Absent'){
				$bm_id = $bio_id_db[$j];
				//$bm_id = $bio_id_txt[$key];
				$timein = 'No Time In';	 
			}

			$current_date = date("Y-m-d"); 

			$sql = "SELECT tbl_employee_info.emp_id, tbl_employee_info.company, tbl_employee_info.emp_code, tbl_employee_info.department, tbl_employee_info.position, tbl_person_info.firstname, tbl_person_info.lastname, tbl_company.company_name, tbl_departments.dep_name, tbl_attendance_shift.shift_time_in
						FROM tbl_employee_info
						LEFT JOIN tbl_person_info ON tbl_employee_info.emp_id = tbl_person_info.id
						LEFT JOIN tbl_company ON tbl_employee_info.company = tbl_company.id
						LEFT JOIN tbl_departments ON tbl_employee_info.department = tbl_departments.id
						LEFT JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
						WHERE bm_id = $bm_id";   // you can either use $bio_id_txt or $bio_id_db 
			
				$getEmployeeData = $this->db->query($sql);

				$row = $getEmployeeData->row_array();
				
				$fullname = $row['firstname'].' '.$row['lastname'];
				$company = $row['company_name'];
				$department = $row['dep_name'];
				$position = $row['position'];
				$emp_code = $row['emp_code'];
				$emp_id = $row['emp_id'];
				$shift_time_in = $row['shift_time_in'];
				$shift = !empty($_GET['shift']) ? $_GET['shift'] : 1;
				 $defaulttime = '08:00';
				if ($shift == 2)
				{
					$defaulttime = '16:00';
				}	

				if($shift == 3){
					$defaulttime = '09:00';
				}

				      // echo ($shift.' - '.$shift_time_in.' - '.$defaulttime.' - '.$timein_txt[$key].' - '.$fullname.'<br />');

				if ($shift_time_in == $defaulttime)
				{

					// daily attendance check 
					$sqlDailyAttandance ="select id from  tbl_daily_attendance where emp_id = $emp_id and date(created_at) ='$current_date' ";
					$isDailyAttenandceExist = $this->db->query($sqlDailyAttandance);
					$isAttendanceRow = $isDailyAttenandceExist->row_array();
					// end daily attendance check

					// change time check 
					
					$sqlChangeSched ="select id from  tbl_changesched where emp_id = $emp_id and '$current_date' BETWEEN date_from AND date_to and status = 1";
					$isChangeSchedExist = $this->db->query($sqlChangeSched);
					$isChangeSchedRow = $isChangeSchedExist->row_array();

					$dataShouldDisplay = true; // by default we allow information to display
					if ($isAttendanceRow)  $dataShouldDisplay = false;
					if ($isChangeSchedRow)  $dataShouldDisplay = false;

					// end change time check 
					if ($dataShouldDisplay) // 
					{	
						
						if($row){     // if biometric ID found has data associated with it

							if($timein > $shift_time_in && $isIn){		// this dumps late data
								$status = "<td width='80px'><input type='radio' name='status$j' class='r_late status' value='Late' checked=checked />&nbsp;Late<br /><input type='radio' name='status$j' class='r_absent status' value='Absent' />&nbsp;Absent<input type='radio' name='status$j' class='r_offset status' value='0' />&nbsp;Offset</td>";	
								$wholedata_array = json_encode(array('emp_id' => $emp_id, 'emp_code' => $emp_code, 'timein' => $timein));	

								$data['html'] .= "<tr id='$emp_code'>
									<input type='hidden' name='wholedata[]' value='$wholedata_array'>
									<input type='hidden' name='emp_code[]' value='$emp_code'>	
									<td width='118px'>$company </td>
									<td width='118px'>$department</td>
									<td width='100px'>$position</td>
									<td width='115px'>$fullname</td>
									<td width='80px'><input type='hidden' name='timein' value='$timein'>$timein</td>".$status."
									<td><textarea type='text' name='reason[]'></textarea></td>
									<td><textarea type='text' name='remark[]'></textarea></td>
								</tr>";

							}

							if(!$isIn){									// this dumps absent data
								$status = "<td width='80px'><input type='radio' name='status$j' class='r_late status' value='Late' />&nbsp;Late<br /><input type='radio' name='status$j' class='r_absent status' value='Absent' checked=checked />&nbsp;Absent<input type='radio' name='status$j' class='r_offset status' value='0' />&nbsp;Offset</td>";
								$wholedata_array = json_encode(array('emp_id' => $emp_id, 'emp_code' => $emp_code, 'timein' => $timein));	
								
								$data['html'] .= "<tr id='$emp_code'>
									<input type='hidden' name='wholedata[]' value='$wholedata_array'>
									<input type='hidden' name='emp_code[]' value='$emp_code'>	
									<td width='118px'>$company </td>
									<td width='118px'>$department  </td>
									<td width='100px'>$position</td>
									<td width='115px'>$fullname</td>
									<td width='80px'><input type='hidden' name='timein' value='$timein'>$timein</td>".$status."
									<td><textarea type='text' name='reason[]'></textarea></td>
									<td><textarea type='text' name='remark[]'></textarea></td>
								</tr>";

							}
						}
						
						}	

					
					return $data;
				}		
		}

	
	//====================================================Add User================================================//
	
	public function adduser(){
		$fname = trim($this->input->post('fname'));
		$mname = trim($this->input->post('mname'));
		$lname = trim($this->input->post('lname'));
		$username = trim($this->input->post('username'));
		$bm_id = trim($this->input->post('bm_id'));
		$company = $this->input->post('company');
		$department = $this->input->post('department');
		$restday = $this->input->post('restday');
		$emp_code = $username; 	
		$password = md5($username);
		$role = $this->input->post('role');
		$shift = $this->input->post('shift');
		$updatedby = $this->session->userdata['usersession'];

		$bm_id_length = strlen($bm_id);
		$bm_zeros_length = 8 - $bm_id_length;
		$bm_zeros = '';

		for ($i=1; $i<=$bm_zeros_length; $i++) { 
			$bm_zeros .= '0'; 	
		}

		$biometrics_id = $bm_zeros.$bm_id;   // this adds zeros in inputted bm id 

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
					
						$values3 = array('emp_id' => $tbl_person_id, 'emp_code' => $emp_code, 'employer' => $company, 'bm_id' => $biometrics_id, 'company' => $company, 'department' => $department, 'shift' => $shift, 'rest_day' => $restday, 'updated_by' => $updatedby);
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
	
	public function AttendanceTable_record_count($type, $search) {
		$query = $this->db->query("SELECT *, tbl_departments.dep_name, tbl_daily_attendance.id as tda_id FROM tbl_daily_attendance 
						INNER JOIN tbl_employee_info ON tbl_daily_attendance.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company 
						WHERE tbl_daily_attendance.type = '{$type}' 
						AND (tbl_employee_info.company LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_daily_attendance.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%'
						OR tbl_company.company_name LIKE '%{$search}%')");

		return $query->num_rows();
    }

	public function getAttendanceTable($limit, $start, $search, $fieldname, $sort, $type){
   		$thisquery = "SELECT *, tbl_departments.dep_name, tbl_daily_attendance.id as tda_id FROM tbl_daily_attendance 
						INNER JOIN tbl_employee_info ON tbl_daily_attendance.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company 
						WHERE tbl_daily_attendance.type = '{$type}' 
						AND (tbl_employee_info.company LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_daily_attendance.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%'
						OR tbl_company.company_name LIKE '%{$search}%')";


		 if (($fieldname && $sort) != (null || '')) {
		 	$fieldname == 'firstname' ? $fieldname = 'tbl_person_info.firstname' : $fieldname = 'tbl_daily_attendance.date_filed'; 

		 	$thisquery .= "ORDER BY $fieldname $sort";
		 }else {
		 	$thisquery .= "ORDER BY tbl_daily_attendance.date_filed DESC";
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

		if(!empty($emp_code)){
			$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
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
				$this->session->set_flashdata('notification', 'Successfully Saved');
			} else {
				$this->session->set_flashdata('notification', 'Failed to save');
			}	
		}else {
			$this->session->set_flashdata('notification', 'Invalid employee name');
		}

			
	}

	public function update_status($status){
		$updatedby = $this->session->userdata['usersession'];
		$this->db->where('emp_id', $status['id'])->update('tbl_daily_attendance', array('status' => $status['status'], 'updated_by' => $updatedby)); 
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
	public function LeaveTable_record_count($status, $search) {
		$query = $this->db->query("SELECT *, tbl_departments.dep_name, tbl_leaves.id as lid FROM tbl_leaves 
						INNER JOIN tbl_employee_info ON tbl_leaves.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id 
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company 
						WHERE tbl_leaves.status = '{$status}' 
						AND (tbl_company.company_name LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_leaves.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%' 
						OR tbl_leaves.type LIKE '%{$search}%')");
		return $query->num_rows();
    }

   	public function getLeaveTable($limit, $start, $search, $fieldname, $sort, $status){

   		$thisquery = "SELECT *, tbl_departments.dep_name, tbl_leaves.id as lid FROM tbl_leaves 
						INNER JOIN tbl_employee_info ON tbl_leaves.emp_id = tbl_employee_info.emp_id 
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id 
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company 
						WHERE tbl_leaves.status = '{$status}' 
						AND (tbl_company.company_name LIKE '%{$search}%' 
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
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
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

		$id = @$emp_id['emp_id'];
		if ($id) {
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
				$this->session->set_flashdata('notification', 'Successfully Saved!');
			} else {
				$this->session->set_flashdata('notification', 'Failed to save!');
			}
		}else{
			$this->session->set_flashdata('notification', 'User not existing!');
		}

	}

	public function insertChangeSchedForm(){
		$emp_code = $this->input->post('emp_code');
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
		$emp_id  = $getThisID->row_array();
		$remarks = $this->input->post('remarks');
		$totalhours = $this->input->post('totalhours');

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

		$id = @$emp_id['emp_id'];
		if ($id) {
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
				'totalhours' => $totalhours,
				'remarks' => $remarks,
				'updated_by' => $updatedby
				);

			$this->db->insert('tbl_changesched', $data);
			$cid = $this->db->insert_id();

			if($cid){
				$this->session->set_flashdata('notification', 'Successfully Saved!');
			} else {
				$this->session->set_flashdata('notification', 'Failed to save');
			}
		}else{
			$this->session->set_flashdata('notification', 'User not existing!');
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

	public function ChangeTable_record_count($status, $search) {


		$query = $this->db->query("SELECT *, tbl_departments.dep_name, tbl_changesched.id as cid 
						FROM tbl_changesched 
						INNER JOIN tbl_employee_info ON tbl_changesched.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id 
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company
						WHERE tbl_changesched.status = '{$status}' 
						AND (tbl_company.company_name LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_changesched.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%')");

		return $query->num_rows();
    }

	public function getChangeSchedTable($limit, $start, $search, $fieldname, $sort, $status){
					

		 $thisquery = "SELECT *, tbl_departments.dep_name, tbl_changesched.id as cid 
						FROM tbl_changesched 
						INNER JOIN tbl_employee_info ON tbl_changesched.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id 
						INNER JOIN tbl_departments ON tbl_departments.id = tbl_employee_info.department 
						INNER JOIN tbl_company ON tbl_company.id = tbl_employee_info.company
						WHERE tbl_changesched.status = '{$status}' 
						AND (tbl_company.company_name LIKE '%{$search}%' 
						OR tbl_employee_info.department LIKE '%{$search}%' 
						OR tbl_employee_info.position LIKE '%{$search}%' 
						OR tbl_changesched.emp_code LIKE '%{$search}%' 
						OR tbl_person_info.firstname LIKE '%{$search}%' 
						OR tbl_person_info.middlename LIKE '%{$search}%' 
						OR tbl_person_info.lastname LIKE '%{$search}%')";
						
							
		 if (($fieldname && $sort) != (null || '')) {
		 	$fieldname == 'firstname' ? $fieldname = 'tbl_person_info.firstname' : $fieldname = 'tbl_changesched.date_from';

		 	$thisquery .= "ORDER BY $fieldname $sort";
		 } else {
		 	$thisquery .= "ORDER BY tbl_changesched.created_at DESC";
		 }

		 $thisquery .= " LIMIT {$start}, {$limit}";

		 $getChangeSchedTable = $this->db->query($thisquery);
		
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
			'totalhours' => $totalhours,
			'remarks' => $remarks,
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
			'status' => $row['status'],
			'totalhours' => $row['totalhours'],
			'remarks' => $row['remarks']
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
		$this->db->join('tbl_company', 'tbl_company.id = tbl_employee_info.company');
		$this->db->like('tbl_company.company_name', $search);
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

		// $this->db->distinct();				// old query in CI 
		// $this->db->select('tbl_logins.id, tbl_logins.emp_id, tbl_logins.username, tbl_person_info.lastname, tbl_person_info.middlename, tbl_person_info.firstname, tbl_employee_info.company, tbl_employee_info.is_active, tbl_employee_info.shift, tbl_company.company_name, tbl_logins.id as tl_id, tbl_logins.emp_id as tl_emp, tbl_changesched.date_from, tbl_changesched.date_to, tbl_changesched.changetype, tbl_changesched.status');
		// $this->db->from('tbl_logins');
		// $this->db->join('tbl_person_info', 'tbl_logins.emp_id = tbl_person_info.id', 'left');
		// $this->db->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id', 'left');
		// $this->db->join('tbl_company', 'tbl_company.id = tbl_employee_info.company', 'left');
		// $this->db->join('tbl_changesched', 'tbl_employee_info.emp_id = tbl_changesched.emp_id', 'left');
		// $this->db->like('tbl_company.company_name', $search);
		// $this->db->or_like('tbl_logins.username', $search);
		// $this->db->or_like('tbl_person_info.lastname', $search);
		// $this->db->or_like('tbl_person_info.firstname', $search);
		// $this->db->or_like('tbl_person_info.middlename', $search);
		// $this->db->limit($limit, $start);   
		
		$datenow = date('Y-m-d');
		
		$thisquery = "SELECT tbl_logins.emp_id, tbl_logins.username, tbl_person_info.lastname, tbl_person_info.middlename, tbl_person_info.firstname, tbl_employee_info.company, tbl_employee_info.is_active, tbl_employee_info.shift, tbl_company.company_name, tbl_logins.id as tl_id, tbl_logins.emp_id as tl_emp, changesched.date_from, changesched.date_to, changesched.changetype, changesched.status
						FROM tbl_logins
						LEFT JOIN tbl_person_info ON tbl_logins.emp_id = tbl_person_info.id
						LEFT JOIN tbl_employee_info ON tbl_logins.emp_id = tbl_employee_info.emp_id
						LEFT JOIN tbl_company ON tbl_company.id = tbl_employee_info.company

						LEFT JOIN (select emp_id, date_from, date_to, changetype, status
									from tbl_changesched
									where date_from <= '$datenow' and date_to >= '$datenow') changesched ON changesched.emp_id = tbl_employee_info.emp_id

						WHERE  tbl_company.company_name LIKE '%$search%'
						OR tbl_logins.username LIKE '%s$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'";
										
		
		if (($fieldname && $sort) != (null || '')) {
			$thisquery .= " ORDER BY $fieldname $sort";
		} else {
			$thisquery .= " ORDER BY tbl_logins.id DESC";
		}
		
		$thisquery .= " LIMIT {$start}, {$limit}";		

		// fn_print_die($thisquery);		
		
		$getUserTable = $this->db->query($thisquery);
		
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
    }
	
	public function UsersTable_record_count($search) {

		$getUserTable = $this->db->distinct()->select('*, tbl_company.company_name, tbl_logins.id as tl_id, tbl_logins.emp_id as tl_emp')
								 ->from('tbl_logins')
								 ->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id', 'left')
								 ->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id', 'left')
								 ->join('tbl_company', 'tbl_company.id = tbl_employee_info.company', 'left')
								 ->like('tbl_company.company_name', $search)
								 ->or_like('tbl_logins.username', $search)
								 ->or_like('tbl_person_info.lastname', $search)
								 ->or_like('tbl_person_info.firstname', $search)
								 ->or_like('tbl_person_info.middlename', $search)
								 ->get()
								 ->num_rows();
								 
        return $getUserTable;
    }

    public function dep_count() {
        return $this->db->count_all("tbl_departments");
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
		$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
		$emp_id  = $getThisID->row_array();
		$updatedby = $this->session->userdata['usersession'];
	
		$purpose = $this->input->post('emp_purpose');
		$reason = $this->input->post('emp_reason');
		$remark = $this->input->post('emp_remark');
		$approval = $this->input->post('emp_approval');
		
		$id = @$emp_id['emp_id'];
		if ($id) {
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
				$this->session->set_flashdata('notification', 'Successfully Saved!');
			} else {
				$this->session->set_flashdata('notification', 'Failed to save');
			}
		}else{
			$this->session->set_flashdata('notification', 'User not existing!');
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
			return '{"success": 1, "msg": "Successfully Added!"}'; 
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
			return '{"success": 1, "msg": "Succesfully Updated!"}';
		} else {
			return '{"success": 0, "msg": "No changes have been made"}';
		}
	}

	public function getAllDepartment($limit, $start){

		$this->db->limit($limit, $start);
        $query = $this->db->get("tbl_departments");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

		// $query = $this->db->get('tbl_departments');
		// $data = $query->result_array();
		// return $data;
	}

	public function getAllDepartments(){
		$query = $this->db->get('tbl_departments');
		$data = $query->result_array();
		return $data;
	}

	public function getAllCompanies(){
		$query = $this->db->get('tbl_company');
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
			return '{"success": 1, "msg": "Successfully Added!"}';
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
			return '{"success": 1, "msg": "Successfully Updated!"}';
		} else {
			return '{"success": 0, "msg": "Failed to update a department"}';
		}
	}

	public function editDepartment(){
		$id = $this->input->post('id');
		$query = $this->db->select('tbl_departments.*')->get_where('tbl_departments', array('tbl_departments.id' => $id));

		$row = $query->row_array();

		$data = array('dep_name' => $row['dep_name'], 'dep_abbr' => $row['dep_abbr'], 'company_id' => $row['company_id']);
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

	public function getAllBenefit($limit, $start, $search, $fieldname, $sort){
		$search = $this->input->get('search');
		$this->db->select('tbl_benefits.*, tbl_person_info.firstname, tbl_person_info.lastname, tbl_benefits.id as bid')
				  ->from('tbl_benefits')
				  ->join('tbl_person_info', 'tbl_benefits.emp_id = tbl_person_info.id')
				  ->like('tbl_person_info.firstname', $search)
				  ->like('tbl_person_info.middlename', $search)
				  ->like('tbl_person_info.lastname', $search)
				  ->limit($limit, $start);


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
				 ->where('tbl_employee_info.is_active', 0)
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
			return '{"success": 1, "msg": "Successfully Added!"}';
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