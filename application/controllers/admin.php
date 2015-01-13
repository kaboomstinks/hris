<?php

class admin extends CI_Controller {
	public function __construct() {
        parent:: __construct();
		$this->output->nocache();
		isLoggedIn();
        $this->load->library("pagination");
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

	public function admin_attendance_cpanel(){
		if(isAdmin()){
		
			if(isset($_GET['search'])){
				$search = $_GET['search'];
			}else{
				$search = null;
			}

			if($search == ''){
				$this->session->unset_userdata('search');           // unset search key when search variable is in url and without value
			}
		
			$search = $this->input->get('search');
			$fieldname = $this->input->post('fieldname');
			$sort = $this->input->post('sort');
			$type = $this->input->post('type');
			$tab = $this->input->get('tab');
	
	 		if($type == NULL){
	 			$type = 'Late';
	 		}
			
			if (empty($tab))
	 		{
	 			$tab = @$_POST['tab'];
	 		}

	 		if (!empty($tab))
	        {
	        	if ($tab =='Late'){
	        		$type = 'Late';
	        	}elseif ($tab == 'Absent') {
	        		$type = 'Absent';
	        	}else{
	        		$type = 'Awol';	
	        	}
	        }

			$config = array();
	        $config["base_url"] = base_url() . "admin/admin_attendance_cpanel/";
	        $config["total_rows"] = $this->admin_model->AttendanceTable_record_count($type, $search);
			$config['suffix'] = '?tab='.$tab.'&search='.$search;

	        $config["per_page"] = 5;
	        $config["uri_segment"] = 3;
			$config['first_url'] = $config['base_url'].$config['suffix'];
	        $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	        $data["links"] = $this->pagination->create_links();
			$data['attendancetable'] = $this->admin_model->getAttendanceTable($config["per_page"], $page, $search, $fieldname, $sort, $type);
			$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
			$data['name'] = $this->name;
			
			if (checkIsAjax()){
				// $data['links'] = $this->pagination->create_links();
				// $this->load->view('admin/attendance_return', $data);

				$paging = $data['links'];
				$check =$this->load->view('admin/attendance_return', $data,true);
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('value'=> $check,'pagination'=>$paging)));
				
			}else{
			
				if ($tab =='Awol'){
					$data['Late'] ='';
				 	$data['Absent'] ='';
				 	$data['Awol'] ='active';

				}elseif ($tab =='Absent') {
					$data['Late'] ='';
				 	$data['Absent'] ='active';
				 	$data['Awol'] ='';

				}else{
				 	$data['Late'] ='active';
				 	$data['Absent'] ='';
				 	$data['Awol'] ='';

				}
			
				$this->load->view('common/header', $data);
				$this->load->view('admin/admin_attendance_cpanel');
				$this->load->view('common/footer');	
			}
			
		} else {
			$this->load->view('admin/accessdenied');
		}
		
