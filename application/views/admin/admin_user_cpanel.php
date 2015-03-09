<style>

::-webkit-input-placeholder { /* WebKit browsers */
	 font-style: italic;
     color: GrayText !important;
}
.form-control option:first-child{
display:none;
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
<div style="width:1100px;margin:auto auto">
	<div style="margin:0 0 50px 984px">
		<form action="<?php echo base_url(); ?>admin/admin_user_cpanel">
			<span style="position:relative;top:60px;right:120px;">Search:</span><input value="" class="search form-control" type="text" name="search" style="width:180px;position:relative;top:34px;right:65px;"></form>
	</div>
	<div style="width:150px;margin-right:25px;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>

	<div id="userscontainer" style="width:925px;float:right">
	<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'USER' ? '': 'Employees');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td><span data-field="company" data-sort="ASC" style="cursor:pointer;">Company</span></td>
					<td><span data-field="username" data-sort="ASC" style="cursor:pointer;">Username</span></td>
					<td><span data-field="lastname" data-sort="ASC" style="cursor:pointer;">Lastname</span></td>
					<td><span data-field="firstname" data-sort="ASC" style="cursor:pointer;">Firstname</span></td>
					<td><span data-field="middlename" data-sort="ASC" style="cursor:pointer;">Middlename</span></td>
					<td><span data-field="currentshift" data-sort="ASC" style="cursor:pointer;">Shift</span></td>
					<td><span data-field="changeshift" data-sort="ASC" style="cursor:pointer;">Cs</span></td>
					<td align="center" colspan="2">Actions</td>
				</tr>
			</thead>
			<tbody id="userstable">
				<?php if(!empty($userstable)) {
					     // fn_print_die($userstable, $changesched_empid);
					$temp_emp_id = null;
					
					foreach ($userstable as $key => $users) { 
			
							if($users->shift == 1){
								$currentshift = '8:00 - 17:00';
							}elseif ($users->shift == 2){
								$currentshift = '16:00 - 1:00';
							}else { 
								$currentshift = '09:00 - 18:00';	
							}
						
					?>
						<!--   This users view originally displays just a list of employeess from every company but an added feature was realized. It 
								should now show if an employee has a changesched for today by adding a red circle in Cs column. The devs added an additional 
								query to join tbl_changesched but this causes duplicate entries (employees with more than one changesched history) to appear. 
								This duplicate entries are all normal and cannot be treated as a bug but this should not be happening, There shouldn't be 
								any duplicate entries. So the developers painstakingly thought of any solution to fix it. The guys tweak the query inside 
								getUserSearchTable function in admin model to make this feature request possible. This still needs testing though. (ccs0rd02)
						-->
						
					
							<tr id="<?php echo $users->tl_id; ?>">
								
								<td style="<?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $users->company_name; ?></td>
								<td style="max-width: 101px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; <?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $users->username; ?></td>
								<td style="max-width: 153px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; <?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $users->lastname; ?></td>
								<td style="max-width: 153px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; <?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $users->firstname; ?></td>
								<td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; <?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $users->middlename; ?></td>
								<td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; <?php if ($users->is_active == 1) {echo 'color: red';} ?>"><?php echo $currentshift; ?></td>
								<td>
									<?php if ($users->date_from && $users->date_to && $users->changetype && $users->status) { ?>
										<img src="<?php echo base_url(); ?>images/common/red_dot.png" width="12px" height="12px">	
									<?php } ?>
								</td>
								<td align="center" colspan="2" id="<?php echo $users->tl_emp; ?>"><a class="printpdf btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> PDF</a>&nbsp;&nbsp;<?php if ($users->is_active == 1) { echo ''; }else{ ?><a class="edituser btn btn-warning" href=<?php echo base_url(); ?>./employee/employee_edit?username=<?php echo $users->username; ?>><span class="glyphicon glyphicon-pencil"></span> Edit</a><?php } ?></td>	
							</tr>
							
						
					<?php } ?>
				<?php }?>
			</tbody>
		</table>
		<div>
			<span id="links" style="float:left;"><?php echo $links; ?></span>
			<span style="float:right; margin-top:19px;"><button id="adduser" class="btn btn-primary">New</button></span>
		</div>
	</div>
	
	<!-- Add User Modal --> 
	
	<div class="modal fade" id="adduser_modal">
	  <div class="modal-dialog"  style="width:280px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">Add User</h3>
			<input type="hidden" name="errorVal" value="0">
		  </div>
		  <div class="modal-body">
		  <form id="adduser_form">
			<input style="width:250px" type="text" name="fname" class="form-control" placeholder="First Name" /><br />
			<input style="width:250px" type="text" name="mname" class="form-control" placeholder="Middle Name" /><br />
			<input style="width:250px" type="text" name="lname" class="form-control" placeholder="Last Name" /><br />
			<input style="width:250px" type="text" name="username" class="form-control" placeholder="Username" maxlength="8" /><br />
			<input style="width:250px" type="text" name="bm_id" class="form-control" placeholder="Biometrics ID" maxlength="5" /><br />
			<select class="form-control" name="company" style="width:250px">
				<option value="0">Select Company</option>
				
				<?php if(!empty($companies)) {
					foreach ($companies as $key => $c) { ?>
						<option value="<?php echo $c['id']?>"><?php echo $c['company_name']; ?></option>

				<?php } }?>
        
        	</select><br />
        	<select class="form-control" name="department" style="width:250px">
        		<option value="">Select Department</option>
        	
	        	<?php if (!empty($departments)){
	        	
	        		foreach ($departments as $key => $d) {
	        			$department_name = $d['dep_name']; 
	        			$dep_id = $d['id'];
	        			$c_id = $d['company_id'];

						echo "<option class=$c_id value=$dep_id>$department_name</option>";
	        		}
	        	} ?>
        	</select><br />
        	
			<select class="form-control" name="restday">
				<option value="10">Select Rest Day</option>
				<option value="0">Sunday</option>
				<option value="1">Monday</option>
				<option value="2">Tuesday</option>
				<option value="3">Wednesday</option>
				<option value="4">Thursday</option>
				<option value="5">Friday</option>
				<option value="6">Saturday</option>
			</select><br />
        	&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;font-size:16px">Shift</span>&nbsp;&nbsp;&nbsp;&nbsp;<input id="amshift" type="radio" name="shift" value="1" checked="checked" />AM&nbsp;&nbsp;<input id="midshift" type="radio" name="shift" value="3" />Mid&nbsp;&nbsp;<input id="pmshift" type="radio" name="shift" value="2" />PM<br />
			&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;font-size:16px">Role:</span>&nbsp;&nbsp;&nbsp;<input id="adminrole" type="radio" name="role" value="1" />Admin&nbsp;&nbsp;<input id="userrole" type="radio" name="role" value="2" checked=checked />User
		  </form>
		  
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="usersave">Save</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- -------------------Useless Pagination------------- -->
	
