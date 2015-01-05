<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><strong>Leave Form</strong></div>
		<form method="post">
			<table border="0" align="center" width="50%">
				<tr>
					<td width="50%"></td><td width="50%"></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<input type="hidden" name="emp_code"/>
					<td>Employee Name:</td>
					<td><input class="form-control" type="text" name="employee_name" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Date Filed:</td>
					<td><input class="form-control" type="text" name="datefiled" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Beginning Date of Leave:</td>
					<td><input class="form-control" type="text" name="begindate" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Ending Date of Leave:</td>
					<td><input class="form-control" type="text" name="enddate" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>No of days of leave:</td>
					<td><input class="form-control" type="text" name="numleave" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td></td>
					<td><input type="radio" value="1" name="leavepay" id="withpay" /> with pay&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="leavepay" id="withoutpay" checked /> without pay</td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Reason</td>
					<td><textarea class="form-control" name="emp_reason" style="resize:none;" required></textarea></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Type of Leave: </td>
					<td>
						<select class="form-control" name="emp_type">
							<option value="Vacation">Vacation</option>
							<option value="Sick">Sick</option>
							<option value="Emergency">Emergency</option>
							<option value="Bereavement">Bereavement</option>
							<option value="Terminal">Terminal</option>
							<option value="Birthday">Birthday</option>
							<option value="Maternity">Maternity</option>
							<option value="Paternity">Paternity</option>
							<!--<option value="Others">Others</option>
						</select><br /><input type="text" class="form-control" name="otherleavetype" style="display:none" />-->
					</td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Remark</td>
					<td><textarea class="form-control" name="emp_remark" style="resize:none;"></textarea></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td></td>
					<td>
						<input type="radio" name="emp_approval" value="1" checked /> Approved <br />
						<input type="radio" name="emp_approval" value="0" /> Denied <br />
						<input type="radio" name="emp_approval" value="2" /> Pending
					</td>
				</tr>
				<tr><td><br /></td></tr>
			</table>
			<br /><br />
			<div class=" panel-footer">
				<p class=" text-center">
					<a href="<?php echo base_url(); ?>admin/admin_leave_cpanel" id="closebutton" class="btn btn-warning btn-lg">Cancel</a>&nbsp;
					<input type="submit" name="action[createleaveform]" class="btn btn-danger btn-lg" value="Submit"/>
				</p>
			</div>
		</form>
	</div><div id="notification" style="display:none"><?php if(isset($this->session->userdata['flash:new:notification'])){echo $this->session->userdata['flash:new:notification'];} ?></div>
</div>


<script>
	$(document).ready(function(){
		
		var emp_code = $('input[name=emp_code]');
		var employee_name = $('input[name=employee_name]');
		var begindate = $('input[name=begindate]');
		var enddate = $('input[name=enddate]');
		var numleave = $('input[name=numleave]');
		var datefiled = $('input[name=datefiled]');
		var emp_reason = $('textarea[name=emp_reason]');
		var emp_remark = $('textarea[name=emp_remark]');
		var notification = $('#notification');
		var notice = notification.html();
		
		var eData = {};
		eData.name = <?php if(isset($jsonSuggestion)){echo $jsonSuggestion;}else{echo '""';} ?>;
		
		employee_name.jsonSuggest({
			data:eData.name, 
			minCharacters: 2,
			onSelect: function(item){
				emp_code.val(item.emp_code);
			}
		});

		if(notice){
			alertify(notice, 'Notification');
		}

		//===============Input limits=================//
		employee_name.alpha();
		datefiled.numeric({allow:' /:amp'});
		begindate.numeric({allow:'/'});
		enddate.numeric({allow:'/'});
		emp_reason.alphanumeric({allow:' .'});
		emp_remark.alphanumeric({allow:' .'});
		numleave.numeric();
		
		
		begindate.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		enddate.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		datefiled.datetimepicker({
			timeFormat: "hh:mm tt",
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