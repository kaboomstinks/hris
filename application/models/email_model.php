<?php

class email_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Singapore');
	}

	public function get_leave(){

		$current_time = strtotime(date('m/d/y h:i a'));
		$am_start = strtotime(date('m/d/y'). ' 7:00 am');
		$am_end = strtotime(date('m/d/y'). ' 4:00 pm');
		$pm_start = strtotime(date('m/d/y'). ' 4:01 pm');
		$pm_end = strtotime(date('m/d/y'). ' 7:59 am');

		if ( $current_time >= $am_start && $current_time <= $am_end) {
			$time_start = date('m/d/y'). ' 7:00 am';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 4:00 pm';
			$accepted_datetime_end = strtotime($time_end);
		}elseif ($current_time >= $pm_start && $current_time <= $pm_end) {
			$time_start = date('m/d/y'). ' 4:01 pm';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 11:59 pm';
			$accepted_datetime_end = strtotime($time_end);
		}

		if(isset($accepted_datetime_start) || isset($accepted_datetime_end)){
			$this->db->select('tbl_leaves.id,
							tbl_leaves.type,
							tbl_leaves.reason,
							tbl_leaves.remark,
							tbl_leaves.date_from,
							tbl_leaves.date_to,
							tbl_employee_info.emp_code,
							tbl_employee_info.department,
							tbl_person_info.firstname,
							tbl_person_info.middlename,
							tbl_person_info.lastname,
							tbl_person_info.personal_email,
							tbl_departments.dep_abbr
							')
			->from('tbl_leaves')
			->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_leaves.emp_id')
			->join('tbl_person_info', 'tbl_person_info.id = tbl_leaves.emp_id')
			->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id')
			->where('date_filed >=',$accepted_datetime_start)
			->where('date_filed <=', $accepted_datetime_end);

			$leave_data = $this->db->get()->result_array();
			return $leave_data;

		}else {
			return '';
		}

	}

	public function get_late(){

		$current_time = strtotime(date('m/d/y h:i a'));
		$am_start = strtotime(date('m/d/y'). ' 7:00 am');
		$am_end = strtotime(date('m/d/y'). ' 4:00 pm');
		$pm_start = strtotime(date('m/d/y'). ' 4:01 pm');
		$pm_end = strtotime(date('m/d/y'). ' 11:59 pm');

		if ( $current_time >= $am_start && $current_time <= $am_end) {
			$time_start = date('m/d/y'). ' 7:00 am';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 4:00 pm';
			$accepted_datetime_end = strtotime($time_end);
		}elseif ($current_time >= $pm_start && $current_time <= $pm_end) {
			$time_start = date('m/d/y'). ' 4:01 pm';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 11:59 pm';
			$accepted_datetime_end = strtotime($time_end);
		}

		if(isset($accepted_datetime_start) || isset($accepted_datetime_end)){
			$this->db->select('*, tbl_daily_attendance.id as tda_id,
					   tbl_employee_info.emp_code,
					   tbl_employee_info.department,
					   tbl_person_info.firstname,
					   tbl_person_info.middlename,
					   tbl_person_info.lastname,
					   tbl_person_info.personal_email,
					   tbl_departments.dep_abbr')
			 ->from('tbl_daily_attendance')
			 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
			 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
			 ->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id')
			 ->where('tbl_daily_attendance.type', 'Late')
			 ->where('tbl_daily_attendance.reason <>', '')
			 ->where('date_filed >=',$accepted_datetime_start)
	 		 ->where('date_filed <=', $accepted_datetime_end);

			$attend_late = $this->db->get()->result_array();
			return $attend_late;
		} else {
			return '';
		}

		
	}

	public function get_late_no_notif(){

		$current_time = strtotime(date('m/d/y h:i a'));
		$am_start = strtotime(date('m/d/y'). ' 7:00 am');
		$am_end = strtotime(date('m/d/y'). ' 4:00 pm');
		$pm_start = strtotime(date('m/d/y'). ' 4:01 pm');
		$pm_end = strtotime(date('m/d/y'). ' 11:59 pm');

		if ( $current_time >= $am_start && $current_time <= $am_end) {
			$time_start = date('m/d/y'). ' 7:00 am';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 4:00 pm';
			$accepted_datetime_end = strtotime($time_end);
		}elseif ($current_time >= $pm_start && $current_time <= $pm_end) {
			$time_start = date('m/d/y'). ' 4:01 pm';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 11:59 pm';
			$accepted_datetime_end = strtotime($time_end);
		}

		if(isset($accepted_datetime_start) || isset($accepted_datetime_end)){
			$this->db->select('*, tbl_daily_attendance.id as tda_id,
						   tbl_employee_info.emp_code,
						   tbl_employee_info.department,
						   tbl_person_info.firstname,
						   tbl_person_info.middlename,
						   tbl_person_info.lastname,
						   tbl_person_info.personal_email,
						   tbl_departments.dep_abbr')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id')
				 ->where('tbl_daily_attendance.type', 'Late')
				 ->where('tbl_daily_attendance.reason', '')
				 ->where('date_filed >=',$accepted_datetime_start)
		 		 ->where('date_filed <=', $accepted_datetime_end);

			$attend_late_no_notif = $this->db->get()->result_array();
			return $attend_late_no_notif;
		} else {
			return '';
		}
	}

	public function get_absent(){

		$current_time = strtotime(date('m/d/y h:i a'));
		$am_start = strtotime(date('m/d/y'). ' 7:00 am');
		$am_end = strtotime(date('m/d/y'). ' 4:00 pm');
		$pm_start = strtotime(date('m/d/y'). ' 4:01 pm');
		$pm_end = strtotime(date('m/d/y'). ' 11:59 pm');

		if ( $current_time >= $am_start && $current_time <= $am_end) {
			$time_start = date('m/d/y'). ' 7:00 am';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 4:00 pm';
			$accepted_datetime_end = strtotime($time_end);
		}elseif ($current_time >= $pm_start && $current_time <= $pm_end) {
			$time_start = date('m/d/y'). ' 4:01 pm';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 11:59 pm';
			$accepted_datetime_end = strtotime($time_end);
		}

		if(isset($accepted_datetime_start) || isset($accepted_datetime_end)){
			$this->db->select('*, tbl_daily_attendance.id as tda_id,
						   tbl_employee_info.emp_code,
						   tbl_employee_info.department,
						   tbl_person_info.firstname,
						   tbl_person_info.middlename,
						   tbl_person_info.lastname,
						   tbl_person_info.personal_email,
						   tbl_departments.dep_abbr')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id')
				 ->where('tbl_daily_attendance.type', 'Absent')
				 ->where('date_filed >=',$accepted_datetime_start)
		 		 ->where('date_filed <=', $accepted_datetime_end);

			$attend_absent = $this->db->get()->result_array();
			return $attend_absent;
		}else {
			return '';
		}

		
	}

	public function get_awol(){

		$current_time = strtotime(date('m/d/y h:i a'));
		$am_start = strtotime(date('m/d/y'). ' 7:00 am');
		$am_end = strtotime(date('m/d/y'). ' 4:00 pm');
		$pm_start = strtotime(date('m/d/y'). ' 4:01 pm');
		$pm_end = strtotime(date('m/d/y'). ' 11:59 pm');

		if ( $current_time >= $am_start && $current_time <= $am_end) {
			$time_start = date('m/d/y'). ' 7:00 am';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 4:00 pm';
			$accepted_datetime_end = strtotime($time_end);
		}elseif ($current_time >= $pm_start && $current_time <= $pm_end) {
			$time_start = date('m/d/y'). ' 4:01 pm';
			$accepted_datetime_start = strtotime($time_start);

			$time_end = date('m/d/y'). ' 11:59 pm';
			$accepted_datetime_end = strtotime($time_end);
		}

		if(isset($accepted_datetime_start) || isset($accepted_datetime_end)){
			$this->db->select('*, tbl_daily_attendance.id as tda_id,
						   tbl_employee_info.emp_code,
						   tbl_employee_info.department,
						   tbl_person_info.firstname,
						   tbl_person_info.middlename,
						   tbl_person_info.lastname,
						   tbl_person_info.personal_email,
						   tbl_departments.dep_abbr')
				 ->from('tbl_daily_attendance')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_daily_attendance.emp_id')
				 ->join('tbl_person_info', 'tbl_person_info.id = tbl_daily_attendance.emp_id')
				 ->join('tbl_departments', 'tbl_employee_info.department = tbl_departments.id')
				 ->where('tbl_daily_attendance.type', 'Awol')
				 ->where('date_filed >=',$accepted_datetime_start)
		 		 ->where('date_filed <=', $accepted_datetime_end);

			$attend_awol = $this->db->get()->result_array();
			return $attend_awol;
		} else {
			return '';
		}
	}

	public function get_u_details($user){

		$data = $this->db->select('emp_id')
					   ->from('tbl_logins')
					   ->where('tbl_logins.emp_code', $user)
					   ->get()->row_array();

		$id = $data['emp_id'];

		$this->db->select('*')
				 ->from('tbl_person_info')
				 ->join('tbl_employee_info', 'tbl_employee_info.emp_id = tbl_person_info.id')
				 ->where('tbl_person_info.id', $id);

		$user_detail = $this->db->get()->row_array();

		return $user_detail;
	}

	public function save_report($report){

		$date = date('m/d/y H:i A');
		$timestamp = strtotime($date);
		$report_body = array(
			'subject' => $report['subject'],
			'date_filed' => $timestamp,
			'date' => $date,
			'from' => $report['from'],
			'to' => $report['to'],
			'content' =>$report['content']);

		$this->db->insert('tbl_attendance_report_detail', $report_body);

	}

	public function getReportTable(){

		$a = $this->getAllCounts(7); 	//HHL-SD
		$b = $this->getAllCounts(1);	//CCS-SD
		$n = $this->getAllCounts(1,2); 	//CCS-SD
		$c = $this->getAllCounts(12);	//TVZ-SD
		$d = $this->getAllCounts(3);	//CCS-GA -- HR
		$e = $this->getAllCounts(4);	//CCS-GA -- ACCT
		$f = $this->getAllCounts(5);    //CCS-SWAT
		$g = $this->getAllCounts(6);    //CCS-ILLUSTRATOR
		$h = $this->getAllCounts(10);   //HHL-SWAT
		$i = $this->getAllCounts(8);   	//HHL-WD
		$j = $this->getAllCounts(2);   	//CCS-WD 1
		$k = $this->getAllCounts(2,2);  //CCS-WD 2
		$l = $this->getAllCounts(9);   	//HHI-TEAM 1
		$m = $this->getAllCounts(9,2);  //HHI-TEAM 2

		/*********************CCS-GA (HR & ACCT)*******************************/
		$ga_head_combine = $d['headcount'] + $e['headcount'];
		$ga_ontime_combine = $d['ontimetotal'] + $e['ontimetotal'];
		$ga_late_combine = $d['latetotal'] + $e['latetotal'];
		$ga_awol_combine = $d['awoltotal'] + $e['awoltotal'];
		$ga_absent_combine = $d['absenttotal'] + $e['absenttotal'];
		$ga_leave_combine = $d['leavetotal'] + $e['leavetotal'];
		$ga_offset_combine = $d['offsettotal'] + $e['offsettotal'];
		$ga_restday_combine = $d['restdaytotal'] + $e['restdaytotal'];

		/***********************CCS-SD AM/PM COMBINE*******************************/
		$csd_head_combine = $b['headcount'] + $n['headcount'];
		$csd_ontime_combine = $b['ontimetotal'] + $n['ontimetotal'];
		$csd_late_combine = $b['latetotal'] + $n['latetotal'];
		$csd_awol_combine = $b['awoltotal'] + $n['awoltotal'];
		$csd_absent_combine = $b['absenttotal'] + $n['absenttotal'];
		$csd_leave_combine = $b['leavetotal'] + $n['leavetotal'];
		$csd_offset_combine = $b['offsettotal'] + $n['offsettotal'];
		$csd_restday_combine = $b['restdaytotal'] + $n['restdaytotal'];

		/******************************Total Counts per Department*******************************/
		$total_head = $a['headcount'] + $csd_head_combine + $c['headcount'] + $ga_head_combine + $f['headcount'] + $g['headcount'] + $h['headcount'] + $i['headcount'] + $j['headcount'] + $k['headcount'] + $l['headcount'] + $m['headcount'];
		$total_ontime = $a['ontimetotal'] + $csd_ontime_combine + $c['ontimetotal'] + $ga_ontime_combine + $f['ontimetotal'] + $g['ontimetotal'] + $h['ontimetotal'] + $i['ontimetotal'] + $j['ontimetotal'] + $k['ontimetotal'] + $l['ontimetotal'] + $m['ontimetotal'];
		$total_late = $a['latetotal'] + $csd_late_combine + $c['latetotal'] + $ga_late_combine + $f['latetotal'] + $g['latetotal'] + $h['latetotal'] + $i['latetotal'] + $j['latetotal'] + $k['latetotal'] + $l['latetotal'] + $m['latetotal'];
		$total_awol = $a['awoltotal'] + $csd_awol_combine + $c['awoltotal'] + $ga_awol_combine + $f['awoltotal'] + $g['awoltotal'] + $h['awoltotal'] + $i['awoltotal'] + $j['awoltotal'] + $k['awoltotal'] + $l['awoltotal'] + $m['awoltotal'];
		$total_absent = $a['absenttotal'] + $csd_absent_combine + $c['absenttotal'] + $ga_absent_combine + $f['absenttotal'] + $g['absenttotal'] + $h['absenttotal'] + $i['absenttotal'] + $j['absenttotal'] + $k['absenttotal'] + $l['absenttotal'] + $m['absenttotal'];
		$total_leave = $a['leavetotal'] + $csd_leave_combine + $c['leavetotal'] + $ga_leave_combine + $f['leavetotal'] + $g['leavetotal'] + $h['leavetotal'] + $i['leavetotal'] + $j['leavetotal'] + $k['leavetotal'] + $l['leavetotal'] + $m['leavetotal'];
		$total_offset = $a['offsettotal'] + $csd_offset_combine + $c['offsettotal'] + $ga_offset_combine + $f['offsettotal'] + $g['offsettotal'] + $h['offsettotal'] + $i['offsettotal'] + $j['offsettotal'] + $k['offsettotal'] + $l['offsettotal'] + $m['offsettotal'];
		$total_restday = $a['restdaytotal'] + $csd_restday_combine + $c['restdaytotal'] + $ga_restday_combine + $f['restdaytotal'] + $g['restdaytotal'] + $h['restdaytotal'] + $i['restdaytotal'] + $j['restdaytotal'] + $k['restdaytotal'] + $l['restdaytotal'] + $m['restdaytotal'];


		/******************************Percentage per Department*******************************/
		$ontime_percent = round(($total_ontime / $total_head) * 100);
		$late_percent = round(($total_late / $total_head) * 100);
		$awol_percent = round(($total_awol / $total_head) * 100);
		$absent_percent = round(($total_absent / $total_head) * 100);
		$leave_percent = round(($total_leave / $total_head) * 100);
		$offset_percent = round(($total_offset / $total_head) * 100);
		$restday_percent = round(($total_restday / $total_head) * 100);

		$reportTable = '<table border="1" style="text-align:center"><tr style="font-weight:bold"><td width="20%">Team</td><td width="10%">Total Head Count</td><td width="10%">Total On Time</td><td width="10%">Total Late</td><td width="10%">Total On AWOL</td><td width="10%">Total Absent</td><td width="10%">Total On Leave</td><td width="10%">Total On Off-set</td><td width="10%">Total On Restday</td></tr>';
		$reportTable .= '<tr><td>Circus-Web Design 1</td><td>'.$j['headcount'].'</td><td>'.$j['ontimetotal'].'</td><td>'.$j['latetotal'].'</td><td>'.$j['awoltotal'].'</td><td>'.$j['absenttotal'].'</td><td>'.$j['leavetotal'].'</td><td>'.$j['offsettotal'].'</td><td>'.$j['restdaytotal'].'</td></tr>';
		$reportTable .= '<tr><td>Circus-Web Design 2</td><td>'.$k['headcount'].'</td><td>'.$k['ontimetotal'].'</td><td>'.$k['latetotal'].'</td><td>'.$k['awoltotal'].'</td><td>'.$k['absenttotal'].'</td><td>'.$k['leavetotal'].'</td><td>'.$k['offsettotal'].'</td><td>'.$k['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>CCS-SD</td><td>'.$csd_head_combine.'</td><td>'.$csd_ontime_combine.'</td><td>'.$csd_late_combine.'</td><td>'.$csd_awol_combine.'</td><td>'.$csd_absent_combine.'</td><td>'.$csd_leave_combine.'</td><td>'.$csd_offset_combine.'</td><td>'.$csd_restday_combine.'</td></tr>';
	 	$reportTable .= '<tr><td>Circus-SWAT</td><td>'.$f['headcount'].'</td><td>'.$f['ontimetotal'].'</td><td>'.$f['latetotal'].'</td><td>'.$f['awoltotal'].'</td><td>'.$f['absenttotal'].'</td><td>'.$f['leavetotal'].'</td><td>'.$f['offsettotal'].'</td><td>'.$f['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>Circus-Illustrator</td><td>'.$g['headcount'].'</td><td>'.$g['ontimetotal'].'</td><td>'.$g['latetotal'].'</td><td>'.$g['awoltotal'].'</td><td>'.$g['absenttotal'].'</td><td>'.$g['leavetotal'].'</td><td>'.$g['offsettotal'].'</td><td>'.$g['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>CIRCUS-GA</td><td>'.$ga_head_combine.'</td><td>'.$ga_ontime_combine.'</td><td>'.$ga_late_combine.'</td><td>'.$ga_awol_combine.'</td><td>'.$ga_absent_combine.'</td><td>'.$ga_leave_combine.'</td><td>'.$ga_offset_combine.'</td><td>'.$ga_restday_combine.'</td></tr>';

	 	$reportTable .= '<tr><td>HalloHallo Team 1</td><td>'.$l['headcount'].'</td><td>'.$l['ontimetotal'].'</td><td>'.$l['latetotal'].'</td><td>'.$l['awoltotal'].'</td><td>'.$l['absenttotal'].'</td><td>'.$l['leavetotal'].'</td><td>'.$l['offsettotal'].'</td><td>'.$l['restdaytotal'].'</td></tr>';
		$reportTable .= '<tr><td>HalloHallo Team 2</td><td>'.$m['headcount'].'</td><td>'.$m['ontimetotal'].'</td><td>'.$m['latetotal'].'</td><td>'.$m['awoltotal'].'</td><td>'.$m['absenttotal'].'</td><td>'.$m['leavetotal'].'</td><td>'.$m['offsettotal'].'</td><td>'.$m['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>HHI-SWAT</td><td>'.$h['headcount'].'</td><td>'.$h['ontimetotal'].'</td><td>'.$h['latetotal'].'</td><td>'.$h['awoltotal'].'</td><td>'.$h['absenttotal'].'</td><td>'.$h['leavetotal'].'</td><td>'.$h['offsettotal'].'</td><td>'.$h['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>HHI-SD</td><td>'.$a['headcount'].'</td><td>'.$a['ontimetotal'].'</td><td>'.$a['latetotal'].'</td><td>'.$a['awoltotal'].'</td><td>'.$a['absenttotal'].'</td><td>'.$a['leavetotal'].'</td><td>'.$a['offsettotal'].'</td><td>'.$a['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>HHI-WD</td><td>'.$i['headcount'].'</td><td>'.$i['ontimetotal'].'</td><td>'.$i['latetotal'].'</td><td>'.$i['awoltotal'].'</td><td>'.$i['absenttotal'].'</td><td>'.$i['leavetotal'].'</td><td>'.$i['offsettotal'].'</td><td>'.$i['restdaytotal'].'</td></tr>';
	 	$reportTable .= '<tr><td>Tavolozza Team</td><td>'.$c['headcount'].'</td><td>'.$c['ontimetotal'].'</td><td>'.$c['latetotal'].'</td><td>'.$c['awoltotal'].'</td><td>'.$c['absenttotal'].'</td><td>'.$c['leavetotal'].'</td><td>'.$c['offsettotal'].'</td><td>'.$c['restdaytotal'].'</td></tr>';

	 	$reportTable .= '<tr style="font-weight:bold"><td>Total</td><td>'.$total_head.'</td><td>'.$total_ontime.'</td><td>'.$total_late.'</td><td>'.$total_awol.'</td><td>'.$total_absent.'</td><td>'.$total_leave.'</td><td>'.$total_offset.'</td><td>'.$total_restday.'</td></tr>';
	 	$reportTable .= '<tr><td>Percentage</td><td>100%</td><td>'.$ontime_percent.'%</td><td>'.$late_percent.'%</td><td>'.$awol_percent.'%</td><td>'.$absent_percent.'%</td><td>'.$leave_percent.'%</td><td>'.$offset_percent.'%</td><td>'.$restday_percent.'%</td></tr>';

	 	$reportTable .= '</table>';
		return $reportTable;

	}

	function getAllCounts($dep_id, $shift=1){
		$datenow = date('Y-m-d');
		$day = date('w', strtotime($datenow));

		if($shift == 1){
			$where = "(tbl_employee_info.shift = $shift OR tbl_employee_info.shift = 3)";
			$where1 = "(shift = $shift OR shift = 3)";
		} else {
			$where = "tbl_employee_info.shift = $shift";
			$where1 = "shift = $shift";
		}


		$result['headcount'] = $this->db->select('*')
										->from('tbl_employee_info')
										->where('department', $dep_id)
										->where($where1)
										->get()->num_rows();

		$result['latetotal'] = $this->db->select('*')
										->from('tbl_employee_info')
										->join('tbl_daily_attendance', 'tbl_daily_attendance.emp_id = tbl_employee_info.emp_id')
										->where('tbl_employee_info.department', $dep_id)
										->where("FROM_UNIXTIME(tbl_daily_attendance.date_filed,'%Y-%m-%d')", $datenow)
										->where($where)
										->where('tbl_daily_attendance.type', 'Late')
										->get()->num_rows();

		$result['awoltotal'] = $this->db->select('*')
										 ->from('tbl_employee_info')
										 ->join('tbl_daily_attendance', 'tbl_daily_attendance.emp_id = tbl_employee_info.emp_id')
										 ->where('tbl_employee_info.department', $dep_id)
										 ->where("FROM_UNIXTIME(tbl_daily_attendance.date_filed,'%Y-%m-%d')", $datenow)
										 ->where($where)
										 ->where('tbl_daily_attendance.type', 'Awol')
										 ->get()->num_rows();


		$result['absenttotal'] = $this->db->select('*')
										 ->from('tbl_employee_info')
										 ->join('tbl_daily_attendance', 'tbl_daily_attendance.emp_id = tbl_employee_info.emp_id')
										 ->where('tbl_employee_info.department', $dep_id)
										 ->where("FROM_UNIXTIME(tbl_daily_attendance.date_filed,'%Y-%m-%d')", $datenow)
										 ->where($where)
										 ->where('tbl_daily_attendance.type', 'Absent')
										 ->get()->num_rows();

		$result['leavetotal'] = $this->db->select('*')
										 ->from('tbl_employee_info')
										 ->join('tbl_leaves', 'tbl_leaves.emp_id = tbl_employee_info.emp_id')
										 ->where('tbl_employee_info.department', $dep_id)
										 ->where($where)
										 ->where('tbl_leaves.date_from', $datenow)
										 ->get()->num_rows();

		$result['offsettotal'] = $this->db->select('*')
										  ->from('tbl_employee_info')
										  ->join('tbl_changesched', 'tbl_changesched.emp_id = tbl_employee_info.emp_id')
										  ->where('tbl_employee_info.department', $dep_id)
										  ->where($where)
										  ->where('tbl_changesched.changetype', 0)
										  ->where('tbl_changesched.date_from', $datenow)
										  ->get()->num_rows();

		$result['restdaytotal'] = $this->db->select('*')
										   ->from('tbl_employee_info')
										   ->where('tbl_employee_info.department', $dep_id)
										   ->where($where)
		 								   ->where('tbl_employee_info.rest_day', $day)
		 								   ->get()->num_rows();

		$result['ontimetotal'] = $result['headcount'] - ($result['latetotal'] + $result['awoltotal'] + $result['absenttotal'] + $result['leavetotal'] + $result['offsettotal'] + $result['restdaytotal']);


		return $result;
	}
}