</div>
<script>
	$(document).ready(function(){
		
		var logmein = $('#login');
		var username = $('input[name=username]');
		var fname = $('input[name=fname]');
		var mname = $('input[name=mname]');
		var lname = $('input[name=lname]');
		var bm_id = $('input[name=bm_id]');
		var errorVal = $('input[name=errorVal]');
		var company = $('select[name=company]');
		var department = $('select[name=department]');
		var restday = $('select[name=restday]');
		var searchinput = $('input[name=searchinput]');
		
		
		//============Input Limits================//
		
		fname.alpha({allow:' '});
		mname.alpha();
		lname.alpha({allow:' '});
		username.alphanumeric();
		searchinput.alpha();
		bm_id.numeric();
		
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');

		company.change(function(){
			var c = $(this).val();	
+			$('.'+c).show();
+			$('select[name=department] option').not('.'+c).hide();    // hide departments that are not covered by a certain company
			department.val('');
		});
		
		function validateuser(){
			var valid = true;
			var error = '';
			
			if($.trim(fname.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter Firstname <br />';
			}
			
			if($.trim(mname.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter Middlename <br />';
			}
			
			if($.trim(lname.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter Lastname <br />';
			}
			
			if($.trim(username.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter Username <br />';
			}

			if($.trim(bm_id.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter Biometrics ID <br />';
			}

			if(company.val() == 0){
				valid = false;
				errorVal.val(1);
				error += 'Select Company <br />';
			}

			if(department.val() == ''){
				valid = false;
				errorVal.val(1);
				error += 'Select Department <br />';
			}

			if(restday.val() == 10){
				valid = false;
				errorVal.val(1);
				error += 'Select Rest Day';
			}
			
			
			if(error != ''){
				alertify(error, 'Error')
			}
			
			return valid;
		}
		
		$('.printpdf').click(function(){
			var id = $(this).parent().attr('id');
			window.open('<?php echo base_url(); ?>admin/admin_employeedetails_form?id=' + id +'', width=430,height=360);
		});
		
		$('#adduser').click(function(){
			$('#adduser_modal').modal('show');
		});
		
		$('#usersave').click(function(){
			
			if(validateuser()){
				var data = $('#adduser_form').serialize();
			
				$.ajax({
					url: ADMIN_URI + 'admin/user',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function(data){
						if(data.success == 0){
							errorVal.val(1);
							alertify(data.msg, 'Error');
						} else {
							errorVal.val(0);
							alertify('Successfully Added!', 'Notification');
						}
					}
				});
			}
		});

		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	

	
		// $('.search').keypress(function(){
		// 	var search = $(this).val();
		// 	var fieldname = $("thead span").attr('data-field');
		//     var sort = $("thead span").attr('data-sort');

		// 	$.ajax({
		// 		url: ADMIN_URI + 'admin/admin_user_cpanel',
		// 		type: 'post',
		// 		data: {'search': search, 'fieldname': fieldname, 'sort': sort},
		// 		success: function(data){
		// 			$('#userstable').html(data);

		// 		}
		// 	});

		// 	var row_num = $("#numrow").val();

		//     if (row_num <= 5 || row_num == undefined) {
		//     	$('#links').css('display', 'none');
		//     }else{
		//     	$('#links').css('display', 'block');
		//     };

		//     if ($(this).val() == '') {
		//     	$('#links').css('display', 'block');
		//     };

		// });
		
		$("thead span").click(function(){
	    	var search = $('.search').val();
	        var fieldname = $(this).attr('data-field');
		    var sort = $(this).attr('data-sort');

	        if (sort == "ASC") {
	        	$(this).attr('data-sort', 'DESC')
	        }else{
	        	$(this).attr('data-sort', 'ASC')
	        };

	        $.ajax({
				url: ADMIN_URI + 'admin/admin_user_cpanel',
				type: 'post',
				data: {'search': search, 'fieldname': fieldname, 'sort': sort},
				success: function(data){
					//$('#userstable').html(data);
					$('#userstable').html(data.value);
					$('#links').html(data.pagination);
				}
			});  
	    });

		 // $('#links').on('click', function(){
	  //   	var s = $('.search').val();

	  //   	$('.pagination a').each(function(){
	  //   		var url = $(this).attr('href');

	  //   		if (s != undefined) {
		 //    		$(this).attr('href', url+'?search='+s)
	  //   		};
	  //   	});
	  //   });
	});
</script>