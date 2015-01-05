<?php

class Hr extends CI_Controller {

	public function checkIsAjax() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			return true;
		} 
		
		return false;
	}
	
	public function admin_leave_cpanel(){
		$this->load->view('common/header');
		$this->load->view('admin_leave_cpanel');
		$this->load->view('common/footer');
	}
	
	public function admin_leaveform(){
		$this->load->view('common/header');
		$this->load->view('admin_leaveform');
		$this->load->view('common/footer');
	}
	
	
	public function admin_user_edit(){
		//var_dump($this->session->all_userdata());
		
		if(isset($this->session->userdata['usersession'])){
			$this->load->model('hr_model');
			$data['userstable'] = $this->hr_model->getUsersTable();
			
			$this->load->view('common/header');
			$this->load->view('admin_user_cpanel', $data);
			$this->load->view('common/footer');
		} else {
			$this->load->view('login');
		}
		
	}

	public function admin_user_request(){
		
		$this->load->model('hr_model');
		$data['requestable'] = $this->hr_model->getRequestTable();
		
		$this->load->view('common/header');
		$this->load->view('admin_user_requestform', $data);
		$this->load->view('common/footer');
	}

	public function index(){
		
		//var_dump($this->session->all_userdata());
		
		$this->load->model('hr_model');
		$this->load->view('common/header.php');
		if(isset($this->session->userdata['usersession'])){
		
			$data['usersession'] = $this->session->userdata['usersession'];
			
			if($this->session->userdata['credential'] == 1) {
				//$this->load->view('header.php');
				$this->load->view('adminview', $data);
				
			} else {
				$this->load->view('employee_home', $data);
				$this->load->view('header_front.php');
			} 
				
		} else {
			$this->load->view('login');
		}
		
		$this->load->view('common/footer.php');
	}
	

	public function in(){
	
		if($this->checkIsAjax()){
			
			$this->load->model('hr_model');
			$response = $this->hr_model->login();
			
			if($response) {
				$data['success'] = 1;
			} else {
				$data['success'] = 0;
			}
			
			echo json_encode($data);
		}
		
	}
	
	public function out(){
		$this->load->model('hr_model');
		$this->hr_model->logout();
	}
	
	public function employeeview($name=null){
		$this->load->view('header_front.php');

		$this->load->model('hr_model');

		$data['usersession'] = $this->session->userdata['usersession'];

		$emp_details = $this->hr_model->get_emp_detail($data);
		foreach ($emp_details['emp_data'] as $key1 => $details) {
			$data[$key1] = $details;
		}
		foreach ($emp_details['emp_req'] as $key2 => $details) {
			$data[$key2] = $details;
		}
		foreach ($emp_details['emp_benef'] as $key3 => $details) {
			$data[$key3] = $details;
		}
		foreach ($emp_details['emp_ei'] as $key4 => $details) {
			$data[$key4] = $details;
		}
		$this->load->view('employeeview', $data);

		$this->load->view('footer.php');
	}

	public function employee_edit($name=null){

		$this->load->view('common/header');

		$this->load->model('hr_model');

		
		if($this->session->userdata['credential'] == 0) {
			$data['usersession'] = $this->session->userdata['usersession'];
		} else {
			$data['usersession'] = $this->input->get('username');
		}
		
		$emp_details = $this->hr_model->get_emp_detail($data);
				foreach ($emp_details['emp_data'] as $key1 => $details) {
					$data[$key1] = $details;
				}
				foreach ($emp_details['emp_req'] as $key2 => $details) {
					$data[$key2] = $details;
				}
				foreach ($emp_details['emp_benef'] as $key3 => $details) {
					$data[$key3] = $details;
				}
				foreach ($emp_details['emp_ei'] as $key4 => $details) {
					$data[$key4] = $details;
				}
				foreach ($emp_details['user'] as $key4 => $details) {
					$data[$key4] = $details;
				}
		$this->load->view('employee_edit.php', $data);
		
		$this->load->view('common/footer.php');
	}

	public function employee_account_confirm(){
		$post_data = $this->input->post();
		$this->load->view('header_front.php');
		
		$this->load->view('account_confirm.php', $post_data);
		
		$this->load->view('footer.php');
	}

	public function emp_save(){

		$this->load->model('hr_model');

		if($this->checkIsAjax()){
			
			$post_data = $this->input->post();
			$username = $this->session->userdata['usersession'];
			
			if (!empty($post_data)) {
				$this->hr_model->save_emp($post_data, $username);
			}
		}
	}

	public function employee_forms_reports() {
		$this->load->helper('pdf_helper');
		$id = $this->input->post('id');
		Echo "<script>function window.open('http://www.w3schools.com'); </script>";
		$this->load->view('PDF/employee_records.php', $id);
	}
}