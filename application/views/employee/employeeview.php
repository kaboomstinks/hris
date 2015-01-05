<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" style="margin-top:120px;">
        <div class="panel-heading">
        	<strong>Welcome <?php if ($nickname != null || $nickname != '') {
                echo $nickname;
            }else{
                echo $firstname;
            }  ?>!</strong>
        	<strong class="pull-right"><a href="employee_edit">Edit</a></strong>
        </div>
        <div class="panel-body clearfix">
    		<div class="col-md-6">
        		<div class="page-header">
            		<h3>Personal information</h3>
       			</div>
        		<table class="table table-striped table-hover">
                    <tr>
                    	<th>Employer</th>
	                    <td>
	                       <?php echo $employer; ?>
	                    </td>
	                </tr>
                    <tr>
                        <th>Name (real name)</th>
                        <td><?php echo $firstname . ' ' . $middlename . ' ' . $lastname; ?></td>
                    </tr>
                    <tr>
                    	<th>Profile image</th>
                        <td>
                            <p><img class="thumbnail" alt="150x150" src="<?php echo base_url(); ?>images/no-image.png" style="width: 150px; height: 150px;"></p>
                        </td>
                	</tr>
                    <tr>
                        <th>Firstname</th>
                        <td><?php echo $firstname; ?></td>
                    </tr>
                    <tr>
                        <th>Middlename</th>
                        <td><?php echo $middlename; ?></td>
                    </tr>
                    <tr>
                        <th>Lastname</th>
                        <td><?php echo $lastname; ?></td>
                    </tr>
                    <tr>
                        <th>Nickname</th>
                        <td><?php echo $nickname; ?></td>
                    </tr>
                    <tr>
                        <th>Street Address</th>
                        <td><?php echo $street_address; ?></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><?php echo $city; ?></td>
                    </tr>
                    <tr>
                        <th>Province</th>
                        <td><?php echo $province; ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?php echo $country; ?></td>
                    </tr>
                    <tr>
                        <th>Zipcode</th>
                        <td><?php echo $zipcode; ?></td>
                    </tr>
                    <tr>
                        <th>Personal E-mail</th>
                        <td><?php echo $personal_email; ?></td>
                    </tr>
                    <tr>
                        <th>Home Phone</th>
                        <td><?php echo $home_phone; ?></td>
                    </tr>
                    <tr>
                        <th>Mobile Phone</th>
                        <td><?php echo $mobile_phone; ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo $date_of_birth; ?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td><?php echo $place_of_birth; ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo $gender; ?></td>
                    </tr>
                    <tr>
                        <th>Civil Status</th>
                        <td><?php echo $civil_status; ?></td>
                    </tr>
                    <tr>
                        <th>Tax Identification No.</th>
                        <td><?php echo $tax_tin; ?></td>
                    </tr>
                    <tr>
                        <th>Social Security System No.</th>
                        <td><?php echo $sss; ?></td>
                    </tr>
                    <tr>
                        <th>PhilHealth No.</th>
                        <td><?php echo $philhealth; ?></td>
                    </tr>
                    <tr>
                        <th>Home Development Mutual Fund(Pagibig) No.</th>
                        <td><?php echo $pagibig; ?></td>
                    </tr>
                </table>
                
            </div>
            <div class="col-md-6">
                <div class="page-header">
                    <h3>Employee Information</h3>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Employee Code</th>
                        <td><?php echo $emp_code; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td><?php echo $company; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?php echo $department; ?></td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td><?php echo $position; ?></td>
                    </tr>
                    <tr>
                        <th>Employment Status</th>
                        <td><?php echo $emp_status; ?></td>
                    </tr>
                    <tr>
                        <th>Date Hired</th>
                        <td><?php echo $date_hired; ?></td>
                    </tr>
                    <tr>
                        <th>Date of Regularization</th>
                        <td><?php echo $date_regularization; ?></td>
                    </tr>
                </table>
                <div class="page-header">
                    <h3>Emergency Details</h3>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>In case of emergency notify:</th>
                        <td><?php if(isset($efirstname) && isset($emiddlename) && isset($elastname)){echo $efirstname .  ' ' . $emiddlename . ' ' . $elastname;} ?></td>
                    </tr>
                    <tr>
                        <th>Relationship</th>
                        <td><?php if(isset($efirstname)){echo $relationship;} ?></td>
                    </tr>
                    <tr>
                        <th>Person to notify Home Phone</th>
                        <td><?php if(isset($efirstname)){echo $home_phone;} ?></td>
                    </tr>
                    <tr>
                        <th>Person to notify Mobile Phone</th>
                        <td><?php if(isset($efirstname)){echo $mobile_phone;} ?></td>
                    </tr>
                </table>
	        </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('#logout').show();
	});
</script>