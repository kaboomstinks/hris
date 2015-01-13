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
		                        	<input type="text" value="<?php echo $emp_code; ?>" class="form-control emp_info" name="emp_ei[emp_code]" readonly />
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Company</th>
		                        <td>
		                        	<input type="hidden" value="<?php echo $company; ?>" class="form-control emp_info" name="emp_ei[company]" readonly />
		                        	<div class="form-group">
			                        	<select class="form-control company" name="s_company" disabled>
			                        		<option value="1">Circus Co. Ltd (Philippine Branch)</option>
			                        		<option value="2">Tavolozza</option>
			                        		<option value="3">HalloHallo Inc.</option>
			                        	</select>
			                        </div>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Department</th> 
		                        <td>
		                        	<input type="hidden" value="<?php echo $department; ?>" class="form-control emp_info" name="emp_ei[department]">
		                        	<div class="form-group">
			                        	<select class="form-control department" name="s_department" disabled>
								    		<option class="cc" value="1">Systems Development</option>
								    		<option class="cc" value="2">Web Design</option>
								    		<option class="cc" value="3">GA - Human Resources</option>
								    		<option class="cc" value="4">GA - Accounting</option>
								    		<option class="cc" value="5">SWAT</option>
								    		<option class="cc" value="6">Graphic Design</option>
								    		<option class="hh" value="7">Systems Development</option>
								    		<option class="hh" value="8">Web Design</option>
								    		<option class="hh" value="9">Operations</option>
								    		<option class="hh" value="10">Creatives</option>
								    		<option class="hh" value="11">Sales And Marketing</option>
								    		<option class="tt" value="12">Systems Development</option>
			                        	</select>
			                        </div>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Position</th>
		                        <td>
		                        	<input type="text" value="<?php echo $position; ?>" class="form-control emp_info" name="emp_ei[position]" readonly>	
		                        </td>
		                    </tr>
		                     <tr>
		                        <th>Schedule</th>
		                        <td>
		                        	<input name="emp_ei[shift]" type="hidden" value="<?php echo $shift; ?>" />
		                        	<input id="amshift" type="radio" name="shift" value="1" checked="checked" />AM&nbsp;&nbsp;
        							<input id="midshift" type="radio" name="shift" value="3" />Mid&nbsp;&nbsp;
        							<input id="pmshift" type="radio" name="shift" value="2" />PM
		                        </td>
		                    </tr>
		                     <tr>
		                        <th>Rest Day</th>
		                        <td>
		                        <input type="hidden" value="<?php echo $rest_day; ?>" class="form-control emp_info" name="emp_ei[rest_day]">
		                        	<select name="s_restday" class="form-control restday" disabled>
		                        		<option value="10">Choose a restday</option>
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
		                        	<input type="text" value="<?php echo $emp_status; ?>" class="form-control emp_info" name="emp_ei[emp_status]" readonly>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Date Hired</th>
		                        <td>
		                        	<input type="text" value="<?php echo $date_hired; ?>" class="form-control emp_info datepicker" name="emp_ei[date_hired]" data-date-format="MM/DD/YYYY" placeholder="MM/DD/YYYY" readonly>
		                        </td>
		                    </tr>
		                    <tr>
		                        <th>Date of Regularization</th>
		                        <td>
		                        	<input type="text" value="<?php echo $date_regularization; ?>" class="form-control emp_info datepicker" name="emp_ei[date_regularization]" data-date-format="MM/DD/YYYY" placeholder="MM/DD/YYYY" readonly>
		                        </td>
		                    </tr>
		                    <?php 
		                    if (isAdmin()) { ?>
			                    <tr>
			                        <th>Deactivate</th>
			                        <td>
			                        	<input type="checkbox" value="<?php echo $is_active; ?>" class="is_active" name="emp_ei[is_active]" ><br/>
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

		var emp_code = $("input[name='emp_ei[emp_code]']");	
		var position = $("input[name='emp_ei[position]']");
		var date_hired = $("input[name='emp_ei[date_hired]']");
		var date_regularization = $("input[name='emp_ei[date_regularization]']");	
		var i_shift = $("input[name='emp_ei[shift]']");
		var r_shift = $("input[name=shift]");		
		var amshift	= $('#amshift');
		var pmshift	= $('#pmshift');
		var midshift = $('#midshift');
		
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
		
		$('#emp_edit').click(function(){
			var data = $('#emp_edit_form').serialize();

			if($('#pass').val()!=$('#cpass').val()){
		       alert('Password not matches');
		       return false;
		    }
			
			$.ajax({
				url: EMPLOYEE_URI + 'employee/employee_account_confirm',
				type: 'post',
				data: data
			});
		});
		
		s_department.change(function() {
			var str = "";
			$("select.department option:selected").each(function() {
			  str += $(this).val();
			});
			i_dep.val(str);
		});
		
		s_department.val(i_dep.val());

		s_company.on('change', function() {
			var str = "";
			s_department.val('');
			$("select.company option:selected").each(function() {
			  str += $(this).val();
			});
			i_company.val(str);
			loadDepartments(str);
		});
		
		s_company.val(i_company.val());

		s_restday.change(function(){
			var str = "";
			$("select.restday option:selected").each(function() {
			  str += $(this).val();
			});
			i_restday.val(str);
		});

		s_restday.val(i_restday.val());

		function loadDepartments(c){
			switch(c){

				case '1':
					$('.cc').show();
					$('.hh').hide();
					$('.tt').hide();
					break;

				case '2':
					$('.cc').hide();
					$('.hh').hide();
					$('.tt').show();
					break;

				case '3':
					$('.cc').hide();
					$('.hh').show();
					$('.tt').hide();
					break;
			}
		}
		
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
		if ($('.is_active').val() == 1) {
			$('.is_active').prop('checked', true);
			$('.is_active').prop('disabled', true);
		}else{
			$('.is_active').prop('checked', false);
		}

		$('.is_active').on('change', function(){
			if ($(this).val() == 0) {
				$(this).val('1');
			}else{
				$(this).val('0');
			};
			
		})
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

    $(function() {
   		$("#emp_edit").click(function(){
   			if ($('.is_active').val() == 1) {
		      	if (confirm("Are you sure to permanently deactivate this user?")){
		         	$('form#emp_edit_form').submit();
		      	}else{
		      		return false;
		      	}
		    }
    	});
	});
	
	
</script>