<?php

class employee extends CI_Controller {	
	
	public function __construct(){
		parent::__construct();
		$this->output->nocache();
		isLoggedIn();
		$this->load->model('employee_model');
		$this->load->model('admin_model');
		if(isset($this->session->userdata['usersession']))
		{
			$username = $this->session->userdata['usersession'];
			$this->db->select('tbl_person_info.firstname', false);
			$this->db->from('tbl_logins');
			$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_logins.emp_id');
			$this->db->where('tbl_logins.username', $username);
			$this->name = $this->db->get()->row_array();
		}
		date_default_timezone_set('Asia/Manila');
	}

	public function employeeview($name=null){

		$data['name'] = $this->name;
	
		$this->load->view('employee/header_front.php', $data);

		$this->load->model('employee_model');

		$data['usersession'] = $this->session->userdata['usersession'];

		$emp_details = $this->employee_model->get_emp_detail($data);
		foreach ($emp_details['emp_pi'] as $key1 => $details) {
			$data[$key1] = $details;
		}
		foreach ($emp_details['emp_ei'] as $key2 => $details) {
			$data[$key2] = $details;
		}
		foreach ($emp_details['emp_emerg'] as $key3 => $details) {
			$data[$key3] = $details;
		}
		// foreach ($emp_details['emp_ei'] as $key4 => $details) {
		// 	$data[$key4] = $details;
		// }
		$this->load->view('employee/employeeview', $data);

		$this->load->view('common/footer.php');
	}

	public function employee_edit($name=null){
	
		$this->load->model('employee_model');
		$data['name'] = $this->name;
		
		if($this->session->userdata['credential'] == 2) {
			$data['usersession'] = $this->session->userdata['usersession'];
			$this->load->view('employee/header_front.php', $data);
		} else if($this->session->userdata['credential'] == 1){
			$data['usersession'] = $this->input->get('username');
			$this->load->view('common/header', $data);
		}

		$data['companies'] = $this->admin_model->getAllCompanies();
		$data['departments'] = $this->admin_model->getAllDepartments();
		
		//$data['departments'] = $this->employee_model->get_dep();
		
		
		$emp_details = $this->employee_model->get_emp_detail($data);
		foreach ($emp_details['emp_pi'] as $key1 => $details) {
			$data[$key1] = $details;
		}
		foreach ($emp_details['emp_ei'] as $key2 => $details) {
			$data[$key2] = $details;
		}
		foreach ($emp_details['emp_emerg'] as $key3 => $details) {
			$data[$key3] = $details;
		}
		foreach ($emp_details['user'] as $key3 => $details) {
			$data[$key3] = $details;
		}
		$this->load->view('employee/employee_edit.php', $data);
		
		$this->load->view('common/footer.php');
	}

	public function employee_account_confirm(){
		
		$post_data = $this->input->post();
		$data['name'] = $this->name;

		$sourcePath = $_FILES['profile_picture']['tmp_name'];        
		$targetPath = "uploads/".$_FILES['profile_picture']['name']; 
		move_uploaded_file($sourcePath,$targetPath);
		$post_data['companies'] = $this->admin_model->getAllCompanies();
		$post_data['departments'] = $this->admin_model->getAllDepartments();
		
		if(isAdmin()){
			$this->load->view('common/header.php', $data);	
		} else {
			$this->load->view('employee/header_front.php', $data);
		}

		$this->load->view('employee/account_confirm.php', $post_data);
		$this->load->view('common/footer.php');	
	}
	
	public function employee_create_leave(){
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		
		$this->load->view('employee/header_front');
		$this->load->view('employee/employee_create_leave');
		$this->load->view('common/footer');
	}
	
	public function create_leave(){
	$response = $this->employee_model->insertLeave();

		if($response){
			echo "<script>alert('Leave request successful');</script>";
		} else {
			echo "<script>alert('Leave request failed');</script>";
		}
	}
	
	

	public function emp_save(){

		$this->load->model('employee_model');

		if(checkIsAjax()){
			
			$post_data = $this->input->post();
			
			if($this->session->userdata['credential'] == 2) {
				$username = $this->session->userdata['usersession'];
			} else {
				$username= $post_data['emp_ei']['emp_code'];
			}
			
			if (!empty($post_data)) {
				$this->employee_model->save_emp($post_data, $username);
			}
		}
	}

	public function create_request() {
		$this->employee_model->insertRequest();
	}

	public function employee_create_request() {
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		$data['usersession'] = $this->session->userdata['usersession'];
		$this->load->model('employee_model');
		$this->load->view('employee/header_front');
		$this->load->view('employee/employee_create_request', $data);
		$this->load->view('common/footer');
	}

	// start of newshift functions
	
	public function manage_shift(){
		$response['shifttable'] = $this->employee_model->getAllShift();
		echo json_encode($response);
	}

	public function add_newshift(){
		$response = $this->employee_model->addNewShift();
		echo json_encode($response);
	}

	public function fetch_newshift(){
		$response = $this->employee_model->getNewShiftRecord();
		echo json_encode($response);
	}

	public function update_newshift(){
		$response = $this->employee_model->updateNewShift();
		echo json_encode($response);
	}

	public function delete_newshift(){
		$response = $this->employee_model->deleteNewShift();
		echo json_encode($response);
	}

	// start of changesched functions

	public function manage_changesched(){
		$response['changeschedtable'] = $this->employee_model->getAllChangesched();
		echo json_encode($response);	
	}
	
	public function add_newchangesched(){
		$response = $this->employee_model->addNewChangeSched();
		echo json_encode($response);
	}
	
	public function fetch_newchangesched(){
		$response = $this->employee_model->getNewChangeSchedRecord();
		echo json_encode($response);
	}
	
	public function update_newchangesched(){
		$response = $this->employee_model->updateNewChangeSched();
		echo json_encode($response);
	}
	
	public function delete_newchangesched(){
		$response = $this->employee_model->deleteNewChangeSched();
		echo json_encode($response);
	}

}