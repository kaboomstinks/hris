<div class="col-md-8 col-md-offset-2" style="margin-top:120px">
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><strong>Leave Form</strong></div>
		<form method="post">
			<table border="0" align="center" width="50%">
				<tr>
					<td width="50%"></td><td width="50%"></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Employee Code : </td>
					<td><input class="form-control" type="text" name="emp_code" value ="<?php echo $this->session->userdata['usersession'] ?>" readonly /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Date Filed:</td>
					<td><input class="form-control" type="text" name="datefiled" /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Beginning Date of Leave:</td>
					<td><input class="form-control" type="text" name="begindate" /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Ending Date of Leave:</td>
					<td><input class="form-control" type="text" name="enddate" /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Reason</td>
					<td><textarea class="form-control" name="emp_reason" style="resize:none;"></textarea></td>
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
							<option id="ter" value="Terminal">Terminal</option>
							<!--<option value="Others">Others</option>
						</select><br /><input type="text" class="form-control" name="otherleavetype" style="display:none" />-->
					</td>
				</tr>
			</table>
			<br /><br />
			<div class=" panel-footer">
				<p class=" text-center">
					<input type="submit" name="action[create_leave]" class="btn btn-danger btn-lg" value="Submit" />	
				</p>
			</div>
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
		
		var emp_code = $('input[name=emp_code]');
		var begindate = $('input[name=begindate]');
		var enddate = $('input[name=enddate]');
		var datefiled = $('input[name=datefiled]');
		var emp_reason = $('textarea[name=emp_reason]');
		var emp_remark = $('textarea[name=emp_remark]');
		
		//===============Input limits=================//
		emp_code.alphanumeric();
		datefiled.numeric({allow:' /:amp'});
		begindate.numeric({allow:' /:amp'});
		enddate.numeric({allow:' /:amp'});
		emp_reason.alphanumeric({allow:' .'});
		emp_remark.alphanumeric({allow:' .'});
		
		
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
	
	});
		
</script>