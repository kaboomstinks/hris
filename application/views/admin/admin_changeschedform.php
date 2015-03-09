<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><strong>Change Schedule / Offset Form</strong></div>
		<form method="post">
			<table border="0" align="center" width="50%">
				<tr>
					<td width="50%"></td><td width="50%"></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<input type="hidden" name="emp_code"/>
					<td>Employee Name: </td>
					<td><input class="form-control" type="text" name="employee_name" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Date Filed:</td>
					<td><input class="form-control" type="text" name="datefiled" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Beginning New Schedule:</td>
					<td><input class="form-control" type="text" name="beginsched" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Ending New Schedule:</td>
					<td><input class="form-control" type="text" name="endsched" required /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Total of hours:</td>
					<td><input class="form-control" type="text" name="totalhours" readonly /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td>Description:</td>
					<td><textarea rows="4" type="text" name="remarks" class="form-control"></textarea></td>
				</tr><td><br /></td></tr>
				<tr>
					<td></td>
					<td><input type="radio" value="1" name="changetype" id="changesched" checked /> Change of Schedule<br />
					<input type="radio" value="0" name="changetype" id="offset" /> Offset to restday</td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td></td>
					<td>
						<input id="approved" type="radio" name="emp_approval" value="1" checked /> Approved <br />
						<input id="denied" type="radio" name="emp_approval" value="0" /> Denied <br />
					</td>
				</tr>
				<tr><td><br /></td></tr>
			</table>
			<br /><br />
			<div class=" panel-footer">
				<p class=" text-center">
					<a href="<?php echo base_url(); ?>admin/admin_changesched_cpanel" id="closebutton" class="btn btn-warning btn-lg">Cancel</a>&nbsp;
					<input type="submit" name="action[createchangeschedform]" class="btn btn-danger btn-lg" value="Submit"/>
				</p>
			</div>
		</form>
	</div><div id="notification" style="display:none"><?php if(isset($this->session->userdata['flash:new:notification'])){echo $this->session->userdata['flash:new:notification'];} ?></div>
</div>


<script>
	$(document).ready(function(){
		
		var emp_code = $('input[name=emp_code]');
		var employee_name = $('input[name=employee_name]');
		var beginsched = $('input[name=beginsched]');
		var endsched = $('input[name=endsched]');
		var totalhours = $('input[name=totalhours]');
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

		if(notice){
			alertify(notice, 'Notification');
		}

		//===============Input limits=================//
		employee_name.alpha();
		datefiled.numeric({allow:' /:amp'});
		beginsched.numeric({allow:'/:amp'});
		endsched.numeric({allow:'/:amp'});
		totalhours.numeric({allow:'.'});
		
		beginsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		endsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy",
			onSelect: function(){
				var begin = new Date(beginsched.val());
				var end = new Date($(this).val());
				var result = (end - begin) / (3600000);		// divide to that number because the result is in milliseconds (this gets the hour equivalent)
			
				totalhours.val(result); 
			}
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