		// fn_print_r($config['total_rows'], $data['links']);
		/* $this->load->view('common/header');

		$this->load->model('admin_model');
		$attend['attend_late'] = $this->admin_model->getAttendanceLate();
		$attend['attend_awol'] = $this->admin_model->getAttendanceAwol();
		$attend['attend_absent'] = $this->admin_model->getAttendanceAbsent();
		$this->load->view('admin/admin_attendance_cpanel', $attend);
		$this->load->view('common/footer'); */
	}

	public function admin_attendanceform(){
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		$data['name'] = $this->name;
		$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
		$this->load->view('common/header', $data);
		$this->load->view('admin/admin_attendanceform');
		$this->load->view('common/footer');
	}
	
	public function edit_attendance() {
		$response = $this->admin_model->editAttendanceForm();
		echo json_encode($response);
	}
	
	public function update_attendance() {
		if(checkIsAjax()) {
			$response = $this->admin_model->updateAttendanceForm();
			echo $response;
		}	
	}

	public function createattendance(){
		$this->admin_model->insertAttendanceForm();
	}

	public function update_status(){
		$post_status = $this->input->post();
		$this->admin_model->update_status($post_status);
	}
	
	public function delete_attendance() {
		if(checkIsAjax()) {
			$response = $this->admin_model->deleteAttendanceForm();
			echo $response;
		}
	}
	
	public function admin_attendance_search() {
		$this->load->view('admin/searchattendance');
	}
	
	//------------------------------------------- ADMIN LEAVE FORM --------------------------------------------//


	public function admin_changesched_cpanel(){
		if(isAdmin()){
			$search = $this->input->get('search');
			$fieldname = $this->input->post('fieldname');
			$sort = $this->input->post('sort');
			$status = $this->input->post('status');

			$tab = (!empty($_GET['tab'])) ? $_GET['tab']: "";
			
			$tab = (!empty($_POST['tab'])) ? $_POST['tab']: $tab;


			if($status == null){
				$status = 1;
			}

			if ($tab =='denied') $status =0;

			$config = array();
	        $config["base_url"] = base_url() . "admin/admin_changesched_cpanel/";
	        $config["total_rows"] = $this->admin_model->ChangeTable_record_count($status, $search);
	        $config["per_page"] = 5;
	        $config["uri_segment"] = 3;
	        $config['suffix'] = '?tab='.$tab.'&search='.$search;
			$config['first_url'] = $config['base_url'].$config['suffix'];
	        $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

	  		$this->pagination->initialize($config);
	 
	  	    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	        $data["links"] = $this->pagination->create_links();

			$data['changeschedtable'] = $this->admin_model->getChangeSchedTable($config["per_page"], $page, $search, $fieldname, $sort, $status);
			$data['name'] = $this->name;
			$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();

			if(checkIsAjax()){
				// $data['links'] = $this->pagination->create_links();
				// $this->load->view('admin/changesched_return', $data);

				$paging = $data['links'];
				$check =$this->load->view('admin/changesched_return', $data,true);
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('value'=> $check,'pagination'=>$paging)));

			}else {
				$data['denied']='';
				$data['approved']='active';
				if ($tab =='denied')
				{
					$data['denied']='active';
					$data['approved']='';
				}

				$this->load->view('common/header', $data);
				$this->load->view('admin/admin_changesched_cpanel');
				$this->load->view('common/footer');
			}
		}else {
			$this->load->view('admin/accessdenied');
		}
	}


	public function admin_leave_cpanel(){

		if(isAdmin()){

			if(isset($_GET['search'])){
				$search = $_GET['search'];
			}else{
				$search = null;
			}

			if($search == ''){
				$this->session->unset_userdata('search');           // unset search key when search variable is in url and without value
			}

			// $search = $this->admin_model->search_handler(trim($this->input->get('search')));
			$search = $this->input->get('search');
			$fieldname = $this->input->post('fieldname');
			$sort = $this->input->post('sort');
			$status = $this->input->post('status');
			$tab = $this->input->get('tab');
	 		if($status == NULL){
	 			$status = 1;
	 		}

	 		if (empty($tab))
	 		{
	 			$tab = @$_POST['tab'];
	 		}

	 		if (!empty($tab))
	        {
	        	if ($tab =='denied'){
	        		$status = 0;
	        	}elseif ($tab == 'approved') {
	        		$status = 1;
	        	}else{
	        		$status = 2;
	        	}
	      
	        }

			$config = array();
	        $config["base_url"] = base_url() . "admin/admin_leave_cpanel/";
	        $config["total_rows"] = $this->admin_model->LeaveTable_record_count($status, $search);
	        $config["per_page"] = 5;
	        $config["uri_segment"] = 3;
	        $config['suffix'] = '?tab='.$tab.'&search='.$search;
	        $config['first_url'] = $config['base_url'].$config['suffix'];
	        $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	        
	        $data["links"] = $this->pagination->create_links();
			$data['leavetable'] = $this->admin_model->getLeaveTable($config["per_page"], $page, $search, $fieldname, $sort, $status);
			$data['name'] = $this->name;
			$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
		
			if (checkIsAjax()){
				// $data['links'] = $this->pagination->create_links();
				// $this->load->view('admin/leave_return', $data);

				$paging = $data['links'];
				$check =$this->load->view('admin/leave_return', $data,true);
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('value'=> $check,'pagination'=>$paging)));
				
			}else{

				if ($tab =='denied'){
					$data['denied'] ='active';
				 	$data['pending'] ='';
				 	$data['approved'] ='';

				}elseif ($tab =='pending') {
					$data['denied'] ='';
				 	$data['pending'] ='active';
				 	$data['approved'] ='';
				}else{
				 	$data['denied'] ='';
				 	$data['pending'] ='';
				 	$data['approved'] ='active';

				}
				$this->load->view('common/header', $data);
				$this->load->view('admin/admin_leave_cpanel');
				$this->load->view('common/footer');
			}

		} else {
			$this->load->view('admin/accessdenied');
		}

		// fn_print_r($config);
	
		/*$data['leave_approved'] = $this->admin_leave_approved();
		$data['leave_denied'] = $this->admin_leave_denied();
		$data['leave_pending'] = $this->admin_leave_pending();
		$this->load->view('common/header');
		$this->load->view('admin/admin_leave_cpanel', $data);
		$this->load->view('common/footer');*/
	}

	public function admin_leave_approved(){
		$config = array();
        $config["base_url"] = base_url() . "admin/admin_leave_cpanel";
        $config["total_rows"] = $this->admin_model->getLeaveApproved_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

 
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links_approved"] = $this->pagination->create_links();

		$data['leave_approved'] = $this->admin_model->getLeaveApproved($config["per_page"], $page);

		return $data;
	}

	public function admin_leave_denied(){
		$config = array();
        $config["base_url"] = base_url() . "admin/admin_leave_cpanel";
        $config["total_rows"] = $this->admin_model->getLeaveDenied_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

 
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links_denied"] = $this->pagination->create_links();

		$data['leave_denied'] = $this->admin_model->getLeaveDenied($config["per_page"], $page);

		return $data;
	}

	public function admin_leave_pending(){
		$config = array();
        $config["base_url"] = base_url() . "admin/admin_leave_cpanel";
        $config["total_rows"] = $this->admin_model->getLeavePending_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

 
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links_pending"] = $this->pagination->create_links();

		$data['leave_pending'] = $this->admin_model->getLeavePending($config["per_page"], $page);

		return $data;
	}

	public function createleaveform(){
		$this->admin_model->insertLeaveForm();
	}

	public function admin_leaveform(){
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		$data['name'] = $this->name;
		$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
		$this->load->view('common/header', $data);
		$this->load->view('admin/admin_leaveform');
		$this->load->view('common/footer');
	}

	public function edit_leave() {
		if(checkIsAjax()){
			$response = $this->admin_model->editLeaveForm();
			echo json_encode($response);
		}	
	}

	public function update_leave() {
		if(checkIsAjax()) {
			$response = $this->admin_model->updateLeaveForm();
			echo $response;
		}
	}

	public function delete_leave() {
		if(checkIsAjax()) {
			$response = $this->admin_model->deleteLeaveForm();
			echo $response;
		}
	}

	public function admin_leave_search() {
		$this->load->view('admin/searchleave');
	}
	
	//---------------------------------------- END OF ADMIN LEAVE FORM -----------------------------------------//

	//------------------------------------ ADMIN CHANGE SCHEDULE/OFFSET FORM ------------------------------------//




	public function edit_changesched() {
		if(checkIsAjax()) {
			$response = $this->admin_model->editChangeSchedForm();
			echo json_encode($response);
		}
	}

	public function update_changesched(){
		if(checkIsAjax()) {
			$response = $this->admin_model->updateChangeSchedForm();
			echo $response;
		}
	}

	public function delete_changesched() {
		if(checkIsAjax()) {
			$response = $this->admin_model->deleteChangeSchedForm();
			echo $response;
		}
	}

	public function createchangeschedform(){
		$this->admin_model->insertChangeSchedForm();
	}

	public function admin_changeschedform(){
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		$data['name'] = $this->name;
		$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
		$this->load->view('common/header',$data);
		$this->load->view('admin/admin_changeschedform');
		$this->load->view('common/footer');

	}



	//---------------------------------------- END OF ADMIN OFFSET FORM -----------------------------------------//





	//------------------------------------ ADMIN EXPLANATION / REQUEST FORM ------------------------------------//
	public function admin_request_cpanel(){
		if(isAdmin()){
			$search = $this->input->post('search');
			$fieldname = $this->input->post('fieldname');
			$sort = $this->input->post('sort');
			$config = array();
	        $config["base_url"] = base_url() . "admin/admin_request_cpanel/";
	        $config["total_rows"] = $this->admin_model->RequestTable_record_count($search);
	        $config["per_page"] = 10;
	        $config["uri_segment"] = 3;
	        $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	        $data["links"] = $this->pagination->create_links();
			$data['requestable'] = $this->admin_model->getRequestTable($config["per_page"], $page, $search, $fieldname, $sort);
			$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
			$data['numrow'] = $config["total_rows"];
			$data['name'] = $this->name;
			if (checkIsAjax()){
				$this->load->view('admin/request_return', $data);
			}else{
				$this->load->view('common/header', $data);
				$this->load->view('admin/admin_request_cpanel');
				$this->load->view('common/footer');
			}

		} else {
			$this->load->view('admin/accessdenied');
		}

	}

	public function edit_request() {
		if(checkIsAjax()){
			$response = $this->admin_model->editRequestForm();
			echo json_encode($response);
		}
	}
	
	public function update_request() {
		if(checkIsAjax()) {
			$response = $this->admin_model->updateRequestForm();
			echo $response;
		}	
	}

	public function delete_request() {
		if(checkIsAjax()) {
			$response = $this->admin_model->deleteRequestForm();
			echo $response;
		}
	}

	public function createrequest(){
		$this->admin_model->insertRequestForm();
		//redirect('admin/admin_request_cpanel', 'refresh');	
	}

	public function admin_requestform(){
		if (checkIsAjax()){
			$action = $this->input->post('action');
			$action = key($action);
			$this->$action();
		}
		$data['name'] = $this->name;
		$data['jsonSuggestion'] = $this->admin_model->getNameSuggest();
		$this->load->view('common/header', $data);
		$this->load->view('admin/admin_requestform');
		$this->load->view('common/footer');
	}

	public function admin_request_search() {
		$this->load->view('admin/searchrequest');
	}
	//---------------------------------------- END OF ADMIN EXPLANATION / REQUEST FORM ----------------------------------------//

	

	//------------------------------------------------------- PDF FILE -------------------------------------------------------//
	public function admin_forms_reports() {
		$this->load->helper('pdf_helper');
		$id = $this->input->post('id');
		$this->load->view('PDF/employee_records.php', $id);
	}

	public function admin_employeedetails_form() {
		$this->load->helper('pdf_helper');
		$id = $this->input->post('id');
		$this->load->view('PDF/new_employee_records.php', $id);
	}

	//-------------------------------------------------------END PDF FILE -------------------------------------------------------//

	//-------------------------------------------------------Admin Cpanel----------------------------------------------------------//

	public function admin_company_cpanel(){
		if(isAdmin()){
			$data['name'] = $this->name;
			$this->load->view('common/header', $data);

			$data['companies'] = $this->admin_model->getAllCompany();
			$this->load->view('admin/admin_company_cpanel', $data);
			$this->load->view('common/footer');
		} else {
			$this->load->view('admin/accessdenied');
		}
		
	}

	public function edit_company(){
		if(checkIsAjax()){
			$data = $this->admin_model->editCompany();
			echo json_encode($data);	
		} 
	}

	public function delete_company(){
		if(checkIsAjax()){
			$response = $this->admin_model->deleteCompany();
			echo $response;	
		}
	}

	public function add_company(){
		if(checkIsAjax()){
			$response = $this->admin_model->addCompany();
			echo $response;	
		}
	}

	public function update_company(){
		if(checkIsAjax()){
			$response = $this->admin_model->updateCompany();
			echo $response;
		}
	}

	public function admin_department_cpanel(){
		if(isAdmin()){

			$config = array();
	        $config["base_url"] = base_url() . "admin/admin_department_cpanel/";
	        $config["total_rows"] = $this->admin_model->dep_count();
	        $config["per_page"] = 10;
	        $config["uri_segment"] = 3;
	        $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	        $data["links"] = $this->pagination->create_links();

			$data['name'] = $this->name;
			$this->load->view('common/header', $data);
			$data['departments'] = $this->admin_model->getAllDepartment($config["per_page"], $page);
			$data['companies'] = $this->admin_model->getAllCompanies();

			$this->load->view('admin/admin_department_cpanel', $data);
			$this->load->view('common/footer');	
		} else {
			$this->load->view('admin/accessdenied');
		}
		
	}
	
	public function edit_department(){
		if(checkIsAjax()){
			$data = $this->admin_model->editDepartment();
			echo json_encode($data);
		}
	}

	public function delete_department(){
		if(checkIsAjax()){
			$response = $this->admin_model->deleteDepartment();
			echo $response;
		}
	}

	public function add_department(){
		if(checkIsAjax()){
			$response = $this->admin_model->addDepartment();
			echo $response;
		}
	}

	public function update_department(){
		if(checkIsAjax()){
			$response = $this->admin_model->updateDepartment();
			echo $response;
		}
	}

	public function admin_attendancefile_cpanel(){
		if(isAdmin()){
			$data['name'] = $this->name;
			$this->load->view('common/header', $data);
			$this->load->view('admin/admin_attendancefile_cpanel');
			$this->load->view('common/footer');
		} else {
			$this->load->view('admin/accessdenied');
		}	
	}

	public function admin_benefit_cpanel(){
		if(isAdmin()){
			$data['name'] = $this->name;
				$this->load->view('common/header', $data);
				$data['benefits'] = $this->admin_model->getAllBenefit();
				$data['jsonSuggestion'] = $this->admin_model->getSuggest();
				$this->load->view('admin/admin_benefit_cpanel', $data);
				$this->load->view('common/footer');
		} else {
			$this->load->view('admin/accessdenied');
		}	
	}

	public function edit_benefit(){
		if(checkIsAjax()){
			$data = $this->admin_model->editBenefit();
			echo json_encode($data);
		}
	}

	public function update_benefit(){
		if(checkIsAjax()){
			$response = $this->admin_model->updateBenefit();
			echo $response;
		}
	}

	public function add_benefit(){
		if(checkIsAjax()){
			$response = $this->admin_model->addBenefit();
			echo $response;
		}
	}

	public function delete_benefit(){
		if(checkIsAjax()){
			$response = $this->admin_model->deleteBenefit();
			echo $response;
		}
	}

	function do_upload()
	{
		$this->load->helper('form');
		$config['upload_path'] = './document/';
		$config['allowed_types'] = 'txt';
		$config['max_size']	= '1000000';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload())
		{
			Echo "<script>alert('Failed Upload');</script>";
			$error = array('error' => $this->upload->display_errors());
			redirect('admin/admin_attendancefile_cpanel', 'refresh');
		}
		else
		{
			Echo "<script>alert('Uploaded');</script>";
			$data = array('upload_data' => $this->upload->data());
			redirect('admin/admin_attendancefile_cpanel', 'refresh');
		}
	}

	public function admin_view_attendance(){
		$data['name'] = $this->name;
		$this->load->view('common/header', $data);
		$this->load->view('admin/admin_view_attendance');
		$this->load->view('common/footer');
	}
	//-------------------------------------------------------End Admin Cpanel----------------------------------------------------------//

	//-------------------------------------------------------Admin Users----------------------------------------------------------//
	



	public function admin_user_cpanel(){
		
		if(isset($this->session->userdata['usersession'])){
			//$this->session->unset_userdata('search');
			if(isAdmin()){
				
				if(isset($_GET['search'])){
					$gsearch = $_GET['search'];
				}else{
					$gsearch = null;
				}

				if($gsearch == ''){
					$this->session->unset_userdata('search');           // unset search key when search variable is in url and without value
				}

				$search = $this->admin_model->search_handler(trim($this->input->get('search')));
				
				$fieldname = $this->input->post('fieldname');
				$sort = $this->input->post('sort');
				$sort = (!empty($_GET['sort'])) ? $_GET['sort'] : $sort;
				$fieldname =(!empty($_GET['fieldname'])) ? $_GET['fieldname'] : $fieldname;
				$sortby = !(empty($sort)) ? '&sort='.$sort : '';
				$fieldnameby = !(empty($fieldname)) ? '&fieldname='.$fieldname : '';

				$config = array();
		        $config["base_url"] = base_url() . "admin/admin_user_cpanel/";
		        $config["total_rows"] = $this->admin_model->UsersTable_record_count($search);
		        $config["per_page"] = 10;
		        $config["uri_segment"] = 3;
		        $config["suffix"] = '?search='.$search. $sortby . $fieldnameby;
		        $config["first_url"] = $config["base_url"].$config["suffix"];
		        $config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] ="</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";

		        $this->pagination->initialize($config);
		 
		        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		        $data["links"] = $this->pagination->create_links();
		        $data['userstable'] = $this->admin_model->getUserSearchTable($search, $config["per_page"], $page, $fieldname, $sort);
				$data["t_rows"] = $config["total_rows"];
				$data['name'] = $this->name;
				$data['companies'] = $this->admin_model->getAllCompanies();
				$data['departments'] = $this->admin_model->getAllDepartments();

				if (checkIsAjax()){

					$paging = $data['links'];
					$check = $this->load->view('admin/user_search_return', $data, true);
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('value'=> $check,'pagination'=>$paging)));
					$check = $this->load->view('admin/user_search_return', $data, true);
				}else{
					$this->load->view('common/header', $data);
					$this->load->view('admin/admin_user_cpanel', $data);
					$this->load->view('common/footer');
				}	

			} else {
				$this->load->view('admin/accessdenied');
			}
			
			
		} else {
			$this->load->view('login');
		}	
	}

	public function admin_users_search() {
		$response['htmlsearch'] = $this->admin_model->getSearch();
		echo json_encode($response);	
	}
	
	public function user(){
		$response = $this->admin_model->adduser();
		echo $response;
	}

	//-------------------------------------------------------End Admin Users----------------------------------------------------------//

	public function getFiles() {
		$this->load->view('getTextfile');
	}

	public function  sampleupload() {
		$this->load->helper('form');
		$this->load->helper(array('form', 'url'));
		$this->load->view('upload_form');
	}
}