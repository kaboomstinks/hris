<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><strong>Attendance Form</strong></div>
		<form  method="post"><br />
			<table border="0" align="center" width="50%">
				<tr>
					<td width="50%"></td><td width="50%"></td>
				</tr>
				<tr>
					<input type="hidden" name="emp_code"/>
					<td>Employee Name : </td>
					<td><input class="form-control" type="text" name="employee_name" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Type:</td>
					<td>
						<input type="radio" name="type" value="Late" checked=checked /> Late &nbsp;&nbsp;
						<input type="radio" name="type" value="Absent"/> Absent &nbsp;&nbsp;
						<input type="radio" name="type" value="Awol"/> Awol &nbsp;&nbsp;
					</td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Date of filling:</td>
					<td><input class="form-control" type="text" name="datefiled" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Reason: </td>
					<td><textarea class="form-control" type="text" name="reason"></textarea></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Remark: </td>
					<td><textarea class="form-control" type="text" name="remark"></textarea></td>
				</tr>
				
			</table>
			<br /><br />
			<div class=" panel-footer">
				<p class=" text-center">
					<a href="<?php echo base_url(); ?>admin/admin_attendance_cpanel" id="closebutton" class="btn btn-warning btn-lg">Cancel</a>&nbsp;
					<input type="submit" name="action[createattendance]" class="btn btn-danger btn-lg" value="Submit"/>
				</p>
			</div>
		</form>
	</div><div id="notification" style="display:none"><?php if(isset($this->session->userdata['flash:new:notification'])){echo $this->session->userdata['flash:new:notification'];} ?></div>
</div>

<script type="text/javascript">
$(function(){

	var emp_code = $('input[name=emp_code]');
	var employee_name = $('input[name=employee_name]');
	var emp_reason = $('textarea[name=emp_reason]');
	var emp_remark = $('textarea[name=emp_remark]');
	var datefiled = $('input[name=datefiled]');
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

	employee_name.keydown(function(){
		if($(this).val() == ''){
			emp_code.val('');
		}
	});



	if(notice){
		alertify(notice, 'Notification');
	}

	//===============Input 	limits=================//
	employee_name.alpha();
	datefiled.numeric({allow:' /:amp'});
	emp_reason.alphanumeric({allow:' .'});
	emp_remark.alphanumeric({allow:' .'});

	$('#closebutton').click(function(){
		window.close();
	});

    $('input[name=datefiled]').datetimepicker({
		timeFormat: 'hh:mm tt',
		dateFormat: "mm/dd/yy"
	});

	$('input').keypress(function(key){
		if(key.keyCode == 13){
			return false;
		}
	});

});
</script>

