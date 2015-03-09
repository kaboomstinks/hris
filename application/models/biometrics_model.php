<?php

class biometrics_model extends CI_Model {

		public function SaveGenerated($emp_code,  $remark, $type,$reason,$date_filed)
		{

			if(!empty($emp_code)){
				$getThisID = $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
				$emp_id  = $getThisID->row_array();
				
			
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
				return ($aid) ? 1 : 0;
			}	
		}

		public function SaveOffset($emp_code, $start, $end)
		{
			
			$getThisID 	= $this->db->get_where('tbl_employee_info', array('emp_code' => $emp_code, 'is_active' => 0));
			$emp_id  	= $getThisID->row_array();
			$id 		= $emp_id['emp_id'];
			
			$startdate = $this->formatdatecalendar($start);
			$enddate 	 = $this->formatdatecalendar($end);
			
			// let us delete first the temporary record if its exist since  this is just temporary no need to store lots of data;
			$this->db->delete('temp_offset', array('empid' => $id));
			$data = array(
				'empid' =>$id,
				'empC' =>$emp_code,
				'dateS' =>$startdate,
				'dateE' =>$enddate
				);
			$this->db->insert('temp_offset', $data); 
			$aid = $this->db->insert_id();
			return ($aid) ? 1 : 0;


		}

		private function  formatdatecalendar($date)
		{
			$dateformat = substr($date, 0, 10);
			$newdate = date('Y-m-d', strtotime($dateformat));
			$time = substr($date, 11,8);
			$new_time = date("H:i:s ", strtotime($time));
			return $newdate .' '. $new_time;
		}

		public function SaveOffsettoChangeSched($emp_code)
		{
			$updatedby 		= $this->session->userdata['usersession'];
			$getthisOffset 	= $this->db->get_where('temp_offset', array('empC' => $emp_code));
			$emp_offset  	= $getthisOffset->row_array();
			$time = time();
			if ($emp_offset)
			{
				$empid 		= $emp_offset['empid'];
				$emp_code 	= $emp_offset['empC'];
				$dateS		= $emp_offset['dateS'];	
				$dateE		= $emp_offset['dateE'];	
				$dateStart 	= date('Y-m-d', strtotime($dateS));
				$timeStart 	= date('H:i:s', strtotime($dateS));
				$dateEnd	= date('Y-m-d', strtotime($dateE));
				$timeEnd	= date('H:i:s', strtotime($dateE));
				$dataOffset = array('emp_id' => $empid,
							'emp_code' => $emp_code,
							'date_filed' => $time,
							'date_from' => $dateStart,
							'time_from' => $timeStart,
							'date_to' => $dateEnd,
							'time_to' => $timeEnd,
							'updated_by' =>$updatedby,
							'changetype' => 1,
							'status' => 0
					);
				$this->db->insert('tbl_changesched', $dataOffset); 
				$this->db->delete('temp_offset', array('empid' => $empid));
			}
		}
}
?>