<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;background:#f7f5fa;border-radius:5px">
		<a href="#manage" class="list-group-item" data-toggle="collapse">Manage</a>
	    <div class="collapse" id="manage">
      		<a href="<?php echo base_url(); ?>admin/admin_user_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Users</a>
      		<a href="<?php echo base_url(); ?>admin/admin_company_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Companies</a>
     		<a href="<?php echo base_url(); ?>admin/admin_department_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Departments</a>
      		<a href="<?php echo base_url(); ?>admin/admin_benefit_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Benefits</a>
      		<a href="<?php echo base_url(); ?>admin/admin_attendancefile_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload Attendance</a>
	    </div>
	    <a href="#manage2" class="list-group-item" data-toggle="collapse">Employee</a>
	    <div class="collapse" id="manage2">
		    <a href="<?php echo base_url(); ?>admin/admin_leave_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave</a>
			<a href="<?php echo base_url(); ?>admin/admin_request_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request</a>
			<a href="<?php echo base_url(); ?>admin/admin_changesched_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Schedule</a>
			<a href="<?php echo base_url(); ?>admin/admin_attendance_cpanel" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Attendance Report</a>
			<a href="<?php echo base_url(); ?>email/mail_form" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email Report</a>
	    </div>
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

				function insertToAttendanceTime($sheet_id, $attendance_time, $late, $undertime, $overtime){

					$query = mysql_query("SELECT id FROM tbl_attendance_time WHERE sheet_id = $sheet_id");
					$result = mysql_fetch_assoc($query);
					$numrows = mysql_num_rows($query);
				
					if($numrows == 0){
						$query2 = mysql_query("INSERT INTO tbl_attendance_time (sheet_id, attendance_time, late, undertime, overtime)
												 VALUES ('$sheet_id', '$attendance_time', '$late', '$undertime', '$overtime')");
					} 
				}


				$openFile = fopen(base_url().'document/attendance_sheet.txt', 'r');
				$getDatetimeNow = '2014/11/07';
				$i = 0;
				$tempnum = NULL;
	while (!feof($openFile)) {
		$arrM = explode('\n',fgets($openFile));
		$val = current  ( $arrM )  ;
		while ( $val ) {
			$thisrow = explode('	', $val);
			
			$getLatestDate = explode('  ', $thisrow[6]);
			fn_print_r($getLatestDate);
			if($getDatetimeNow == $getLatestDate[0] && $tempnum != $thisrow[2]) {
				//if($temptime <= $getLatestDate[1]) {
					$getEmployeedata = mysql_query("SELECT *, tbl_attendance_shift.id as shiftid, tbl_employee_info.shift as sheet_id FROM tbl_employee_info
							INNER JOIN tbl_attendance_shift ON tbl_employee_info.shift = tbl_attendance_shift.id
							WHERE emp_id = '" .$thisrow[2]. "'") or die(mysql_error());   //look for shift
					$row = mysql_fetch_array($getEmployeedata);
					if(!empty($row['emp_id'])) {
						print "<tr>
								<td align='center' width='33.33%'>$row[emp_id]</td>
								<td align='center' width='33.33%'>$row[emp_code]</td>
								<td align='center' width='33.33%'>$thisrow[6]</td>
							</tr>";
						$filterDuplicationInLogQuery = mysql_query("SELECT * FROM tbl_attendance_log WHERE emp_code = '" .$row['emp_code']. "' AND attendance_datetime = '" .trim($thisrow[6]). "'");
						$countDuplicationInLog = mysql_num_rows($filterDuplicationInLogQuery); //filter duplicate logins
						if($countDuplicationInLog == 0) { //pang log 
							mysql_query("INSERT INTO tbl_attendance_log(emp_id, emp_code, attendance_datetime) VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
						}
						$i++;

					

						$filterDuplicationInSheetQuery = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '" .$row['emp_id']. "' AND (attendance_time_in = '" .trim($thisrow[6]). "' OR attendance_time_out = '" .trim($thisrow[6]). "')");
						$filterDuplicationInSheet = mysql_fetch_array($filterDuplicationInSheetQuery);
						$countDuplicationInSheet = mysql_num_rows($filterDuplicationInSheetQuery);

						$validateIfExist = mysql_query("SELECT *, tbl_attendance_shift.id as shiftid, tbl_attendance_sheet.id as sheet_id FROM tbl_attendance_sheet 
								INNER JOIN tbl_attendance_shift ON tbl_attendance_sheet.attendance_shift = tbl_attendance_shift.id
								WHERE emp_id = '" .$thisrow[2]. "' AND (attendance_time_in IS NULL OR attendance_time_out IS NULL) ORDER BY sheet_id DESC");
						$validationQuery = mysql_fetch_array($validateIfExist);
						
						$getShiftTime = mysql_query("SELECT * FROM tbl_attendance_shift WHERE id = '" .$row['shiftid']. "'");
						$ShiftTimeQuery = mysql_fetch_array($getShiftTime);

						$timeIn = $ShiftTimeQuery['shift_time_in'];
						$inTimeBeg = strtotime("-3 hour", strtotime($timeIn));
						$inTimeEnd = strtotime("+3 hour", strtotime($timeIn));

						$timeOut = $ShiftTimeQuery['shift_time_out'];
						$outTimeBeg = strtotime("-3 hour", strtotime($timeOut));
						$outTimeEnd = strtotime("+3 hour", strtotime($timeOut));

						$currentTime = strtotime($getLatestDate[1]);
						//$overtime = NULL;
						//  && ( $filterDuplicationInSheet['attendance_time_in'] == trim($thisrow[6]) || $filterDuplicationInSheet['attendance_time_out'] == trim($thisrow[6]) )
						
						if($countDuplicationInSheet == 0){  // in attendance sheet insert new record
							switch($row['shiftid']) {
								case 1:
									if(empty($validationQuery['attendance_time_in'])) {
										mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_in)
										VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
									}
									else {
										$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
											AND attendance_time_in = '" .trim($thisrow[6]). "'");
										$Filter = mysql_fetch_array($filterData);
										if($Filter['attendance_time_in'] != trim($thisrow[6])){
											 mysql_query("UPDATE tbl_attendance_sheet
											 	SET attendance_time_out = '" .trim($thisrow[6]). "'
											 	WHERE id = '" .$validationQuery['sheet_id']. "'");
										}
									}
									break;

								case 2:

									if( ($currentTime >= $outTimeBeg) && ($currentTime <= $outTimeEnd)) {
										if(empty($validationQuery['attendance_time_in']) && empty($validationQuery['attendance_time_out'])) {
											mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_out)
											VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
										}
										else if(empty($validationQuery['attendance_time_in'])) {
											$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
												AND attendance_time_in = '" .trim($thisrow[6]). "'");
											$Filter = mysql_fetch_array($filterData);
											if($Filter['attendance_time_in'] != trim($thisrow[6])){
												mysql_query("UPDATE tbl_attendance_sheet
													SET attendance_time_in = '" .trim($thisrow[6]). "'
													WHERE id = '" .$validationQuery['sheet_id']. "'");
											}
										}
										else if(empty($validationQuery['attendance_time_out'])){
											$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
												AND attendance_time_out = '" .trim($thisrow[6]). "'");
											$Filter = mysql_fetch_array($filterData);
											if($Filter['attendance_time_out'] != trim($thisrow[6])){
												mysql_query("UPDATE tbl_attendance_sheet
													SET attendance_time_out = '" .trim($thisrow[6]). "'
													WHERE id = '" .$validationQuery['sheet_id']. "'");
											}
										}
									}
									else {
										if(empty($validationQuery['attendance_time_in']) && empty($validationQuery['attendance_time_out'])) {
											mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_in)
											VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
										}
										else if(empty($validationQuery['attendance_time_in'])) {
											$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
												AND attendance_time_in = '" .trim($thisrow[6]). "'");
											$Filter = mysql_fetch_array($filterData);
											if($Filter['attendance_time_in'] != trim($thisrow[6])){
												mysql_query("UPDATE tbl_attendance_sheet
													SET attendance_time_out = '" .trim($thisrow[6]). "'
													WHERE id = '" .$validationQuery['sheet_id']. "'");
											}
										}
										else if(empty($validationQuery['attendance_time_out'])){
											$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
												AND attendance_time_out = '" .trim($thisrow[6]). "'");
											$Filter = mysql_fetch_array($filterData);
											if($Filter['attendance_time_out'] != trim($thisrow[6])){
												mysql_query("UPDATE tbl_attendance_sheet
													SET attendance_time_in = '" .trim($thisrow[6]). "'
													WHERE id = '" .$validationQuery['sheet_id']. "'");
											}
										}
									}
									break;

								case 3:
									if(empty($validationQuery['attendance_time_in'])) {
										mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_in)
										VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
									}
									else {
										$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
											AND attendance_time_in = '" .trim($thisrow[6]). "'");
										$Filter = mysql_fetch_array($filterData);
										if($Filter['attendance_time_in'] != trim($thisrow[6])){
											mysql_query("UPDATE tbl_attendance_sheet
												SET attendance_time_out = '" .trim($thisrow[6]). "'
												WHERE id = '" .$validationQuery['sheet_id']. "'");
										}
									}
									break;
							}
						}
						//$selectAlldata = ("SELECT * FROM tbl_attendance_sheet WHERE attendance_time_in IS NOT NULL AND attendance_time_out IS NOT NULL");


						 if (!empty($filterDuplicationInSheet['attendance_time_in']) && !empty($filterDuplicationInSheet['attendance_time_out'])){
							$timeIn = $ShiftTimeQuery['shift_time_in'];
							$timeOut = $ShiftTimeQuery['shift_time_out'];
							//fn_print_die($boomthinin[1]);
							$getDateinTimein = explode("  ", $filterDuplicationInSheet['attendance_time_in']);
							
							$thisIn = strtotime($filterDuplicationInSheet['attendance_time_in']);
							$getDateinTimeout = explode("  ", $filterDuplicationInSheet['attendance_time_out']);
							$thisOut = strtotime($filterDuplicationInSheet['attendance_time_out']);
							// $interval = $thisOut - $thisIn;
							// $computedhour = $interval/3600;
							
							$createdTimein = strtotime($getDateinTimein[0]. "  " .$timeIn);
							$createdTimeout = strtotime($getDateinTimeout[0]. "  " .$timeOut);
							$minute = 60;
							$hour   = 60*$minute;
							$getOT = "";
							$getUT = "";
						
							if($thisIn <= $createdTimein){
							
								print_r('Early ');
								print_r($row['shiftid']. ' ');
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

							//	insertToAttendanceTime($filterDuplicationInSheet['id'], $attendanceTime, "", $getUT, $getOT);  
			
							}else {
							
								print_r('Late');
								print_r($row['shiftid']. ' ');
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
									//fn_print_r($computeUnderTime, $gettime);
								}

								//insertToAttendanceTime($filterDuplicationInSheet['id'], $attendanceTime, $totallate, $getUT, $getOT);
								print_r("<br />");


								// if($thisOut > $createdTimeout){   //overtime
								// 	if(strtotime('09:00') > strtotime($gettime)){
								// 		$ot["hour"]    = (floor($computeThis / $hour));
								// 		$ot["minute"]   = floor(($computeThis%$hour)/$minute);
								// 		$getOT = date('H:i',strtotime($ot['hour'].":".$ot['minute']));
								// 		print_r(" = " .$getOT."(OT)");
								// 		fn_print_r('>', $ot['hour']);
								// 	}else {
								// 		$ot["hour"]    = floor($computeThis / $hour) - 9;
								// 		$ot["minute"]   = floor(($computeThis%$hour)/$minute);
								// 		$getOT = date('H:i',strtotime($ot['hour'].":".$ot['minute']));
								// 		print_r(" = " .$getOT."(OT)");
								// 	}
									
								// } 

								// if($thisOut < $createdTimeout) {    //undertime
								// 	$computeUnderTime = $createdTimeout - $thisOut;
								// 	$ut["hour"] = floor($computeUnderTime/$hour); 
								// 	$ut["minute"]   = floor(($computeUnderTime%$hour)/$minute);
								// 	$getUT = date('H:i',strtotime($ut['hour'].":".$ut['minute']));
								// 	print_r(" = " .$getUT."(UT)");
								// }
										
								
							
								//print_r(" === " .($computeThis/3600). "<br />");
							}
								// mysql_query("UPDATE tbl_attendance_sheet
								// 		SET attendance_time = '" .$gettime. "', attendance_status
								// 		WHERE id = '" .$validationQuery['sheet_id']. "'") or die(mysql_error());
							/*print_r($filterDuplicationInSheet['emp_code']. " -> "
								.date('H:i', $thisIn). " / "
								.$timeIn. " - "
								.date('H:i', $thisOut). " / "
								.$timeOut. " = "
								.$computedhour. "<br />");*/
						}
						/*	if(empty($validationQuery['attendance_time_out'])) {
								mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_out)
								VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
								print_r($i. " " .$thisrow[2]. " etc insert " .trim($thisrow[6]). " <br />");
							}
							else {
								$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
									AND attendance_time_out = '" .trim($thisrow[6]). "'");
								$Filter = mysql_fetch_array($filterData);
								if($Filter['attendance_time_out'] != trim($thisrow[6])){
									mysql_query("UPDATE tbl_attendance_sheet
										SET attendance_time_in = '" .trim($thisrow[6]). "'
										WHERE emp_id = '" .$row['emp_id']. "'
										AND attendance_time_out LIKE '%" .$getDatetimeNow. "%'");
								print_r($i. " " .$thisrow[2]. " etc update " .trim($thisrow[6]). " <br />");
								}
							}*/
						/*if($currentTime > date('H:i', $inTimeBeg) && $currentTime < date('H:i', $inTimeEnd)) {
							if(empty($validationQuery['attendance_time_in'])) {
								mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_in)
								VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
								print_r($i. " " .$thisrow[2]. " in insert " .trim($thisrow[6]). " <br />");
							}
							else {
								$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
									AND attendance_time_in = '" .trim($thisrow[6]). "'");
								$Filter = mysql_fetch_array($filterData);
								if($Filter['attendance_time_in'] != trim($thisrow[6])){
									mysql_query("UPDATE tbl_attendance_sheet
										SET attendance_time_out = '" .trim($thisrow[6]). "'
										WHERE emp_id = '" .$row['emp_id']. "'
										AND attendance_time_in LIKE '%" .$getDatetimeNow. "%'");
								print_r($i. " " .$thisrow[2]. " in update " .trim($thisrow[6]). " <br />");
								}
							}
						}
						else if($currentTime > date('H:i', $outTimeBeg) && $currentTime < date('H:i', $outTimeEnd)){
							if(empty($validationQuery['attendance_time_out'])) {
								mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_out)
								VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
								print_r($i. " " .$thisrow[2]. " out insert " .trim($thisrow[6]). " <br />");
							}
							else {
								$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
									AND attendance_time_out = '" .trim($thisrow[6]). "'");
								$Filter = mysql_fetch_array($filterData);
								if($Filter['attendance_time_out'] != trim($thisrow[6])){
									mysql_query("UPDATE tbl_attendance_sheet
										SET attendance_time_in = '" .trim($thisrow[6]). "'
										WHERE emp_id = '" .$row['emp_id']. "'
										AND attendance_time_out LIKE '%" .$getDatetimeNow. "%'");
								print_r($i. " " .$thisrow[2]. " out update " .trim($thisrow[6]). " <br />");
								}
							}
						}
						else {
							if(empty($validationQuery['attendance_time_out'])) {
								mysql_query("INSERT INTO tbl_attendance_sheet(emp_id, emp_code, attendance_shift, attendance_time_out)
								VALUES('" .$row['emp_id']. "', '" .$row['emp_code']. "', '" .$row['shiftid']. "', '" .trim($thisrow[6]). "')") or die(mysql_error());
								print_r($i. " " .$thisrow[2]. " etc insert " .trim($thisrow[6]). " <br />");
							}
							else {
								$filterData = mysql_query("SELECT * FROM tbl_attendance_sheet WHERE emp_id = '".$row['emp_id']."'
									AND attendance_time_out = '" .trim($thisrow[6]). "'");
								$Filter = mysql_fetch_array($filterData);
								if($Filter['attendance_time_out'] != trim($thisrow[6])){
									mysql_query("UPDATE tbl_attendance_sheet
										SET attendance_time_in = '" .trim($thisrow[6]). "'
										WHERE emp_id = '" .$row['emp_id']. "'
										AND attendance_time_out LIKE '%" .$getDatetimeNow. "%'");
								print_r($i. " " .$thisrow[2]. " etc update " .trim($thisrow[6]). " <br />");
								}
							}
						}*/
					}
			}
			$tempnum = $thisrow[2];
			$temptime = $getLatestDate[1];
			$val = next ($arrM) ;
		}
	}	
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