<div style="width:1100px;margin:auto auto">
	<div style="margin:0 0 50px 984px">
		<span style="position:relative;top:60px;right:120px;">Search:</span>
		<input class="search form-control" type="text" name="search" style="width:180px;position:relative;top:34px;right:65px;">
	</div>
	<div style="width:150px;margin-right:25px;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div style="width:925px;float:right">
		<ul id="leavestatus" class="nav nav-tabs">
			<li id="li_approved" class="active"><a data-toggle="tab" href="#Approved">Approved</a></li>
			<li id="li_denied"><a data-toggle="tab" href="#Denied">Denied</a></li>
			<li id="li_pending"><a data-toggle="tab" href="#Pending">Pending</a></li>
		</ul>
		<div class="tab-content" style="margin-top:-20px">
			<table class="table table-striped" style="margin-top:50px">
				<thead>
					<tr id="navigationfield" style="font-weight:bold" id="1">
						<td width="90px"><span data-field="company" data-sort="ASC">Company</span></td>
						<td width="90px"><span data-field="department" data-sort="ASC">Department</span></td>
						<td width="90px"><span data-field="position" data-sort="ASC">Position</span></td>
						<td width="90px"><span data-field="emp_code" data-sort="ASC">Employee Code</span></td>
						<td width="90px"><span data-field="firstname" data-sort="ASC" style="cursor:pointer">Name</span></td>
						<td width="90px"><span data-field="type" data-sort="ASC">Type of Leave</span></td>
						<td width="90px"><span data-field="date_from" data-sort="ASC" style="cursor:pointer">Start</span></td>
						<td width="90px"><span data-field="date_to" data-sort="ASC">End</span></td>
						<td colspan="2" align="center">Actions</td>
					</tr>
				</thead>
				<tbody id="leavetable">
				<?php if (!empty($leavetable)) { ?>
					<?php foreach ($leavetable as $key => $leave) { ?>
						<tr id='<?php echo $leave->lid; ?>' >
							<td width="80px">
								<?php
								if ($leave->company == '1') 
								{
									echo 'Circus Co. Ltd (Philippine Branch)';
								}
								elseif ($leave->company == '2') 
								{
									echo 'Tavolozza';
								}else
								{
									echo 'HalloHallo Inc.';
								}?>
							</td>
							<td width="80px"><?php echo $leave->dep_name; ?></td>
							<td width="80px"><?php echo $leave->position; ?></td>
							<td width="80px"><?php echo $leave->emp_code; ?></td>
							<td width="80px"><?php echo $leave->firstname.' '.$leave->middlename.' '.$leave->lastname; ?></td>
							<td width="80px"><?php echo $leave->type; ?></td>
							<td width="80px"><?php echo $leave->date_from; ?></td>
							<td width="80px"><?php echo $leave->date_to; ?></td>
							<td colspan="2" align="center">
								<a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
							</td>
						</tr>
				<?php } }?>
				</tbody>
			</table>
			<!--span id="links"><?php  $links; ?></span> Temporarily removed -->
			<span style="float:right; margin-top:19px;"><a href="<?php echo base_url(); ?>admin/admin_leaveform" class="printpdf btn btn-primary">New</a></span>
		</div>
	</div>
</div>

