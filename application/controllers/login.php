<?php

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->output->nocache();
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

	public function index(){
		
		$this->load->model('login_model');

		if (isset($this->name)) {
			$data['name'] = $this->name;
		}else{
			$data['name'] = null;
		}
		
		if(isset($this->session->userdata['usersession'])){
		
			$data['usersession'] = $this->session->userdata['usersession'];
			
			if($this->session->userdata['credential'] == 1) {
				$this->load->view('common/header.php', $data);
				$this->load->view('admin/adminview', $data);
				$this->load->view('common/footer.php');
			} else if($this->session->userdata['credential'] == 2) {
				$this->load->view('employee/employee_home', $data);
				$this->load->view('employee/header_front.php', $data);
				$this->load->view('common/footer.php');
			} 
				
		} else {
			$this->load->view('common/header.php', $data);
			$this->load->view('login');
			$this->load->view('common/footer.php');
		}
		
	}

	public function log_in(){
	
		if($this->checkIsAjax()){
			
			$this->load->model('login_model');
			$response = $this->login_model->login();
			
			if($response) {
				$data['success'] = 1;
			} else {
				$data['success'] = 0;
			}
			
			echo json_encode($data);
		}
		
	}
	
	public function log_out(){
		$this->load->model('login_model');
		$this->login_model->logout();
	}



}