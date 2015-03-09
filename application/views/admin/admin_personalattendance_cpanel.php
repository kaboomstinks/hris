 <div style="width:1100px;margin:auto auto">
	<div style="width: 180px;margin-right: -5px;float:left;border-radius:5px;font-size:12px;padding: 10px 5px;margin-top:100px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="userscontainer" style="width:900px;float:right;margin-top:100px">
			<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'admin_personalattendance_cpanel' ? '': 'Daily Attendance Record');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<span style="font-size:25px">DAILY ATTENDANCE RECORD PERSONAL</span><hr />
				
		Select: Employee Name:<input style="width:150px;display:inline;" type="text" class="form-control" name="employee_name" /><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		Date Range <input style="width:150px;display:inline;" type="text" name="beginsched" class="form-control beginsched">
		~ <input style="width:150px;display:inline;" type="text" name="endsched" class="form-control">
		<a href="admin_allattendance_cpanel" target="_self" class="btn btn-default" style="margin-top:-3px">View All</a><br></br>
		Code    <input style="width:150px;display:inline;" type="text" class="form-control" value="<?php echo $personalinfo[0]['emp_code']?>" readonly>&nbsp;&nbsp;
				<input type="hidden" name="emp_codes" value="">
		Name    <input style="width:150px;display:inline;" type="text" class="form-control" value="<?php echo $personalinfo[0]['firstname'],' ',$personalinfo[0]['lastname'];?>" readonly>&nbsp;&nbsp;
		Company <input style="width:150px;display:inline;" type="text" class="form-control" value="<?php echo $personalinfo[0]['company_name']?>" readonly>&nbsp;&nbsp;
		Group   <input style="width:150px;display:inline;" type="text" class="form-control" value="<?php  echo $personalinfo[0]['dep_name'] ?>" readonly><hr /><br />
		<table class="table">
			<thead>
				<tr style="font-weight:bold">
					<td width="118px">DATE</td>
					<td width="118px">SHIFT</td>
					<td width="100px">START</td>
					<td width="115px">END</td>
					<td width="80px">Time In</td>
					<td width="80px">Time Out</td>
				</tr>
			</thead>
		</table>
		
		<div style="height:500px;overflow:scroll">			
			<table class="table table-striped">
				
				<tbody id="personalattendance_tbody">
	
					<?php
					
						foreach($personalattendance_table as $key => $p){
					//=================DATE ==========//
						$date =$p['datetime_in'];
						$mydate = strtoTime($date);
						 $created_date = date('F d, Y', $mydate);
						
						$date =$p['datetime_out'];
						$mydate = strtoTime($date);
						$create_date_nologin = date('F d, Y', $mydate);
						//If the user forgot to login the date timeout will be save	 
						$date_condition = empty($created_date)?$create_date_nologin:$created_date;
						
					//=================================//
					
							$fullname = $p['firstname'].' '.$p['lastname'];
							$shift_start = '08:00';
							$shift_end = '17:00';
							$shift_word = 'AM';
							
							
							if($p['shift'] == 2) {
								$shift_start = '16:00';
								$shift_end = '01:00';	
								$shift_word = 'PM';
							}

							if($p['shift'] == 3) {
								$shift_start = '09:00';
								$shift_end = '18:00';	
								$shift_word = 'Mid';
							} 		
							
							if($p['datetime_in'] == ''){
								$time_in = '';
							} else {
								$time_in = date('H:i', strtotime($p['datetime_in']));	
							}
							
							if($p['datetime_out'] == ''){
								$time_out = '';
							} else {
								$time_out = date('H:i', strtotime($p['datetime_out']));
							}
							
							
							echo "<tr>";
							echo "<td width='113px'>$date_condition</td>";
							echo "<td width='118px'>$shift_word</td>";
							echo "<td width='95px'>$shift_start</td>";
							echo "<td width='115px'>$shift_end</td>";
							echo "<td width='80px'>$time_in</td>";
							echo "<td width='60px'>$time_out</td>";
							echo "</tr>";
						}
					
					
					
					
					?>
				
				
				</tbody>
			</table>
			
		</div>
		<span style="padding:50px"></span>
	</div>
<script>

	$(document).ready(function(){
		var employee_c = "<?php echo $personalinfo[0]['emp_code']?>";
		var emp_code = $('input[name=emp_codes]');
		var employee_name = $('input[name=employee_name]');
		var beginsched = $('input[name=beginsched]');
		var endsched = $('input[name=endsched]');
		var datefiled = $('input[name=datefiled]');
		var personalattendance_tbody = $('#personalattendance_tbody');
		var notification = $('#notification');
		var notice = notification.html();
			
		var eData = {};
		eData.name = <?php if(isset($jsonSuggestion)){echo $jsonSuggestion;}else{echo '""';} ?>;
		
		employee_name.jsonSuggest({
			data:eData.name, 
			minCharacters: 2,
			onSelect: function(item){
				emp_code.val(item.emp_code);
				window.location.href = 'admin_personalattendance_cpanel?emp_code=' +item.emp_code;

			}
		});
		
		if(notice){
			alertify(notice, 'Notification');
		}

		//===============Input limits=================//
		employee_name.alpha();
		datefiled.numeric({allow:' /:amp'});
		beginsched.numeric({allow:'/:amp'});
		
		beginsched.datepicker({
		//	timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy",
			onSelect: function(){
			//console.log(employee_c);
				var begindate = $(this).val();
			
				$.ajax({
					  type: "post",
					  url: ADMIN_URI + 'admin/viewby_date',
					  data: {'begindate' : begindate , 'employee_c' : employee_c},
					  datatype: "json",
					  success: function(data){
						  
						  data = JSON.parse(data);
						 personalattendance_tbody.html(data.html);
						
					  }
				});  
			
				
			}
				
	
		});
		
		endsched.datepicker({
			//timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy",
			
				onSelect: function(){
			//console.log(employee_c);
			   var begindate = beginsched.val();
				var endsched = $(this).val();
			//console.log(begindate,endsched);
				$.ajax({
					  type: "post",
					  url: ADMIN_URI + 'admin/viewby_date',
					  data: {'endsched' : endsched ,'begindate' : begindate , 'employee_c' : employee_c},
					  datatype: "json",
					  success: function(data){
						  data = JSON.parse(data);
						 personalattendance_tbody.html(data.html);
						
					  }
				});  
			
				
			}
			
			
			
		});
		
		datefiled.datetimepicker({
			//timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		$('#closebutton').click(function(){
			window.close();
		});

		employee_name.focus();
	
		$('input').keypress(function(key){
			if(key.keyCode == 13){
				return false;
			}
		});
		
		

		
	});
	</script>
