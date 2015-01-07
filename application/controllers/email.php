<?php

/**
* SENDS EMAIL WITH GMAIL
*/
class Email extends CI_Controller
{

	public function __construct()
    {

        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        if(isset($this->session->userdata['usersession']))
		{
			$username = $this->session->userdata['usersession'];
			$this->db->select('tbl_person_info.firstname', false);
			$this->db->from('tbl_logins');
			$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_logins.emp_id');
			$this->db->where('tbl_logins.username', $username);
			$this->name = $this->db->get()->row_array();
		}
    }

    public function checkIsAjax() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			return true;
		}
		return false;
	}

	public function reporttable() {

		$data['report_table'] = $this->email_model->getReportTable(); // reporttable
		$this->load->view('PDF/reporttable_pdf.php', $data);
	}


    public function mail_form(){
		if(isAdmin()) {
	    	$user = $this->session->userdata['usersession'];
	    	$data['name'] = $this->name;
			$data['user'] = $this->email_model->get_u_details($user);
			$data['report_table'] = $this->email_model->getReportTable(); // reporttable

			$leave_data = $this->email_model->get_leave();
		
			$count = 1;
			$data['message_leave'] = '';

			foreach ($leave_data as $key => $value) {
				$sender = $leave_data[$key]["personal_email"];
				$firstname = $leave_data[$key]["firstname"];
				$lastname = $leave_data[$key]["lastname"];

				if ($leave_data[$key]["date_from"] != null || $leave_data[$key]["date_from"] != '') {
					$date_from = '(' . date("F j".", "."Y", strtotime($leave_data[$key]["date_from"])) . ' - ';
				}else{
					$date_from = '';
				}

				if ($leave_data[$key]["date_to"] != null || $leave_data[$key]["date_to"] != '') {
					$date_to = date("F j".", "."Y", strtotime($leave_data[$key]["date_to"])) . ')';
				}else{
					$date_to = '';
				}

				$data['message_leave'] .= $count . ". " . $leave_data[$key]["firstname"] .' '. $leave_data[$key]["lastname"] ." -<b> " .  $leave_data[$key]["dep_abbr"] . "</b> - " . $leave_data[$key]["type"] . " Leave" . " - " . $leave_data[$key]["reason"] . $date_from . $date_to . "<br/>";
				$count++;
			}
		

		
			$late_data = $this->email_model->get_late();

			if($late_data != ''){
				$count = 1;
				$data['message_late'] = '';

				foreach ($late_data as $key => $value) {
					$sender = $late_data[$key]["personal_email"];
					$firstname = $late_data[$key]["firstname"];
					$lastname = $late_data[$key]["lastname"];

					if ($late_data[$key]["status"] == 1) {
						$arrived = "(Arrived)";
					}elseif ($late_data[$key]["status"] == 0) {
						$arrived = "";
					}

					$data['message_late'] .= $count . ". " . $late_data[$key]["firstname"] .' '. $late_data[$key]["lastname"] ." -<b> " .  $late_data[$key]["dep_abbr"] . "</b> - " . $late_data[$key]["reason"] . ' ' . $arrived . "<br/>";
					$count++;

				}	
			}
			

			$late_no_notif_data = $this->email_model->get_late_no_notif();
			

			if($late_no_notif_data != ''){
				$count = 1;
				$data['message_no_notif_late'] = '';

				foreach ($late_no_notif_data as $key => $value) {
					$sender = $late_no_notif_data[$key]["personal_email"];
					$firstname = $late_no_notif_data[$key]["firstname"];
					$lastname = $late_no_notif_data[$key]["lastname"];

					if ($late_no_notif_data[$key]["status"] == 1) {
						$arrived = "(Arrived)";
					}elseif ($late_no_notif_data[$key]["status"] == 0) {
						$arrived = "";
					}

					$data['message_no_notif_late'] .= $count . ". " . $late_no_notif_data[$key]["firstname"] .' '. $late_no_notif_data[$key]["lastname"] ." -<b> " .  $late_no_notif_data[$key]["dep_abbr"] . '</b> - ' . 'no notification sent to GA HR ' . $arrived . "<br/>";
					$count++;
				}	
			}
		

			$absent_data = $this->email_model->get_absent();

			if($absent_data != ''){
				$count = 1;
				$data['message_absent'] = '';

				foreach ($absent_data as $key => $value) {
					$sender = $absent_data[$key]["personal_email"];
					$firstname = $absent_data[$key]["firstname"];
					$lastname = $absent_data[$key]["lastname"];

					$data['message_absent'] .= $count . ". " . $absent_data[$key]["firstname"] .' '. $absent_data[$key]["lastname"] ." -<b> " .  $absent_data[$key]["dep_abbr"] . "</b> - " . $absent_data[$key]["reason"] . "<br/>";
					$count++;
				}
			}
		

			$awol_data = $this->email_model->get_awol();
			
			if($awol_data != ''){
				$count = 1;
				$data['message_awol'] = '';

				foreach ($awol_data as $key => $value) {
					$sender = $awol_data[$key]["personal_email"];
					$firstname = $awol_data[$key]["firstname"];
					$lastname = $awol_data[$key]["lastname"];

					$data['message_awol'] .= $count . ". " . $awol_data[$key]["firstname"] .' '. $awol_data[$key]["lastname"] ." -<b> " .  $awol_data[$key]["dep_abbr"] . "</b><br/>";
					$count++;

				}
			}
		
		
			if($late_data == '' || $late_no_notif_data == '' || $absent_data == '' || $awol_data == ''){
					$this->load->view('admin/mail_report_404');
			} else {
					$this->load->view('common/header', $data);
					$this->load->view('mail/mail_form.php', $data);
			}

		} else {
			$this->load->view('admin/accessdenied');
		}

    }

	function sendmail(){
		$user = $this->session->userdata['usersession'];
		$id = $this->email_model->get_u_details($user);
		$m_details = $this->input->post();

		$report['subject'] = $m_details['subj'];
		$report['from'] = $id['personal_email'].', '. $id['firstname'].' '.$id['lastname'];
		$report['to'] = $m_details['to'];
		$report['content'] = $m_details['data'];
		$report['date_filed'] = date("F j".", "."Y "."("."h:i:s A".")");

		$this->email_model->save_report($report);

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.circus.ac';
		$config['smtp_port'] = 25;
		$config['mailtype'] = 'html';

		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$this->email->from($id['personal_email'], $id['firstname'].' '.$id['lastname']);
		$this->email->to($m_details['to']);
		$this->email->subject($m_details['subj']);
		$this->email->message($m_details['data']);


		//===============For attaching files==========================//

		// $this->load->helper('path');

		// $path = set_realpath('pdf_report/');
		// $this->email->attach($path.'reports.pdf');


		if($this->email->send()) {
			echo '{"success":1}';
		}else {
			show_error($this->email->print_debugger());
			echo '{"success":0}';
		}
	}
}
