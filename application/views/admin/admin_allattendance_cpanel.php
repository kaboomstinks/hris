<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	
	<div id="allattendancecontainer" style="width:925px;float:right;margin-top:100px">
			<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'admin_allattendance_cpanel' ? '': 'View Attendance Record');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<p><span style="font-size:25px">VIEW ATTENDANCE RECORDS</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="position:relative;top:-4px" type="button" class="btn btn-primary" id="go">GO</button></p><hr /><br />
		DATE:&nbsp;&nbsp;<input style="width:100px;display:inline" type"text" class="form-control" name="viewby_date" />&nbsp;&nbsp;&nbsp;&nbsp;

		COMPANY:&nbsp;&nbsp;
		<select style="width:250px;display:inline" type"text" class="form-control" name="viewby_company">
			<option value="0">Select Company</option>
				<?php if(!empty($companies)) {
					foreach ($companies as $key => $c) { ?>
						<option value="<?php echo $c['id']?>"><?php echo $c['company_name']; ?></option>
				<?php } }?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;

		GROUP:&nbsp;&nbsp;
		<select disabled="disabled" class="form-control" name="viewby_dep" style="width:250px;display:inline">
    		<option value="0">Select Department</option>
    	
        	<?php if (!empty($departments)){
        	
        		foreach ($departments as $key => $d) {
        			$department_name = $d['dep_name']; 
        			$dep_id = $d['id'];
        			$c_id = $d['company_id'];

					echo "<option class=$c_id value=$dep_id>$department_name</option>";
        		}
        	} ?>
    	</select><br /><hr />
		
		<table class="table">
			<thead>
				<tr style="font-weight:bold">
					<td width="100px">Code</td>
					<td width="175px">Name</td>
					<td width="100px">Company</td>
					<td width="50px">Shift</td>
					<td width="90px">Start</td>
					<td width="90px">End</td>
					<td width="90px">Time-In</td>
					<td width="90px">Time-Out</td>
					<td>Action</td>
				</tr>
			</thead>
		</table>
		
    	<div style="height:450px;overflow:scroll">
	    	<table class="table table-striped">
	    		<tbody id="allattendance_tbody">
	    		
					<?php
						if(!empty($bio_allattendance_data)){
							foreach($bio_allattendance_data as $key => $b){
							
								$fullname = $b['firstname'].' '.$b['lastname'];
								$emp_code = $b['emp_code'];
								$dep_abbr = $b['dep_abbr'];
								$shift_start = '08:00';
								$shift_end = '17:00';
								$shift_word = 'AM';
								
								
								if($b['shift'] == 2) {
									$shift_start = '16:00';
									$shift_end = '01:00';	
									$shift_word = 'PM';
								}

								if($b['shift'] == 3) {
									$shift_start = '09:00';
									$shift_end = '18:00';	
									$shift_word = 'Mid';
								} 		
								
								if($b['datetime_in'] == ''){
									$time_in = '';
								} else {
									$time_in = date('H:i', strtotime($b['datetime_in']));	
								}
								
								if($b['datetime_out'] == ''){
									$time_out = '';
								} else {
									$time_out = date('H:i', strtotime($b['datetime_out']));
								}
								
								
								
								echo "<tr>";
								echo "<td width='100px'>$emp_code</td>";
								echo "<td width='175px'>$fullname</td>";
								echo "<td width='100px'>$dep_abbr</td>";
								echo "<td width='50px'>$shift_word</td>";
								echo "<td width='90px'>$shift_start</td>";
								echo "<td width='90px'>$shift_end</td>";
								echo "<td width='90px'>$time_in</td>";
								echo "<td width='90px'>$time_out</td>";
								echo "<td><a href=admin_personalattendance_cpanel?emp_code=$emp_code class='btn btn-default'>Personal</a></td>";
								echo "</tr>";
						
						}
						
						
						}
						
					?>
	    		</tbody>
	    	</table>
    	</div>
		<span style="padding:50px"></span>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		var viewby_date = $('input[name=viewby_date]');
		var viewby_company = $('select[name=viewby_company]');
		var viewby_dep = $('select[name=viewby_dep]');
		var allattendance_tbody = $('#allattendance_tbody');
		
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');	
		
		viewby_date.datepicker({						// when date input was changed
			onSelect: function(){
				var date = this.value;
				var company = viewby_company.val();
				var dep = viewby_dep.val();
				
				viewByAjax(date, company, dep);
			}
		});
		
		viewby_company.change(function(){				// when company input was changed
			var date = viewby_date.val();
			var company = $(this).val();
			
+			$('.'+company).show();
+			$('select[name=viewby_dep] option').not('.'+company).hide();    // hide departments that are not covered by a certain company
			viewby_dep.val('');
			
			if(company != 0){
				viewby_dep.prop('disabled', false);
			}else {
				viewby_dep.prop('disabled', true);
			}
			
			var dep = viewby_dep.val();	
				
			viewByAjax(date, company, dep);
		});
		
		viewby_dep.change(function(){					// when departments/group input was changed
			var date = viewby_date.val();
			var company = viewby_company.val();
			var dep = $(this).val();
			
			viewByAjax(date, company, dep);
			
		});
		
		function viewByAjax(date, company, dep){ 		// call to ajax :)
			$.ajax({
				url: ADMIN_URI + 'admin/viewby',
				type: 'post',
				data: 'date=' + date + '&company=' + company + '&dep=' + dep ,
				dataType: 'json',
				success: function(data){
					allattendance_tbody.html(data.html);
				}
			});
		}

		$('#go').click(function(){
		
			$.ajax({
				url: ADMIN_URI + 'generateallrecords.php',
				type: 'post',
				dataType: 'json',
				success : function(data){
				result = data;

					if (data.response == 1){
						window.location.href = 'admin_allattendance_cpanel?file='+ data.filegen;
					} else {
						window.location.href = 'admin_allattendance_cpanel';
					}
					
				}
			
			});
		});
		
	
		


	});

</script>
