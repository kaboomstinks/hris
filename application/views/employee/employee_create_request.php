<div id="wrapper" style="width:600px;margin:130px auto">
	<div class="page-header" align="center"><h3>Create Explanation / Request Form</h3></div>
		<form method="post">
			<table border="0" align="center" width="50%" class="table table-striped table-hover">
				<tr>
					<td width="50%">Employee's Code : </td>
					<td width="50%"><?php if(isSet($usersession)) {Echo $usersession;} ?></td>
				</tr>
					<tr><td><br /></td><td><br /></td></tr>
				<tr>
					<td>Date Filed : </td>
					<td><input class="form-control" name="datefiled" required /></td>
				</tr>
					<tr><td><br /></td><td><br /></td></tr>
				<tr>
					<td>Purpose : </td>
					<td>
						<input type="radio" name="emp_purpose" value="0" checked /> Under Time
						<br />
						<input type="radio" name="emp_purpose" value="2" /> Non Punching
					</td>
				</tr>
				<tr><td><br /></td><td><br /></td></tr>
				<tr>
					<td>Reason : </td>
					<td><textarea class="form-control" name="emp_reason" style="resize:none;" rows="3"></textarea></td>
				</tr>
			</table>
			<br />
			<div>
				<p class=" text-center">
	           		<input type="submit" name="action[create_request]" class="btn btn-danger btn-lg" value="Submit"/>
				</p>
			</div>
		</form>
</div>

<script>
	
	var emp_code = $('input[name=emp_code]');
	var emp_reason = $('textarea[name=emp_reason]');
	var emp_remark = $('textarea[name=emp_remark]');
	var datefiled = $('input[name=datefiled]');
		
		
	$('input[name=datefiled]').datetimepicker({
		timeFormat: 'hh:mm tt'
	});
	
	emp_code.alphanumeric();
	datefiled.numeric({allow:' /:amp'});
	emp_reason.alphanumeric({allow:' .'});
	emp_remark.alphanumeric({allow:' .'});
		
		
</script>