
<!-- 
for posting:
real_name
contact
nickname
e-mail
password1
password2
 -->

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" style="margin-top:50px;">
        <div class="panel-heading">
        	<h3>Confirmation</h3>
        </div>
	    <form action="" method="post" id="emp_submit_form">
	        <div class="panel-body clearfix">
	    		<div class="col-md-6">
	        		<div class="page-header">
	            		<h3>Basic information</h3>
	       			</div>
	        		<table class="table table-striped table-hover">
	                    <tr>
	                        <th>Firstname</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['firstname']; ?>" type="hidden" name="emp_pi[firstname]">
	                        	<?php echo $emp_pi['firstname']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Middlename</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['middlename']; ?>" type="hidden" name="emp_pi[middlename]">
	                        	<?php echo $emp_pi['middlename']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Lastname</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['lastname']; ?>" type="hidden" name="emp_pi[lastname]">
	                        	<?php echo $emp_pi['lastname']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Nickname</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['nickname']; ?>" type="hidden" name="emp_pi[nickname]">
	                        	<?php echo $emp_pi['nickname']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Street Address</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['street_address']; ?>" type="hidden" name="emp_pi[street_address]">
	                        	<?php echo $emp_pi['street_address']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>City</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['city']; ?>" type="hidden" name="emp_pi[city]">
	                        	<?php echo $emp_pi['city']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Province</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['province']; ?>" type="hidden" name="emp_pi[province]">
	                        	<?php echo $emp_pi['province']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Country</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['country']; ?>" type="hidden" name="emp_pi[country]">
	                        	<?php echo $emp_pi['country']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Zipcode</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['zipcode']; ?>" type="hidden" name="emp_pi[zipcode]">
	                        	<?php echo $emp_pi['zipcode']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Personal E-mail</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['personal_email']; ?>" type="hidden" name="emp_pi[personal_email]">
	                        	<?php echo $emp_pi['personal_email']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Home Phone</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['home_phone']; ?>" type="hidden" name="emp_pi[home_phone]">
	                        	<?php echo $emp_pi['home_phone']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Mobile Phone</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['mobile_phone']; ?>" type="hidden" name="emp_pi[mobile_phone]">
	                        	<?php echo $emp_pi['mobile_phone']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Date of Birth</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['date_of_birth']; ?>" type="hidden" name="emp_pi[date_of_birth]">
	                        	<?php echo $emp_pi['date_of_birth']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Place of Birth</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['place_of_birth']; ?>" type="hidden" name="emp_pi[place_of_birth]">
	                        	<?php echo $emp_pi['place_of_birth']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Gender</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['gender']; ?>" type="hidden" name="emp_pi[gender]">
	                        	<?php if($emp_pi['gender'] == 0){echo 'Female'; } else {echo 'Male'; } ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Civil Status</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['civil_status']; ?>" type="hidden" name="emp_pi[civil_status]">
	                        	<?php echo $emp_pi['civil_status']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Tax Identification No.</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['tax_tin']; ?>" type="hidden" name="emp_pi[tax_tin]">
	                        	<?php echo $emp_pi['tax_tin']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Social Security System No.</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['sss']; ?>" type="hidden" name="emp_pi[sss]">
	                        	<?php echo $emp_pi['sss']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>PhilHealth No.</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['philhealth']; ?>" type="hidden" name="emp_pi[philhealth]">
	                        	<?php echo $emp_pi['philhealth']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Home Development Mutual Fund(Pagibig) No.</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['pagibig']; ?>" type="hidden" name="emp_pi[pagibig]">
	                        	<?php echo $emp_pi['pagibig']; ?>
	                        </td>
	                    </tr>


	                    <!-- <tr>
	                        <th>Password</th>
	                        <td> -->
	                        	<input value="<?php echo $user['password']; ?>" type="hidden" name="user[password]">
	                        	<!--<?php/* echo $user['password']; */ ?>-->
	                        <!-- </td>
	                    </tr> -->
	                </table>
	            </div>
                <div class="col-md-6">
	                <div class="page-header">
	        			<h3>Employee Information</h3>
	        		</div>
	                <table class="table table-striped table-hover">
	                	<tr>
	                		
	                        <th>Profile Picture</th>
	                        <td>
	                        	<input value="<?php echo $emp_pi['profile_picture']; ?>" type="hidden" name="emp_pi[person_pic]">
	                        	<?php echo $emp_pi['profile_picture']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Employee Code</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['emp_code']; ?>" type="hidden" name="emp_ei[emp_code]">
	                        	<?php echo $emp_ei['emp_code']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Company</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['company']; ?>" type="hidden" name="emp_ei[company]">
	                        	<?php
									foreach ($companies as $key => $c) {
										if($c['id'] == $emp_ei['company']){
											echo $c['company_name'];
										}
									}
								?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Department</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['department']; ?>" type="hidden" name="emp_ei[department]">
	                        	<?php 
	                        		foreach ($departments as $key => $d) {
	                        			if($d['id'] == $emp_ei['department']){
											echo $d['dep_name'];
										}
	                        		}
	                        	
	                        	?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Position</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['position']; ?>" type="hidden" name="emp_ei[position]">
	                        	<?php echo $emp_ei['position']; ?>
	                        </td>
	                    </tr>
	                      <tr>
	                        <th>Schedule</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['shift']; ?>" type="hidden" name="emp_ei[shift]">
	                        	<?php switch($emp_ei['shift']){case '1': echo "AM Shift"; break; case '2': echo "PM Shift"; break; case '3': echo "Mid Shift"; break;} ?>
	                        </td>
	                    </tr>
	                     <tr>
	                        <th>Rest Day</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['rest_day']; ?>" type="hidden" name="emp_ei[rest_day]">
	                        	<?php switch($emp_ei['rest_day']){case '0': echo "Sunday"; break; case '1': echo "Monday"; break; case '2': echo "Tuesday"; break;case '3': echo "Wednesday"; break; case '4': echo "Thursday"; break; case '5': echo "Friday"; break; case '6': echo "Saturday"; break;} ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Employment Status</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['emp_status']; ?>" type="hidden" name="emp_ei[emp_status]">
	                        	<?php echo $emp_ei['emp_status']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Date Hired</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['date_hired']; ?>" type="hidden" name="emp_ei[date_hired]">
	                        	<?php echo $emp_ei['date_hired']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Date of Regularization</th>
	                        <td>
	                        	<input value="<?php echo $emp_ei['date_regularization']; ?>" type="hidden" name="emp_ei[date_regularization]">
	                        	<?php echo $emp_ei['date_regularization']; ?>
	                        	<input value="<?php echo @$emp_ei['is_active']; ?>" type="hidden" name="emp_ei[is_active]">
	                        </td>
	                    </tr>
	                </table>
	                <div class="page-header">
	                	<h3>Emergency Details</h3>
	                </div>
	                <table class="table table-striped table-hover">
	                    <tr>
	                        <th>In case of emergency notify:</th>
	                        <td>
	                        	<input value="<?php echo $emp_emerg['efirstname']; ?>" type="hidden" name="emp_emerg[efirstname]">
	                        	<input value="<?php echo $emp_emerg['emiddlename']; ?>" type="hidden" name="emp_emerg[emiddlename]">
	                        	<input value="<?php echo $emp_emerg['elastname']; ?>" type="hidden" name="emp_emerg[elastname]">
	                        	<?php echo $emp_emerg['efirstname'] . ' ' . $emp_emerg['emiddlename'] . ' ' . $emp_emerg['elastname']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Relationship</th>
	                        <td>
	                        	<input value="<?php echo $emp_emerg['relationship']; ?>" type="hidden" name="emp_emerg[relationship]">
	                        	<?php echo $emp_emerg['relationship']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Person to notify Home Phone</th>
	                        <td>
	                        	<input value="<?php echo $emp_emerg['ehome_phone']; ?>" type="hidden" name="emp_emerg[ehome_phone]">
	                        	<?php echo $emp_emerg['ehome_phone']; ?>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th>Person to notify Mobile Phone</th>
	                        <td>
	                        	<input value="<?php echo $emp_emerg['emobile_phone']; ?>" type="hidden" name="emp_emerg[emobile_phone]">
	                        	<?php echo $emp_emerg['emobile_phone']; ?>
	                        </td>
	                    </tr>
	                </table>
    			</div>
        	</div>
    	</form>
    <div class=" panel-footer">
    	<p class=" text-center">
    		<button type="button" class="btn btn-warning btn-lg" onclick="history.back()">Edit</button>&nbsp;
    		<input type="submit" class="btn btn-danger btn-lg" id="employee_submit" value="Submit"/>
    	</p>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#logout').show();

		$('#employee_submit').click(function(){
			
			var data = $('#emp_submit_form').serialize();
			$.ajax({
				url: EMPLOYEE_URI + 'employee/emp_save',
				type: 'post',
				data: data,
				dataType: 'json',
				complete: function(){
				//console.log(data)
						window.location.href = EMPLOYEE_URI + 'admin/admin_user_cpanel';
					}
			});
		});
	});
</script>