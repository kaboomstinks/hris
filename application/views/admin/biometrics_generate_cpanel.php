<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="departmentcontainer" style="width:925px;float:right;margin-top:100px">
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td width="118px">Company</td>
					<td width="118px">Department</td>
					<td width="100px">Position</td>
					<td width="115px">Name</td>
					<td width="80px">Time In</td>
					<td width="80px">Status</td>
					<td>Reason</td>
					<td>Remarks</td>
				</tr>
			</thead>
		</table>
		<div  style="width:940px; height:450px; overflow:scroll;">
			<form method="post">
				<table class="table table-striped">
					<tbody>
						<?php

					// $file_path = 'document/bio_dummy.txt';
					
					// if (file_exists($file_path)) {

						// $openFile = fopen(base_url().'document/bio_dummy.txt', 'r');
						// $getDatetimeNow = '2013/09/20';
						// $tempnum = NULL;
						
						// while (!feof($openFile)) {
							// $arrM = explode('\n',fgets($openFile));
							// $val = current($arrM);

							// if(!strstr($val,'No')){         // looping not including the title headers

								// while ($val) {
									// $thisrow = explode('	', $val);
									// $getLatestDate = explode('  ', $thisrow[6]);

									// if(($getDatetimeNow == $getLatestDate[0]) && ($tempnum != $thisrow[2])){

										// $bio_id_txt[] = $thisrow[2];
										// $date_txt[] = $getLatestDate[0];
										// $timein_txt[] = $getLatestDate[1];	
										
									
									// }

									// $tempnum = $thisrow[2];
									// $val = next ($arrM);
									
								// }
							// }
						// }

					// } else {
						// echo "The file $file_path does not exist";
					// }						

					// /******************************** End of reading flat file	**********************************/	

												
											
					// $getAllBioID = mysql_query('SELECT DISTINCT bm_id FROM tbl_employee_info');
					
					// while($row2 = mysql_fetch_assoc($getAllBioID)){
						// $bio_id_db[] = $row2['bm_id'];
					// } 

					// $array_count2 = count($bio_id_db) - 1; 

					// for ($j=0; $j <= $array_count2; $j++) { 
						// $key = array_search($bio_id_db[$j], $bio_id_txt);
						
						// if ($key)	{

							// $bio_data[] = populateData('Late', $bio_id_txt, null, $timein_txt, $j, $key);
							
						// }else {

							// $bio_data[] = populateData('Absent', null, $bio_id_db, null, $j);
					 
						// }	
					// }

					// /******************************* End Data Population **********************************************/

					// function populateData($stat, $bio_id_txt, $bio_id_db, $timein_txt, $j, $key=null){

						// $compileArray = array();

						// if($stat == 'Late'){
							// $bm_id = $bio_id_txt[$key];
							// $timein = $timein_txt[$key];
						// }

						// if($stat == 'Absent'){
							// $bm_id = $bio_id_db[$j];
							// $timein = 'No Time In';
						// }


						// $sql = "SELECT tbl_employee_info.company, tbl_employee_info.emp_code, tbl_employee_info.department, tbl_employee_info.position, tbl_person_info.firstname, tbl_person_info.lastname, tbl_company.company_name, tbl_departments.dep_name, tbl_attendance_shift.shift_time_in
									// FROM tbl_employee_info
									// LEFT JOIN tbl_person_info ON tbl_employee_info.emp_id = tbl_person_info.id
									// LEFT JOIN tbl_company ON tbl_employee_info.company = tbl_company.id
									// LEFT JOIN tbl_departments ON tbl_employee_info.department = tbl_departments.id
									// LEFT JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
									// WHERE bm_id = $bm_id";   // you can either use $bio_id_txt or $bio_id_db 
						
							// $getEmployeeData = mysql_query($sql);
							// $row = mysql_fetch_assoc($getEmployeeData);

							// $fullname = $row['firstname'].' '.$row['lastname'];
							// $company = $row['company_name'];
							// $department = $row['dep_name'];
							// $position = $row['position'];
							// $emp_code = $row['emp_code'];
							// $shift_time_in = $row['shift_time_in'];

							// if($row){     // if biometric ID found has data associated with it

								// if($timein > $shift_time_in && $key!=null){		// this dumps late data
									// $status = "<td width='80px'><input type='radio' name='status$j' class='r_late' value='Late' checked=checked />&nbsp;Late<br /><input type='radio' name='status$j' class='r_absent'  value='Absent' />&nbsp;Absent</td>";	
										
									// echo "<tr id='$emp_code'>
										// <td width='118px'>$company</td>
										// <td width='118px'>$department</td>
										// <td width='100px'>$position</td>
										// <td width='115px'>$fullname</td>
										// <td width='80px'>$timein</td>".$status."
										// <td><textarea type='text' name='reason[]'></textarea></td>
										// <td><textarea type='text' name='remark[]'></textarea></td>
									// </tr>";

									// $data = array("emp_code" => $emp_code, "company" => $company, "department" => $department, "position" => $position,
												// "status" => "Late", "full_name" => $fullname);
									// $compileArray = $data;
									  

								// }

								// if($key==null){									// this dumps absent data
									// $status = "<td width='80px'><input type='radio' name='status$j' class='r_late' value='Late' />&nbsp;Late<br /><input type='radio' name='status$j' class='r_absent'  value='Absent' checked=checked />&nbsp;Absent</td>";
									
									// echo "<tr id='$emp_code'>
										// <td width='118px'>$company</td>
										// <td width='118px'>$department</td>
										// <td width='100px'>$position</td>
										// <td width='115px'>$fullname</td>
										// <td width='80px'>$timein</td>".$status."
										// <td><textarea type='text' name='reason[]'></textarea></td>
										// <td><textarea type='text' name='remark[]'></textarea></td>
									// </tr>";

									// $data = array('emp_code' => $emp_code, 'company' => $company, 'department' => $department, 'position' => $position,
												// 'status' => 'Absent', 'full_name' => $fullname);
									// $compileArray = $data;
									  
								// }

								
								// return $compileArray;
							// }


							
					// }
					?>
					</tbody>
				</table>
				<input type="hidden" name="data" value='<?php //echo json_encode($bio_data); ?>' />
			</form>
			<?php
			// <span style="float:right; margin-top:19px;">
				// <button id="bulk_save_records" class="btn btn-default" type="submit" />Save Records</button><br /><br />
			// </span>
			?>
		</div>
		<div>
			
			<span style="float:right; margin-top:19px;">
			<input type='radio' name='shift' value='1' id='shift'> Morning shift <br>
			<input type='radio' name='shift' value='2' id='shift'> Mid shift
		
			
			<input class="btn btn-warning " id="generate_record" type="submit" value="Generate Attendance" /></button><br /><br />

				<?php //echo form_open_multipart('admin/do_upload'); ?>
				<?php 
				//<input class="btn btn-warning" type="submit" value="Upload Records" /></button><br /><br />
				//<input type="file" name="userfile" size="20" />
				?>
			</span>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');
		


		// $('#bulk_save_records').click(function(){
			// var data = $('input[name=data]').val();
			// alert(data);

			// $.ajax({
				// url: ADMIN_URI + 'admin/biometrics_save_attendance',
				// type: 'post',
				// data: 'data=' + data,
				// dataType: 'json'

			// });
		// });
		
		// var department_name = $('input[name=department_name]');
		// var department_abbr = $('input[name=department_abbr]');
		// var company_id = $('select[name=company_id]');
		// var adddepartment_modal = $('#adddepartment_modal');
		// var savemode = $('input[name=savemode]');
		// var recID = $('input[name=recID]');
		// var departmentsave = $('#departmentsave');
		
		
		// //============Input Limits================//
		
		// department_name.alpha({allow:' '});
		// department_abbr.alpha({allow:' '});

		// $('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');
		
		// $('#add_department').click(function(){
		// 	adddepartment_modal.modal('show');
		// 	savemode.val(0);
		// 	clearValues();
		// });

		// function validatedepartment(){
		// 	var valid = true;
		// 	var error = '';
			
		// 	if($.trim(department_name.val()) == ''){
		// 		valid = false;
		// 		error += 'Enter department name \n';
		// 	}
			
		// 	if($.trim(department_abbr.val()) == ''){
		// 		valid = false;
		// 		error += 'Enter department abbreviation \n';
		// 	}
			
		// 	if(error != ''){
		// 		alert(error);
		// 	}
			
		// 	return valid;
		// }

		// function clearValues(){
		// 	company_id.val(1);
		// 	department_name.val('');
		// 	department_abbr.val('');
		// }

		
		// $('.editlink').click(function(){
		// 	var id = $(this).parent().parent().attr('id');
		// 	recID.val(id);
		// 	savemode.val(1);

		// 	$.ajax({
		// 		url: ADMIN_URI + 'admin/edit_department',
		// 		type: 'post',
		// 		data: 'id=' + id,
		// 		dataType: 'json',
		// 		success: function(data){
		// 			company_id.val(data.company_id);
		// 			department_name.val(data.dep_name);
		// 			department_abbr.val(data.dep_abbr);
		// 			adddepartment_modal.modal('show');
		// 		}
		// 	});
		// });

		// $('.deletelink').click(function(){
		// 	var id = $(this).parent().parent().attr('id');
		// 	var x = confirm("Are you sure you want to delete this department?");

		// 	if(x){
		// 		$.ajax({
		// 			url: ADMIN_URI + 'admin/delete_department',
		// 			type: 'post',
		// 			data: 'id=' + id,
		// 			dataType: 'json',
		// 			complete: function(){
		// 				location.reload();
		// 			}
		// 		});
		// 	}
		// });

		// departmentsave.click(function(){
			
		// 	if(validatedepartment()){
		// 		var data = $('#adddepartment_form').serialize();
		// 		var url;

		// 		if(savemode.val() == 1){
		// 			url = ADMIN_URI + 'admin/update_department';
		// 		} else {
		// 			url = ADMIN_URI + 'admin/add_department';
		// 		}

		// 		$.ajax({
		// 			url: url,
		// 			type: 'post',
		// 			data: data,
		// 			dataType: 'json',
		// 			beforeSend: function(){
		// 				departmentsave.text('Saving...');
		// 			},
		// 			success: function(data){
		// 				if(data.success == 0){
		// 					alert(data.msg);
		// 				} else {
		// 					location.reload();
		// 				}
		// 			},
		// 			complete: function(){
		// 				departmentsave.text('Save');
		// 			}
		// 		});
		// 	} 

		// });	
			$urls = ADMIN_URI + 'generaterecord.php';
			$('#generate_record').click(function(){
			//var data = $('input[name=data]').val();
			var shift = $('input:radio[name=shift]:checked').val();

			
			var datavalue = {shiftdata: shift};	
			$.ajax({
				url: $urls,
				type: 'post',
				dataType: 'json',
				data : datavalue,
				success : function(data){
				 result = data;
                console.log(result);

				},
			async: false
			});
		});
});
</script>