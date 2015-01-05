<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="departmentcontainer" style="width:925px;float:right;margin-top:100px">
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td align="center"  width='33.33%'><span data-field="department_name" data-sort="ASC" style="cursor:pointer;">Employee No.</span></td>
					<td align="center"  width='33.33%'><span data-field="department_abbr" data-sort="ASC" style="cursor:pointer;">Employee Code</span></td>
					<td align="center"  width='33.33%'>Time</td>
				</tr>
			</thead>
		</table>
		<div  style="width:940px; height:450px; overflow:scroll;">
		<table class="table table-striped">
			<tbody>
			<?php

				function insertToAttTime($sheet_id, $attendance_time, $late, $undertime, $overtime){
					$q = mysql_query("SELECT id FROM tbl_attendance_time WHERE sheet_id = $sheet_id");
					$result = mysql_fetch_assoc($q);
					$numrows = mysql_num_rows($q);
				
					if($numrows == 0){
						mysql_query("INSERT INTO tbl_attendance_time (sheet_id, attendance_time, late, undertime, overtime)
											VALUES ('$sheet_id', '$attendance_time', '$late', '$undertime', '$overtime')");
					} 
				}

				function insertToAttLog($emp_code, $emp_id, $datetime){
					$checkDuplicateSql = "SELECT * FROM tbl_attendance_log WHERE emp_code = '$emp_code' AND attendance_datetime = '$datetime'";
					$q = mysql_query($checkDuplicateSql);
					$numrows = mysql_num_rows($q);
					
					if($numrows == 0){
						mysql_query("INSERT INTO tbl_attendance_log(emp_id, emp_code, attendance_datetime) VALUES('$emp_id', '$emp_code', '$datetime')") or die(mysql_error());
					}
				}

				function doStuff(){
					$q = mysql_query("SELECT emp_id, emp_code, attendance_datetime FROM tbl_attendance_log");
					
					while($row = mysql_fetch_assoc($q)){
						$emp_id = $row['emp_id'];
						$emp_code = $row['emp_code'];
						$datetime = $row['attendance_datetime'];	
						$getLatestDate = explode('  ', $datetime);

						$shift = getShiftDetails($emp_id);
						$shiftid = $shift['shiftid'];
						
						$timeIn = $shift['shift_time_in'];
						$timeOut = $shift['shift_time_out'];

						$outTimeBeg = strtotime("-3 hour", strtotime($timeOut));
						$outTimeEnd = strtotime("+3 hour", strtotime($timeOut));

						$currentTime = strtotime($getLatestDate[1]);
						
						$duplicate = checkDuplicateInAttSheet($emp_id, $datetime);
						
						if($duplicate['numrows'] == 0){
							$exist = checkExist($emp_id);
							$attendance_time_in = $exist['attendance_time_in'];
							$attendance_time_out = $exist['attendance_time_out'];
							$sheet_id = $exist['sheet_id'];

							switch($shiftid) {

								case 1:

									if(empty($attendance_time_in)){
										insertTimeInAttSheet($emp_id, $emp_code, $shiftid, $datetime);
									}else {
										$existAttSheet = checkExistTimeInAttSheet($emp_id, $datetime);
										if($existAttSheet['attendance_time_in'] != $datetime){
											updateTimeOutAttSheet($datetime, $sheet_id);
										}
									}
									break;

								case 2:

									if( ($currentTime >= $outTimeBeg) && ($currentTime <= $outTimeEnd)) {
										if(empty($attendance_time_in) && empty($attendance_time_out)) {
											insertTimeOutAttSheet($emp_id, $emp_code, $shiftid, $datetime);
										} 

										if(empty($attendance_time_in)) {
											$existAttSheet = checkExistTimeInAttSheet($emp_id, $datetime);
											if($existAttSheet['attendance_time_in'] != $datetime){
												updateTimeInAttSheet($datetime, $sheet_id);
											}
										} 

										if(empty($attendance_time_out)){
											$existAttSheet = checkExistTimeOutAttSheet($emp_id, $datetime);
											if($existAttSheet['attendance_time_out'] != $datetime){
												updateTimeOutAttSheet($datetime, $sheet_id);
											}
										}
									}else {
										if(empty($attendance_time_in) && empty($attendance_time_out)) {
											insertTimeInAttSheet($emp_id, $emp_code, $shiftid, $datetime);
										}
										
										if(empty($attendance_time_in)) {
											$existAttSheet = checkExistTimeInAttSheet($emp_id, $datetime);
											if($existAttSheet['attendance_time_in'] != $datetime){
												$updateTimeOutAttSheet($datetime, $sheet_id);
											}
										}
										
										if(empty($attendance_time_out)){
											$existAttSheet = checkExistTimeOutAttSheet($emp_id, $datetime);
										
											if($existAttSheet['attendance_time_out'] != $datetime){
												updateTimeInAttSheet($datetime, $sheet_id);
											}
										}
									}
									break;

								case 3:

									if(empty($attendance_time_in)) {
										insertTimeInAttSheet($emp_id, $emp_code, $shiftid, $datetime);
									}else {
										$existAttSheet = checkExistTimeInAttSheet($emp_id, $datetime);
										
										if($existAttSheet['attendance_time_in'] != $datetime){
											updateTimeOutAttSheet($datetime, $sheet_id);
										}
									}
									break;
							} //end switch	
						}
					
						if(!empty($duplicate['row']['attendance_time_in']) && !empty($duplicate['row']['attendance_time_out'])){ // if both time in and time out have values
					
							$getDateinTimein = explode("  ", $duplicate['row']['attendance_time_in']);
							$getDateinTimeout = explode("  ", $duplicate['row']['attendance_time_out']);
							
							$thisIn = strtotime($duplicate['row']['attendance_time_in']);
							$thisOut = strtotime($duplicate['row']['attendance_time_out']);
							
							$createdTimein = strtotime($getDateinTimein[0]. "  " .$timeIn);
							$createdTimeout = strtotime($getDateinTimeout[0]. "  " .$timeOut);
							$minute = 60;
							$hour   = 60*$minute;
							$getOT = "";
							$getUT = "";
						
							if($thisIn <= $createdTimein){
							
								print_r('Early ');
								print_r($shiftid. ' ');
								print_r('Time In: ' .date('H:i', $thisIn). " / " .$timeIn);
								print_r(' Time Out: ' .date('H:i', $thisOut) ." / " .$timeOut);
								$computeThis = $thisOut - $createdTimein;
								$computeInShift = $createdTimeout - $createdTimein;
								
								$total["hour"]    = floor($computeThis/$hour);
								$total["minute"]   = floor(($computeThis%$hour)/$minute);

								$inShiftTotal["hour"]    = floor($computeInShift/$hour);
								$inShiftTotal["minute"]   = floor(($computeInShift%$hour)/$minute);

								print_r(" = " .$total["hour"] . " hours, "  . $total["minute"] . " minutes");
								$gettime = date('H:i', strtotime($total["hour"]. ":" .$total["minute"]));						//computed time based on biometrics record outside shift 					  
								$timeInShift = date('H:i', strtotime($inShiftTotal["hour"]. ":" .$inShiftTotal["minute"]));		//computed time based on biometrics record inside shift	   
								print_r(" = " .$gettime);
								$attendanceTime = $gettime;
								
								if(strtotime('09:00') < strtotime($gettime)){						//overtime
									$ot["hour"]    = floor($computeThis / $hour) - 9;
									$ot["minute"]   = floor(($computeThis%$hour)/$minute);
									$getOT = date('H:i',strtotime($ot['hour'].":".$ot['minute']));
									print_r(" = " .$getOT."(OT)");	
									print_r(" == " .$timeInShift);
									$attendanceTime = $timeInShift;
								} else if(strtotime('09:00') == strtotime($gettime)) {															
									print_r(" == " .$timeInShift);
									$attendanceTime = $timeInShift;
								} else {
									$computeUnderTime = strtotime('09:00') - strtotime($gettime);  //undertime
									$ut["hour"]    = floor($computeUnderTime / $hour);
									$ut["minute"]   = floor(($computeUnderTime%$hour)/$minute);
									$getUT = date('H:i',strtotime($ut['hour'].":".$ut['minute']));
									print_r(" = " .$getUT."(UT)");
									print_r(" == " .$gettime);
								}

								print_r("<br />");
								insertToAttTime($duplicate['row']['id'], $attendanceTime, "", $getUT, $getOT);  
			
							}else {
							
								print_r('Late');
								print_r($shiftid. ' ');
								print_r('Time In: ' .date('H:i', $thisIn). " / " .$timeIn);
								print_r(' Time Out: ' .date('H:i', $thisOut) ." / " .$timeOut);
								$computeLate = $thisIn - $createdTimein;
								$computeThis = $thisOut - $thisIn;
								$computeInShift = $createdTimeout - $thisIn;		

								$total["hour"]    = floor($computeThis/$hour);
								$total["minute"]   = floor(($computeThis%$hour)/$minute);
								
								$late["hour"]    = floor($computeLate/$hour);
								$late["minute"]   = floor(($computeLate%$hour)/$minute);

								$inShiftTotal["hour"]    = floor($computeInShift/$hour);
								$inShiftTotal["minute"]   = floor(($computeInShift%$hour)/$minute);

								print_r(" = " .$total["hour"] . " hours, "  . $total["minute"] . " minutes");
								$totallate = date('H:i', strtotime($late["hour"]. ":" .$late["minute"]));
								$gettime = date('H:i', strtotime($total["hour"]. ":" .$total["minute"]));							//computed time based on biometrics record outside shift
								$timeInShift = date('H:i', strtotime($inShiftTotal["hour"]. ":" .$inShiftTotal["minute"]));			//computed time based on biometrics record outside shift
								print_r(" = " .$gettime);
								print_r(" = " .$totallate."(Late)");
								$attendanceTime = $gettime;

								if(strtotime('09:00') < strtotime($gettime)){   				//overtime
									$ot["hour"]    = floor($computeThis / $hour) - 9;
									$ot["minute"]   = floor(($computeThis%$hour)/$minute);
									$getOT = date('H:i',strtotime($ot['hour'].":".$ot['minute']));
									print_r(" = " .$getOT."(OT)");
									print_r(" == " .$timeInShift);
									$attendanceTime = $timeInShift;
								} else if(strtotime('09:00') == strtotime($gettime)) {
									print_r(" == " .$timeInShift);
									$attendanceTime = $timeInShift;
								} else {														
									$computeUnderTime = strtotime('09:00') - strtotime($gettime);   //undertime
									$ut["hour"]    = floor($computeUnderTime / $hour);
									$ut["minute"]   = floor(($computeUnderTime%$hour)/$minute);
									$getUT = date('H:i',strtotime($ut['hour'].":".$ut['minute']));
									print_r(" = " .$getUT."(UT)");
									print_r(" == " .$gettime);
								}

								insertToAttTime($duplicate['row']['id'], $attendanceTime, $totallate, $getUT, $getOT);
								print_r("<br />");
							}
						}
					} // end while
				}

				function checkExist($emp_id){
					$q = mysql_query("SELECT *, tbl_attendance_shift.id as shiftid, tbl_attendance_sheet.id as sheet_id FROM tbl_attendance_sheet 
								INNER JOIN tbl_attendance_shift ON tbl_attendance_sheet.attendance_shift = tbl_attendance_shift.id
								WHERE emp_id = '$emp_id' AND (attendance_time_in IS NULL OR attendance_time_out IS NULL) ORDER BY sheet_id DESC");
					$row = mysql_fetch_assoc($q);	
					return $row;
				}

				function insertTimeOutAttSheet($emp_id, $emp_code, $shiftid, $datetime){
					mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_out)
								VALUES('$emp_id', '$emp_code', '$shiftid', '$datetime')");
				}

				function insertTimeInAttSheet($emp_id, $emp_code, $shiftid, $datetime){
					mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_in)
								VALUES('$emp_id', '$emp_code', '$shiftid', '$datetime')");
				}

				function updateTimeOutAttSheet($datetime, $sheet_id){
					 mysql_query("UPDATE tbl_attendance_sheet SET attendance_time_out = '$datetime' WHERE id = '$sheet_id'");
				}

				function updateTimeInAttSheet($datetime, $sheet_id){
					 mysql_query("UPDATE tbl_attendance_sheet SET attendance_time_in = '$datetime' WHERE id = '$sheet_id'");
				}
				
				
				function checkDuplicateInAttSheet($emp_id, $datetime){
					$q = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '$emp_id' AND (attendance_time_in = '$datetime' OR attendance_time_out = '$datetime')");
					$data['row'] = mysql_fetch_assoc($q);
					$data['numrows'] = mysql_num_rows($q);
					return $data;
				}

				function checkExistTimeInAttSheet($emp_id, $datetime){
					$q = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '$emp_id' AND attendance_time_in = '$datetime'");
					$row = mysql_fetch_array($q);
					return $row;
				}

				function checkExistTimeOutAttSheet($emp_id, $datetime){
					$q = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '$emp_id' AND attendance_time_out = '$datetime'");
					$row = mysql_fetch_array($q);
					return $row;
				}

				function getShiftDetails($emp_id){ //waiting
					$q = mysql_query("SELECT *, tbl_attendance_shift.id as shiftid, tbl_employee_info.shift as sheet_id FROM tbl_employee_info
										INNER JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
										WHERE emp_id = '$emp_id'");
					$row = mysql_fetch_assoc($q);
					return $row;
				}


				$openFile = fopen(base_url().'document/attendance_sheet.txt', 'r');
				$getDatetimeNow = '2014/11/07';
				$i = 0;
				$tempnum = NULL;
				
				while (!feof($openFile)) {
					$arrM = explode('\n',fgets($openFile));
					$val = current($arrM);
					while ($val) {
						$thisrow = explode('	', $val);
						$getLatestDate = explode('  ', $thisrow[6]);
				
						if($getDatetimeNow == $getLatestDate[0] && $tempnum != $thisrow[2]) {
							$getEmployeedata = mysql_query("SELECT *, tbl_attendance_shift.id as shiftid, tbl_employee_info.shift as sheet_id FROM tbl_employee_info
									INNER JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
									WHERE emp_id = '" .$thisrow[2]. "'") or die(mysql_error());   //look for shift
							$row = mysql_fetch_array($getEmployeedata);
							//fn_print_r($row);
							$emp_id = $row['emp_id'];
							$emp_code = $row['emp_code'];
							$emp_id = $row['emp_id'];
							$datetime = trim($thisrow[6]);
						
							if($emp_id) {
								print "<tr>
										<td align='center' width='33.33%'>$emp_id</td>
										<td align='center' width='33.33%'>$emp_code</td>
										<td align='center' width='33.33%'>$datetime</td>
									</tr>";
								
								insertToAttLog($emp_code, $emp_id, $datetime);
							}

						}

						$tempnum = $thisrow[2];
						$val = next ($arrM) ;
					}
				}

				doStuff();  //do all from computing to printing to view to inserting values into tbl_attendance_time
				
			?>
			</tbody>
		</table>
		</div>
		<div>
			<!--<span style="float:right; margin-top:19px;">
				<a href="<?php //echo base_url(); ?>admin/admin_view_attendance" id="add_department" class="btn btn-primary" target="_blank">View</a>
			</span>-->
			<span style="float:right; margin-top:19px;">
				<?php echo form_open_multipart('admin/do_upload');?>
				<input class="btn btn-warning" type="submit" value="Upload Records" /></button><br /><br />
				<input type="file" name="userfile" size="20" />
				</form>
			</span>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var department_name = $('input[name=department_name]');
		var department_abbr = $('input[name=department_abbr]');
		var company_id = $('select[name=company_id]');
		var adddepartment_modal = $('#adddepartment_modal');
		var savemode = $('input[name=savemode]');
		var recID = $('input[name=recID]');
		var departmentsave = $('#departmentsave');
		
		
		//============Input Limits================//
		
		department_name.alpha({allow:' '});
		department_abbr.alpha({allow:' '});

		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');
		
		$('#add_department').click(function(){
			adddepartment_modal.modal('show');
			savemode.val(0);
			clearValues();
		});

		function validatedepartment(){
			var valid = true;
			var error = '';
			
			if($.trim(department_name.val()) == ''){
				valid = false;
				error += 'Enter department name \n';
			}
			
			if($.trim(department_abbr.val()) == ''){
				valid = false;
				error += 'Enter department abbreviation \n';
			}
			
			if(error != ''){
				alert(error);
			}
			
			return valid;
		}

		function clearValues(){
			company_id.val(1);
			department_name.val('');
			department_abbr.val('');
		}

		
		$('.editlink').click(function(){
			var id = $(this).parent().parent().attr('id');
			recID.val(id);
			savemode.val(1);

			$.ajax({
				url: ADMIN_URI + 'admin/edit_department',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					company_id.val(data.company_id);
					department_name.val(data.dep_name);
					department_abbr.val(data.dep_abbr);
					adddepartment_modal.modal('show');
				}
			});
		});

		$('.deletelink').click(function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to delete this department?");

			if(x){
				$.ajax({
					url: ADMIN_URI + 'admin/delete_department',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		departmentsave.click(function(){
			
			if(validatedepartment()){
				var data = $('#adddepartment_form').serialize();
				var url;

				if(savemode.val() == 1){
					url = ADMIN_URI + 'admin/update_department';
				} else {
					url = ADMIN_URI + 'admin/add_department';
				}

				$.ajax({
					url: url,
					type: 'post',
					data: data,
					dataType: 'json',
					beforeSend: function(){
						departmentsave.text('Saving...');
					},
					success: function(data){
						if(data.success == 0){
							alert(data.msg);
						} else {
							location.reload();
						}
					},
					complete: function(){
						departmentsave.text('Save');
					}
				});
			} 

		});	
});
</script>