<div class="modal fade" id="editleave">
	<div class="modal-dialog"  style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
		<form id="leaveform_modal">
			<table border="0" align="center" width="50%">
				<tr>
					<td width="50%"></td><td width="50%"></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<input type="hidden" name="recID" value="" />
					<input type="hidden" name="emp_id" value="" />
					<input type="hidden" name="emp_code" />
					<td>Employee Name:</td>
					<td><input class="form-control" type="text" name="employee_name" /></td>
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
					<td>No of days of leave:</td>
					<td><input class="form-control" type="text" name="numleave" /></td>
				</tr>
				<tr><td><br /></td></tr>
				<tr>
					<td></td>
					<td><input type="radio" value="1" name="leavepay" id="withpay"> with pay&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="leavepay" id="withoutpay"> without pay</td>
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
							<option id="vac" value="Vacation">Vacation</option>
							<option id="sic" value="Sick">Sick</option>
							<option id="eme" value="Emergency">Emergency</option>
							<option id="ber" value="Bereavement">Bereavement</option>
							<option id="ter" value="Terminal">Terminal</option>
							<option id="bir" value="Birthday">Birthday</option>
							<option id="mat" value="Maternity">Maternity</option>
							<option id="pat" value="Paternity">Paternity</option>
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
						<input id="approved" type="radio" name="emp_approval" value="1" checked /> Approved <br />
						<input id="denied" type="radio" name="emp_approval" value="0" /> Denied <br />
						<input id="pending" type="radio" name="emp_approval" value="2" /> Pending
					</td>
				</tr>
				<tr><td><br /></td></tr>
			</table>
			<br /><br />
			<div class=" panel-footer">
				<p class=" text-center">
					<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button> &nbsp;
					<a class="btn btn-danger btn-lg" id="updateleave">Save Changes</a>
				</p>
			</div>
		</form>
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function(){

		var employee_name = $('input[name=employee_name]');
		var emp_code = $('input[name=emp_code]');
		var emp_id = $('input[name=emp_id]');
		var begindate = $('input[name=begindate]');
		var enddate = $('input[name=enddate]');
		var datefiled = $('input[name=datefiled]');
		var numleave = $('input[name=numleave]');
		var emp_reason = $('textarea[name=emp_reason]');
		var emp_type = $('textarea[name=emp_type]');
		var emp_remark = $('textarea[name=emp_remark]');
		var recID = $('input[name=recID]');
		var editleave = $('#editleave');
		var updateleave = $('#updateleave');
		var searchinput = $('.search');
		var eData = {};
		eData.name = <?php if(isset($jsonSuggestion)){echo $jsonSuggestion;}else{echo '""';} ?>;

		employee_name.jsonSuggest({
			data:eData.name, 
			minCharacters: 2,
			onSelect: function(item){
				emp_code.val(item.emp_code);
				emp_id.val(item.id);
			}
		});

		employee_name.focus(function(){
			$('.jsonSuggest').css('width','190px');
		});


		//===================Input Limits======================//
		
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
		
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');

		$('#updateleave').click(function(){
			var data = $('#leaveform_modal').serialize();
			
			$.ajax({
				url: ADMIN_URI +'admin/update_leave',
				type: 'post',
				data: data,
				dataType: 'json',
				success: function(data){
					if(data.success == 1){
						alertify('Update Successful', 'Notification');
					}
				},
				beforeSend: function(){
					updateleave.text('Saving...');
				},
				complete: function(){
					editleave.modal('hide');
					updateleave.text('Save Changes');
				}
			});
		});

		$('#okButton').click(function(){
			location.reload();
		});

		$('body').on('click', '.editlink', function(){
			var id = $(this).parent().parent().attr('id');
			recID.val(id);
			
			$.ajax({
				url: ADMIN_URI + 'admin/edit_leave',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					employee_name.val(data.fullname);
					emp_id.val(data.emp_id);
					emp_code.val(data.emp_code);
					emp_reason.val(data.reason);
					emp_remark.val(data.remark);
					datefiled.val(data.date_filed);
					begindate.val(data.date_from);
					enddate.val(data.date_to);
					numleave.val(data.numleave);

					if(data.status == 1){
						$('#approve').attr('checked','checked');	
					}else if(data.status == 0){
						$('#denied').attr('checked','checked');	
					}else {
						$('#pending').attr('checked','checked');	
					}

					if(data.leavepay == 1){
						$('#withpay').attr('checked','checked');
					} else {
						$('#withoutpay').attr('checked','checked');
					}
					
					if(data.type == 'Vacation'){
						$('#vac').attr('selected','selected');	
					}else if(data.type == 'Sick'){
						$('#sic').attr('selected','selected');
					}else if(data.type == 'Emergency'){
						$('#eme').attr('selected','selected');
					}else if(data.type == 'Terminal'){
						$('#ter').attr('selected','selected');
					}else if(data.type == 'Bereavement'){
						$('#ber').attr('selected','selected');
					}else if(data.type == 'Maternity'){
						$('#mat').attr('selected','selected');
					}else if(data.type == 'Paternity'){
						$('#pat').attr('selected','selected');
					}else {
						$('#bir').attr('selected','selected');
					}
					editleave.modal('show');
				}
			});
		});
		
		$('body').on('click', '.deletelink', function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to Delete?");
			if(x) {
				$.ajax({
					url: 'delete_leave',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		/*searchinput.keyup(function(){
			var a = $(this).val();
			var fieldname = $('#navigationfield td span').attr('id');
			var sort = $('#navigationfield td span').attr('class');
			var x;

			if($('#li_approved').hasClass('active')){
				x = 1;
			} 
			
			if($('#li_denied').hasClass('active')) {
				x = 0;
			}
			
			if($('#li_pending').hasClass('active')) {
				x = 2;
			}
			
			var s = '?fieldname=' + fieldname + '&search=' + a + '&sort=' + sort + '&status=' + x;
			showRequest(s);
		});*/

		searchinput.keyup(function(){
			var search = $(this).val();
			var fieldname = $("thead span").attr('data-field');
			var sort = $("thead span").attr('data-sort');

			var status;
			if($('#li_denied').hasClass('active')) { status = 0; }
				if($('#li_approved').hasClass('active')){ status = 1; } 
					if($('#li_pending').hasClass('active')) { status = 2; }
			
			$.ajax({
				url: 'admin_leave_cpanel',
				type: 'post',
				data: {'search': search, 'fieldname': fieldname, 'sort': sort, 'status': status},
				success: function(data){
					$('#leavetable').html(data);
				}
			});

			/*var row_num = $("#numrow").val();

			console.log(row_num);
		    if (row_num <= 5 || row_num == undefined) { $('#links').css('display', 'none'); }
		    	else{ $('#links').css('display', 'block'); };

			if ($(this).val() == '') { $('#links').css('display', 'block'); };*/
		});

		$("thead span").click(function(){
			var search = searchinput.val();
			var fieldname = $(this).attr('data-field');
			var sort = $(this).attr('data-sort')

			if (sort == "ASC") { $(this).attr('data-sort', 'DESC') }
			else{ $(this).attr('data-sort', 'ASC') };

			var status;
			if($('#li_denied').hasClass('active')) { status = 0; }
			if($('#li_approved').hasClass('active')){ status = 1; } 
			if($('#li_pending').hasClass('active')) { status = 2; }

			if(fieldname == 'firstname' || fieldname == 'date_from'){
				$.ajax({
					url: 'admin_leave_cpanel',
					type: 'post',
					data: {'search': search, 'fieldname': fieldname, 'sort': sort, 'status': status},
					success: function(data){
						$('#leavetable').html(data);
					}
				});
			}
			
	    });


	    $("#leavestatus li").click(function(){
	    	var search = searchinput.val();
	    	var fieldname = $("thead span").attr('data-field');
			var sort = $("thead span").attr('data-sort');
			var i = $(this).attr('id');
	    	var status;

	    	if(i == "li_denied"){ status = 0; }
			if(i == "li_approved"){ status = 1; } 
			if(i == "li_pending"){ status = 2; }

			if (sort == "ASC") { $(this).attr('data-sort', 'DESC') }
				else{ $(this).attr('data-sort', 'ASC') };

			$.ajax({
				url: ADMIN_URI + 'admin/admin_leave_cpanel',
				type: 'post',
				data: {'search': search, 'fieldname': fieldname, 'sort': sort, 'status': status},
				success: function(data){
					$('#leavetable').html(data);
				}
			});
	    });
		
		
		$('span').on('click', function(){
			var i = $(this);
			var id = i.attr('id');
			var searchtext = searchinput.val();

			if(i.hasClass('ASC')){
				i.removeClass('ASC').addClass('DESC')
			} else {
				i.removeClass('DESC').addClass('ASC')
			}
			
			
			var x;
			if($('#li_approved').hasClass('active')){
				x = 1;
			} 
			if($('#li_denied').hasClass('active')) {
				x = 0;
			}
			if($('#li_pending').hasClass('active')) {
				x = 2;
			}
			var sort = i.attr('class');
			var geturl = '?fieldname=' + id + '&search=' + searchtext + '&sort=' + sort + '&status=' + x ;

			//showRequest(geturl);

		});
	});

	
</script>
