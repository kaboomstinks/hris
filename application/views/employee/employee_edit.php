<style>
::-webkit-input-placeholder { /* WebKit browsers */
	 font-style: italic;
     color: GrayText !important;
}

::-webkit-input-placeholder{
opacity:0.4
}

:-moz-placeholder {
opacity:0.4
}

::-moz-placeholder { 
opacity:0.4 
}

:-ms-input-placeholder {  
opacity:0.4
}
textarea{ 
  width: 215px; 
  min-width:215px; 
  max-width:215px; 

}

</style>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" style="margin-top:50px;">
        <div class="panel-heading"><strong>Edit Details</strong></div>
	        <form action="employee_account_confirm" method="post" id="emp_edit_form" enctype="multipart/form-data" runat="server">
	            <div class="panel-body clearfix">
		    		<div class="col-md-6">
		        		<div class="page-header">
		            		<h3>Personal information</h3>
		       			</div>
		        		<table class="table table-striped table-hover">
		                    <tr>
		                        <th>Firstname <span style="color:red">※</span></th>
		                        <td>
		                        	<input id="session_credential" type="hidden" value="<?php echo $this->session->userdata['credential']; ?>">
		                        	<input value="<?php echo $firstname; ?>" type="text" class="form-control" name="emp_pi[firstname]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Middlename <span style="color:red">※</span></th>
		                        <td>
		                        	<input value="<?php echo $middlename; ?>" type="text" class="form-control" name="emp_pi[middlename]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Lastname <span style="color:red">※</span></th>
		                        <td>
		                        	<input value="<?php echo $lastname; ?>" type="text" class="form-control" name="emp_pi[lastname]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Nickname <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="text" value="<?php echo $nickname; ?>" class="form-control" name="emp_pi[nickname]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Street Address</th>
		                        <td>
		                        	<input type="text" value="<?php echo $street_address; ?>" class="form-control" name="emp_pi[street_address]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>City</th>
		                        <td>
		                        	<input type="text" value="<?php echo $city; ?>" class="form-control" name="emp_pi[city]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Province</th>
		                        <td>
		                        	<input type="text" value="<?php echo $province; ?>" class="form-control" name="emp_pi[province]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Country</th>
		                        <td>
		                        	<input type="text" value="<?php echo $country; ?>" class="form-control" name="emp_pi[country]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Zipcode</th>
		                        <td>
		                        	<input type="text" value="<?php  echo (empty($zipcode) ? '' : $zipcode);?>" class="form-control" name="emp_pi[zipcode]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Personal E-mail <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="email" value="<?php echo $personal_email; ?>" class="form-control" name="emp_pi[personal_email]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Home Phone</th>
		                        <td>
		                        	<input type="tel" value="<?php echo $home_phone; ?>" class="form-control" name="emp_pi[home_phone]">
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Mobile Phone <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="tel" value="<?php echo $mobile_phone; ?>" class="form-control" name="emp_pi[mobile_phone]" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Date of Birth</th>
		                        <td>
									<input type="text" name="emp_pi[date_of_birth]" class="form-control datepicker " data-date-format="MM/DD/YYYY" value="<?php echo $date_of_birth; ?>" placeholder="MM/DD/YYYY"/>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Place of Birth</th>
		                        <td>
		                        	<input type="text" value="<?php echo $place_of_birth; ?>" class="form-control" name="emp_pi[place_of_birth]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Gender</th>
		                        <td>
		                        	<input type="hidden" value="<?php echo $gender; ?>" class="form-control" name="emp_pi[gender]" />
		                        	<input id="male" type="radio" name="gender" value="1" checked="checked" />Male&nbsp;&nbsp;<input id="female" type="radio" name="gender" value="0" />Female
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Civil Status</th>
		                        <td>
		                        	<input type="text" value="<?php echo $civil_status; ?>" class="form-control" name="emp_pi[civil_status]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Tax Identification No.</th>
		                        <td>
		                        	<input type="text" value="<?php echo $tax_tin; ?>" class="form-control" name="emp_pi[tax_tin]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Social Security System No.</th>
		                        <td>
		                        	<input type="text" value="<?php echo $sss; ?>" class="form-control" name="emp_pi[sss]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>PhilHealth No.</th>
		                        <td>
		                        	<input type="text" value="<?php echo $philhealth; ?>" class="form-control" name="emp_pi[philhealth]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Home Development Mutual Fund(Pagibig) No.</th>
		                        <td>
		                        	<input type="text" value="<?php echo $pagibig; ?>" class="form-control" name="emp_pi[pagibig]" />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Password <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="password" value="" id="pass" class="form-control" style="font-style:italic" name="user[password]" placeholder="Password" required>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Password Confirmation <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="password" value="" id="cpass" class="form-control" style="font-style:italic" name="user[password2]" placeholder="Confirm" required>
		                        </td>
		                    </tr>
		                </table>
		            </div>
		            <div class="col-md-6">
		                <div class="page-header">
		                	<table>
		                		<tr>
		                			<td>
		                				<?php if(empty($person_pic)){ ?>
										<img id="imagepreview" class="img-circle" src="<?php echo base_url(); ?>uploads/no_image_available.png" width="192" height="192" />
										<?php } else {?>
										<img id="imagepreview" class="img-circle" src="<?php echo base_url(); ?>uploads/<?php echo $person_pic; ?>" width="192" height="192" />
										<?php } ?>
		                			</td>
		                			<td>
		                			<br /><br /><br /><br /><br /><br /><br />
		                				<input type="file" id="imageupload" onchange="readURL(this);" name="profile_picture"/>
		                				<input type="hidden" id="imagename" name="emp_pi[profile_picture]" value="<?php echo $person_pic; ?>">
		                			</td>
		                		</tr>
		                	</table>
		        			<h3>Employee Information</h3>
		        		</div>
		                <table class="table table-striped table-hover">
		                    <tr>
		                        <th>Employee Code</th>
		                          <td>
		                          		<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>" />
		                        		<input type="text" value="<?php echo $emp_code; ?>" class="form-control emp_info " name="emp_ei[emp_code]" style="width:100px" id="texEnable" disabled>
		                        		<input type="hidden" value="<?php echo $emp_code; ?>" class="form-control emp_info " name="emp_ei[emp_code]" style="width:100px" id="texEnable">
								<!--	<button class="btn btn-default"style="position:relative; top:-34px; right:-108px"  type="button" id="disablebutton" onclick="(texEnable.disabled) ?texEnable.disabled=false : texEnable.disabled=true">EDIT</button>-->
									<a id="alertuid" style="position:relative; top:-28px; right:-111px" class="glyphicon glyphicon-info-sign"  data-content="Your Default Username is your Employee Code"  data-placement="top" data-original-title="Note" data-trigger="hover"></a>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Company</th>
		                        <td>
		                        	<input type="hidden" value="<?php echo (empty($company)? '' : $company); ?>" class="form-control emp_info" name="emp_ei[company]" readonly />
		                        	<div class="form-group">
			                        	<!-- <select class="form-control company" name="s_company" disabled>
			                        		<option value="1">Circus Co. Ltd (Philippine Branch)</option>
			                        		<option value="2">Tavolozza</option>
			                        		<option value="3">HalloHallo Inc.</option>
			                        	</select> -->
			                        	
			                        	<select class="form-control company" name="s_company" disabled>
											
											<?php if(!empty($companies)) {
												foreach ($companies as $key => $c) { ?>
													<option value="<?php echo $c['id']?>"><?php echo $c['company_name']; ?></option>

											<?php } }?>
			        
			        					</select>
			                        </div>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Department</th> 
		                        <td>
		                        	<input type="hidden" value="<?php echo (empty($department)? '' : $department); ?>" class="form-control emp_info" name="emp_ei[department]">
		                        	<div class="form-group">
			                        	<select class="form-control department" name="s_department" disabled>
	        								<?php if (!empty($departments)){
	        	
	        									foreach ($departments as $key => $d) {
	        										$department_name = $d['dep_name']; 
	        										$dep_id = $d['id'];
	        										$c_id = $d['company_id'];

													echo "<option class=$c_id value=$dep_id>$department_name</option>";
	        									}
	        								} ?>
        								</select>
			                        </div>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Position</th>
		                        <td>
		                        	<input type="text" value="<?php echo (empty($position)?'' : $position); ?>" class="form-control emp_info" name="emp_ei[position]" readonly>	
		                        </td>
		                    </tr>
		                     <tr>
		                        <th>Schedule</th>
		                        <td>
		                        	<input name="emp_ei[shift]" type="hidden" value="<?php echo (empty($shift)? '' :$shift); ?>" />
		                        	<input id="amshift" type="radio" name="shift" value="1" checked="checked" />AM&nbsp;&nbsp;
        							<input id="midshift" type="radio" name="shift" value="3" />Mid&nbsp;&nbsp;
        							<input id="pmshift" type="radio" name="shift" value="2" />PM&nbsp;&nbsp;&nbsp;&nbsp;
        							
		                        </td>
		                    </tr> 
							<tr>
		                        <th>Shift Manage</th>
		                        <td>
									<button type="button" class="btn btn-default" id="manage_shift" disabled>Manage</button>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Change Schedule</th>
		                        <td>
        							<button type="button" class="btn btn-default" id="manage_changesched" disabled>Manage</button>
		                        </td>
		                    </tr>
		                     <tr>
		                        <th>Rest Day</th>
		                        <td>
		                        <input type="hidden" value="<?php echo $rest_day; ?>" class="form-control emp_info" name="emp_ei[rest_day]">
		                        	<select name="s_restday" class="form-control restday" disabled>
		                        		<option value="0">Sunday</option>
		                        		<option value="1">Monday</option>
		                        		<option value="2">Tuesday</option>
		                        		<option value="3">Wednesday</option>
		                        		<option value="4">Thursday</option>
		                        		<option value="5">Friday</option>
		                        		<option value="6">Saturday</option>
		                        	</select>		
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Employment Status</th>
		                        <td>
		                        	<input type="text" value="<?php echo (empty($emp_status)?'':$emp_status); ?>" class="form-control emp_info" name="emp_ei[emp_status]" readonly>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Date Hired</th>
		                        <td>
		                        	<input type="text" value="<?php echo (empty($date_hired)?'':$date_hired); ?>" class="form-control emp_info datepicker" name="emp_ei[date_hired]" data-date-format="MM/DD/YYYY" placeholder="MM/DD/YYYY" readonly>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Date of Regularization</th>
		                        <td>
		                        	<input type="text" value="<?php echo (empty($date_regularization)?'':$date_regularization); ?>" class="form-control emp_info datepicker" name="emp_ei[date_regularization]" data-date-format="MM/DD/YYYY" placeholder="MM/DD/YYYY" readonly>
		                        </td>
		                    </tr>
		                    <?php 
		                    if (isAdmin()) { ?>
			                    <tr>
			                        <th>Deactivate</th>
			                        <td>
			                        	<input type="checkbox" value="<?php echo (empty($is_active)?'':$is_active); ?>" id="is_active" name="emp_ei[is_active]" >&nbsp;&nbsp;
			                        	<span style="font-size: 12px;">This will <span style="color: red;"><u>PERMANENTLY</u></span> deactivate this user</span>
			                        </td>
			                    </tr>
		                    <?php } ?>
		                    
		                </table>
		                <div class="page-header">
		                	<h3>Emergency Details</h3>
		                </div>
		                <table class="table table-striped table-hover">
		                    <tr>
		                        <th>In case of emergency notify: <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="text" value="<?php if(isset($efirstname)){echo $efirstname;} ?>" class="form-control" name="emp_emerg[efirstname]" placeholder="First Name" required/>
		                        	<input type="text" value="<?php if(isset($emiddlename)){echo $emiddlename;} ?>" class="form-control"  name="emp_emerg[emiddlename]" placeholder="Middle Name" required/>
		                        	<input type="text" value="<?php if(isset($elastname)){echo $elastname;} ?>" class="form-control"  name="emp_emerg[elastname]" placeholder="Last Name" required/>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Relationship <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="text" value="<?php if(isset($relationship)){echo $relationship;} ?>" class="form-control" name="emp_emerg[relationship]" required />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Person to notify Home Phone <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="tel" value="<?php if(isset($ehome_phone)){echo $ehome_phone;} ?>" class="form-control" name="emp_emerg[ehome_phone]" required />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Person to notify Mobile Phone <span style="color:red">※</span></th>
		                        <td>
		                        	<input type="tel" value="<?php if(isset($emobile_phone)){echo $emobile_phone;} ?>" class="form-control" name="emp_emerg[emobile_phone]" required />
		                        </td>
		                    </tr>
		                    </tbody>
		                </table>
		            </div>
	            </div>
	            
	            <div class=" panel-footer">
	            	<p class=" text-center">
	            		<?php if ($this->session->userdata['credential'] == '1') { ?>
	            			<button id="cancel" type="button" class="btn btn-warning btn-lg">Cancel</button>&nbsp;
	            		<?php }else if ($this->session->userdata['credential'] == '2') { ?>
	            			<button type="button" class="btn btn-warning btn-lg" onclick="history.back()">Cancel</button>&nbsp;
	            		<?php } ?>

	            		<input type="submit" class="btn btn-danger btn-lg" id="emp_edit" value="Submit"/>
	            	</p>
	            </div>
	        </form>
	    </div>
    </div>


    <!--*******************Shift Manage Modal******************************-->
    <div class="modal fade" id="shifts_modal">
	  <div class="modal-dialog" style="width:450px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">User Shifts: <?php echo $emp_code; ?></h3>
		  </div>
		  <div class="modal-body">
		  	<table id="shift_table" class="table table-striped">
				<thead>
					<tr style="font-weight:bold">
						<td>ID</td>
						<td>Effective Date</td>
						<td>Start</td>
						<td align="center">Actions</td>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		  </div>
		   <div class="modal-footer">
		   		<button type="button" class="btn btn-primary" id="add_newshift">Add</button>
		   </div>
		</div>
	  </div>
	 </div>

	 <!--*******************Add and Edit New Shift Modal******************************-->
	  <div class="modal fade" id="addshift_modal">
	  <div class="modal-dialog" style="width:290px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">New Shift</h3>
			<input type="hidden" name="errorVal" value="0">
		  </div>
		  <div class="modal-body">
		 	  <form id="addnewshift_form">
			  	<input type="hidden" name="savemode" value="" />
			  	<input type="hidden" name="recID" value="" />
				New Shift:&nbsp;&nbsp;<input id="new_amshift" type="radio" name="newshift" value="1" checked="checked" />AM&nbsp;&nbsp;
				<input id="new_midshift" type="radio" name="newshift" value="3" />Mid&nbsp;&nbsp;
				<input id="new_pmshift" type="radio" name="newshift" value="2" />PM <br /><br />
				<input style="width:250px" type="text" name="effective_date" class="form-control" placeholder="Effectivity Date" /><br />
				<textarea rows="4" style="width:250px" type="text" name="shift_remarks" class="form-control" placeholder="Remarks"></textarea>
			  </form>
		   </div>
		   <div class="modal-footer">
		   		<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="newshiftsave">Save</button>
		   </div>
		</div>
	  </div>
	 </div>

	 <!--*******************Changesched Manage Modal******************************-->
	<div class="modal fade" id="changesched_modal">
		<div class="modal-dialog" style="width:500px">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" style="font-weight:bold">User Change Schedule</h3>
			  </div>
			  <div class="modal-body">
				<table id="changesched_table" class="table table-striped">
					<thead>
						<tr style="font-weight:bold">
							<td>Start Date</td>
							<td>End Date</td>
							<td>Status</td>
							<td align="center">Actions</td>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			  </div>
			   <div class="modal-footer">
					<button type="button" class="btn btn-primary" id="add_changesched">Add</button>
			   </div>
			</div>
		</div>
	</div>
	
	 <!--*******************Add and Edit New Change Sched Modal******************************-->
	
	 <div class="modal fade" id="addchangesched_modal">
	  <div class="modal-dialog" style="width:500px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">User Change of Schedule</h3>
			<input type="hidden" name="errorVal1" value="0">
		  </div>
		  <div class="modal-body">
		 	  <form id="addnewchangesched_form">
				<input type="hidden" name="savemode1" value="" />
			  	<input type="hidden" name="recID1" value="" />
			  
				<table border="0" align="center" width="80%">
					<tr>
						<td>Date Filed:</td>
						<td><input class="form-control" type="text" name="datefiled" /></td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td>Beginning New Schedule:</td>
						<td><input class="form-control" type="text" name="beginsched" /></td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td>Ending New Schedule:</td>
						<td><input class="form-control" type="text" name="endsched" /></td>
					</tr><td><br /></td></tr>
					<tr>
						<td>Total of hours:</td>
						<td><input class="form-control" type="text" name="totalhours" readonly /></td>
					</tr></tr><td><br /></td></tr>
					<tr>
						<td>Description:</td>
						<td><textarea rows="4" type="text" name="remarks" class="form-control"></textarea></td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td></td>
						<td><input type="radio" value="1" name="changetype" id="changesched" checked /> Change of Schedule<br />
						<input type="radio" value="0" name="changetype" id="offset" /> Offset to restday</td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td></td>
						<td>
							<input id="approved" type="radio" name="emp_approval" value="1" checked /> Approved <br />
							<input id="denied" type="radio" name="emp_approval" value="0" /> Denied <br />
						</td>
					</tr>
					
				</table>
			  </form>
		   </div>
		   <div class="modal-footer">
		   		<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="newchangeschedsave">Save</button>
		   </div>
		</div>
	  </div>
	 </div>




</div>



<script>
	$(document).ready(function(){
	
		var i_dep = $("input[name='emp_ei[department]']");
		var i_company = $("input[name='emp_ei[company]']");
		var i_restday = $("input[name='emp_ei[rest_day]']");
		var s_department = $('select[name=s_department]');
		var s_company = $('select[name=s_company]');
		var s_restday = $('select[name=s_restday]');
		var credential = $('#session_credential').val();
		var firstname = $("input[name='emp_pi[firstname]']");
		var middlename = $("input[name='emp_pi[middlename]']");
		var lastname = $("input[name='emp_pi[lastname]']");
		var nickname = $("input[name='emp_pi[nickname]']");
		var street_address = $("input[name='emp_pi[street_address]']");
		var city = $("input[name='emp_pi[city]']");	
		var province = $("input[name='emp_pi[province]']");	
		var country = $("input[name='emp_pi[country]']");
		var zipcode = $("input[name='emp_pi[zipcode]']");		
		var personal_email = $("input[name='emp_pi[personal_email]']");	
		var home_phone = $("input[name='emp_pi[home_phone]']");		
		var mobile_phone = $("input[name='emp_pi[mobile_phone]']");		
		var date_of_birth = $("input[name='emp_pi[date_of_birth]']");
		var place_of_birth = $("input[name='emp_pi[place_of_birth]']");	
		var tax_tin = $("input[name='emp_pi[tax_tin]']");		
		var sss = $("input[name='emp_pi[sss]']");	
		var philhealth = $("input[name='emp_pi[philhealth]']");	
		var pagibig = $("input[name='emp_pi[pagibig]']");	
		var i_gender = $("input[name='emp_pi[gender]']");
		var r_gender = $("input[name=gender]");	
		var male = $('#male');
		var female = $('#female');
		var is_active = $('#is_active');
		var pass = $('#pass');
		var cpass = $('#cpass');
		var effective_date = $('input[name=effective_date]');
		var shift_remarks = $('textarea[name=shift_remarks]');
		
		// for newshift form 
		var savemode = $('input[name=savemode]');
		var recID = $('input[name=recID]');
		var errorVal = $('input[name=errorVal]');
		var manage_shift = $('#manage_shift');
		var add_newshift = $('#add_newshift');
		var newshiftsave = $('#newshiftsave');
		var addshift_modal = $('#addshift_modal');
		
		// for changesched form 
		var savemode1 = $('input[name=savemode1]');
		var recID1 = $('input[name=recID1]');
		var errorVal1 = $('input[name=errorVal1]');
		var manage_changesched = $('#manage_changesched');
		var changesched_modal = $('#changesched_modal');
		var add_changesched = $('#add_changesched');
		var addchangesched_modal = $('#addchangesched_modal');
		var newchangeschedsave = $('#newchangeschedsave');
		var addnewchangesched_form = $('#addnewchangesched_form');
		
		var datefiled = $('input[name=datefiled]');
		var beginsched = $('input[name=beginsched]');
		var endsched = $('input[name=endsched]');
		var totalhours = $('input[name=totalhours]');
		var remarks = $('textarea[name=remarks]');
		var changesched = $('#changesched');
		var offset = $('#offset');
		var approved = $('#approved')
		var denied = $('#denied');
		
		var emp_code = $("input[name='emp_ei[emp_code]']");	
		var emp_id = $('input[name=emp_id]');	
		var position = $("input[name='emp_ei[position]']");
		var date_hired = $("input[name='emp_ei[date_hired]']");
		var date_regularization = $("input[name='emp_ei[date_regularization]']");	
		var i_shift = $("input[name='emp_ei[shift]']");
		var r_shift = $("input[name=shift]");		
		var amshift	= $('#amshift');
		var pmshift	= $('#pmshift');
		var midshift = $('#midshift');
		var new_amshift	= $('#new_amshift');
		var new_pmshift	= $('#new_pmshift');
		var new_midshift = $('#new_midshift');
		
		
		var efirstname = $("input[name='emp_emerg[efirstname]']");	
		var emiddlename = $("input[name='emp_emerg[emiddlename]']");
		var elastname = $("input[name='emp_emerg[elastname]']");
		var relationship = $("input[name='emp_emerg[relationship]']");
		var ehome_phone = $("input[name='emp_emerg[ehome_phone]']");
		var emobile_phone = $("input[name='emp_emerg[emobile_phone]']");

		var profile_picture = $("#imagename");
		//=================Input Limits======================//
		
		firstname.alpha({allow:' '});
		middlename.alpha();
		lastname.alpha({allow:' '});
		nickname.alpha();
		street_address.alphanumeric({allow:' .'});
		city.alpha({allow:' '});
		province.alpha({allow:' '});
		country.alpha({allow:' '});
		zipcode.numeric();
		personal_email.alphanumeric({allow:' @.'});
		home_phone.numeric();
		mobile_phone.numeric();
		date_of_birth.numeric({allow:'/'});
		place_of_birth.alpha({allow:' '});
		tax_tin.numeric({allow:'-'});
		sss.numeric({allow:'-'});
		philhealth.numeric({allow:'-'});
		pagibig.numeric({allow:'-'});
		
		totalhours.numeric({allow:'.'});
		
		emp_code.alphanumeric();
		position.alpha({allow:' '});
		date_hired.numeric({allow:'/'});
		date_regularization.numeric({allow:'/'});
		
		efirstname.alpha({allow:' '});
		emiddlename.alpha();
		elastname.alpha({allow:' '});
		relationship.alpha();
		ehome_phone.numeric();
		emobile_phone.numeric();
		
		date_hired.datepicker();
		date_regularization.datepicker();
		date_of_birth.datepicker();
		
		
		if (credential == '1') {
			$('.emp_info').removeAttr('readonly');
			$('select').removeAttr('disabled');
			manage_shift.removeAttr('disabled');
			manage_changesched.removeAttr('disabled');
		}

		r_shift.click(function(){
			var s = $(this).val();
			i_shift.val(s);
		});

		if(i_shift.val() == '1'){
			amshift.attr('checked', 'checked');
		} else if (i_shift.val() == '2'){
			pmshift.attr('checked', 'checked');
		} else {
			midshift.attr('checked', 'checked');
		}

		r_gender.click(function(){     //gender radio button
			var g = $(this).val();
			i_gender.val(g);
		});

		if(i_gender.val() == '1') {           //gender hidden input 
			male.attr('checked', 'checked');
		} else {
			female.attr('checked', 'checked');
		}
		
		if(is_active.val() == 1) {
			$(this).prop('checked', true).prop('disabled', true);
		}else{
			$(this).prop('checked', false);
		}

		is_active.on('change', function(){                 // if checkbox is_active is changed 
		
			if($(this).val() == 1){
				$(this).val(0);
			} else {
				var r = confirm("Are you sure to permanently deactivate this user?");
				if(r == true){	
					$(this).val(1);
				} else {
					$(this).val(0).removeAttr('checked');

				}
			}	
		});


		$('#emp_edit').click(function(){                      // when submit button is clicked, this will check if password and confirm password values does match
			var cpass_val = cpass.val();
			var pass_val = pass.val();

			if(pass_val != cpass_val){
				alert('Password doesn\'t match');
				cpass.val('');
				pass.val('').focus();
				return false;
			} 
		});

		/**********************Add New Shift Functions**************************/
		effective_date.datepicker();

		manage_shift.click(function(){
			var id = emp_id.val();
			$('#shifts_modal').modal('show');
			$.ajax({
				url: EMPLOYEE_URI + 'employee/manage_shift',
				type: 'post',
				data: 'emp_id=' + id,
				dataType: 'json',
				success: function(data){
					$('#shift_table tbody').html('').html(data.shifttable);
				} 
			});
		});

		add_newshift.click(function(){
			addshift_modal.modal('show');
			savemode.val(0);
			new_amshift.prop('checked', true);
			effective_date.val('');
			shift_remarks.val('');
		});

		$('body').on('click', '.editshift', function(){
			var id = $(this).parent().parent().attr('id');
			recID.val(id);
			savemode.val(1);
			
			$.ajax({
				url: EMPLOYEE_URI + 'employee/fetch_newshift',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					effective_date.val(data.effective_date);
					shift_remarks.val(data.shift_remarks);

					if(data.new_shift == '1'){
						new_amshift.prop('checked', true);
					} else if (data.new_shift == '2'){
						new_pmshift.prop('checked', true);
					} else {
						new_midshift.prop('checked', true);
					}

					addshift_modal.modal('show');
				}

			});
		});

		$('body').on('click', '.deleteshift', function(){
			var id = $(this).parent().parent().attr('id');

			var x = confirm("Are you sure you want to delete this shift record?");

			if(x){
				$.ajax({
					url: EMPLOYEE_URI + 'employee/delete_newshift',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					success: function(data){
						if(data.success == 0){
							errorVal.val(1);
							alertify(data.msg, 'Notification');
						} else {
							errorVal.val(0);
							alertify(data.msg, 'Success');
						}
					}
				});
			}
		});

		newshiftsave.click(function(){
			var data = $('#addnewshift_form').serialize();
			var e_id = emp_id.val();
			var url;

			if(savemode.val() == 1){
				url = EMPLOYEE_URI + 'employee/update_newshift'
			}else {
				url = EMPLOYEE_URI + 'employee/add_newshift'
			}

			if(effective_date.val() != ''){
				$.ajax({
					url: url,
					type: 'post',
					data: data + '&emp_id=' + e_id,
					dataType: 'json',
					success: function(data){
						if(data.success == 0){
							errorVal.val(1);
							alertify(data.msg, 'Notification');
						} else {
							errorVal.val(0);
							alertify(data.msg, 'Success');
						}
					}
				});
			} else {
				alert('Enter effectivity date');
			}
		});

		/**********************End New Shift Functions*****************************/
		

		/**********************Add Change Sched Functions**************************/

		beginsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		endsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy",
			onSelect: function(){
				var begin = new Date(beginsched.val());
				var end = new Date($(this).val());
				var result = (end - begin) / (3600000);		// divide to that number because the result is in milliseconds (this gets the hour equivalent)
			
				totalhours.val(result); 
			}
		});
		
		
	
			 
		manage_changesched.click(function(){
			var id = emp_id.val();
			changesched_modal.modal('show');

			$.ajax({
				url: EMPLOYEE_URI + 'employee/manage_changesched',
				type: 'post',
				data: 'emp_id=' + id,
				dataType: 'json',
				success: function(data){
					$('#changesched_table tbody').html('').html(data.changeschedtable);
				} 
			});
		});
		
		add_changesched.click(function(){
			addchangesched_modal.modal('show');
			savemode1.val(0);	
			datefiled.val('');
			beginsched.val('');
			endsched.val('');
			totalhours.val('');
			remarks.val('');	
			changesched.prop('checked', true);
			approved.prop('checked', true);
		});
		
		newchangeschedsave.click(function(){ // save and edit changesched
			var data = $('#addnewchangesched_form').serialize();
			var e_id = emp_id.val();
			var e_code = emp_code.val();
			var url;

			if(savemode1.val() == 1){
				 url = EMPLOYEE_URI + 'employee/update_newchangesched'
			}else {
				url = EMPLOYEE_URI + 'employee/add_newchangesched'
			}

			if(beginsched.val() != '' && datefiled.val() != '' && endsched.val() != ''){
				$.ajax({
					url: url,
					type: 'post',
					data: data + '&emp_id=' + e_id + '&emp_code=' + e_code,
					dataType: 'json',
					success: function(data){
						if(data.success == 0){
							errorVal1.val(1);
							alertify(data.msg, 'Notification');
						} else {
							errorVal1.val(0);
							alertify(data.msg, 'Success');
						}
					}
				});
			} else {
				alert('Enter required fields');
			}
		});
		
		$('body').on('click', '.editchangesched', function(){
			var id = $(this).parent().parent().attr('id');
			recID1.val(id);
			savemode1.val(1);
			
			$.ajax({
				url: EMPLOYEE_URI + 'employee/fetch_newchangesched',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					datefiled.val(data.datefiled);
					remarks.val(data.remarks);
					beginsched.val(data.date_from);
					endsched.val(data.date_to);
					totalhours.val(data.totalhours);

					if(data.changetype == '1'){
						changesched.prop('checked', true);
					} else {
						offset.prop('checked', true);
					}
					
					if(data.status == '1'){
						approved.prop('checked', true);
					} else {
						denied.prop('checked', true);
					}
					
					addchangesched_modal.modal('show');
				}

			});
		});
		
		$('body').on('click', '.deletechangesched', function(){
			var id = $(this).parent().parent().attr('id');

			var x = confirm("Are you sure you want to delete this shift record?");

			if(x){
				$.ajax({
					url: EMPLOYEE_URI + 'employee/delete_newchangesched',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					success: function(data){
						if(data.success == 0){
							errorVal1.val(1);
							alertify(data.msg, 'Notification');
						} else {
							errorVal1.val(0);
							alertify(data.msg, 'Success');
						}
					}
				});
			}
		});

		/**********************End New Change Sched Functions**************************/



		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	

		s_department.change(function() {
			var str = "";
			$("select.department option:selected").each(function() {
			  str += $(this).val();
			});
			i_dep.val(str);
		});


		
		s_department.val(i_dep.val());

		s_company.change(function() {
			var str = "";
			s_department.val('');
			$("select.company option:selected").each(function() {
			  str += $(this).val();
			});

			i_company.val(str);
			$('.'+str).show();
+			$('select[name=s_department] option').not('.'+str).hide();    // hide departments that are not covered by a certain company
		});

		
		function loadDepartments() {

			var c = $("input[name='emp_ei[company]']").val();

			$('.'+c).show();
+			$('select[name=s_department] option').not('.'+c).hide();    // hide departments that are not covered by a certain company

		}

		loadDepartments();
		
		s_company.val(i_company.val());

		s_restday.change(function(){
			var str = "";
			$("select.restday option:selected").each(function() {
			  str += $(this).val();
			});
			i_restday.val(str);
		});

		s_restday.val(i_restday.val());

		$('#cancel').click(function(){
			if(confirm("Cancel edit and go back to User Management?")) {
				window.location.href = ADMIN_URI + 'admin/admin_user_cpanel';
			}
		});

	    $("#imageupload").on("change", function() {
	        var files = !!this.files ? this.files : [];
	        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
	 
	        if (/uploads/.test( files[0].type)){ // only image file
	            var reader = new FileReader(); // instance of the FileReader
	            reader.readAsDataURL(files[0]); // read the local file
	 
	            reader.onloadend = function(){ // set image data as background of div
	                $("#imagepreview").css("background-image", "url("+this.result+")");
	            }
	        }
	    });


		/*function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#imageupload').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#imagepreview").change(function(){
			readURL(this);
		});*/

		/*This is to set checkbox value to 1 and 0 if checked and unchecked*/
	});

	function basename(path) {
	   return path.split(/[\\/]/).pop();
	  };

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagepreview').attr('src', e.target.result);
            };
            $('#imagename').val(basename($('#imageupload').val()));
            reader.readAsDataURL(input.files[0]);
        }
    }
	
	//ON HOVER ALERT 
	$('#alertuid').popover();

</script>