<div style="width:1100px;margin:auto auto">
	<div style="margin:0 0 50px 984px">
		<span style="position:relative;top:60px;right:120px;">Search:</span>
		<form action="<?php echo base_url(); ?>admin/admin_attendance_cpanel">
			<input class="search form-control" type="text" name="search" style="width:180px;position:relative;top:34px;right:65px;">
			<input id="tab" type="hidden" name="tab" value="<?php echo @$_GET['tab']?>"> 
		</form>
	</div>
	
	<div style="width:150px;margin-right:25px;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div style="width:925px;float:right">
		<ul id="attendancestatus" class="nav nav-tabs">
		<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'ATTENDANCE REPORT' ? '': 'Attendance Report');
						echo ($is_link);
					
					?>
				</li>
            </ol>
			<li id="li_late" class="<?php echo $Late; ?>"><a data-toggle="tab" href="#Late">Late</a></li>
			<li id="li_absent" class="<?php echo $Absent; ?>"><a data-toggle="tab" href="#Absent">Absent</a></li>
			<li id="li_awol" class="<?php echo $Awol; ?>"><a data-toggle="tab" href="#Awol">Awol</a></li>
		</ul>
		<div class="tab-content" style="margin-top:-20px">
			<table class="table table-striped" style="margin-top:50px">
				<thead>
					<tr id="navigationfield" style="font-weight:bold" id="1">
						<td width="102px"><span data-field="company" data-sort="ASC">Company</span></td>
						<td width="102px"><span data-field="department" data-sort="ASC">Department</span></td>
						<td width="102px"><span data-field="position" data-sort="ASC">Position</span></td>
						<td width="102px"><span data-field="emp_code" data-sort="ASC">Employee Code</span></td>
						<td width="102px"><span data-field="date_filed" data-sort="ASC">Date Filed</span></td>
						<td width="102px"><span data-field="firstname" data-sort="ASC">Name</span></td>
						<td width="102px"><span data-field="type" data-sort="ASC">Reason</span></td>
						<td colspan="2" align="center">Actions</td>
					</tr>
				</thead>
				<tbody id="attendancetable">
				<?php if (!empty($attendancetable)) { ?>
					<?php foreach ($attendancetable as $key => $attendance) { ?>
						<tr id='<?php echo $attendance->tda_id; ?>' >
							<td width="80px">
								<?php
								if ($attendance->company == '1') 
								{
									echo 'Circus Co. Ltd (Philippine Branch)';
								}
								elseif ($attendance->company == '2') 
								{
									echo 'Tavolozza';
								}
								else
								{
									echo 'HalloHallo Inc.';
								}?>
							</td>
							<td width="80px"><?php echo $attendance->dep_name; ?></td>
							<td width="80px"><?php echo $attendance->position; ?></td>
							<td width="80px"><?php echo $attendance->emp_code; ?></td>
							<td width="80px"><?php echo date('m/d/Y h:i', $attendance->date_filed); ?></td>
							<td width="80px"><?php echo $attendance->firstname.' '.$attendance->middlename.' '.$attendance->lastname; ?></td>
							<td style="max-width: 80px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap; "><?php echo $attendance->reason; ?></td>
							<td colspan="2" align="center">
								<a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
							</td>
						</tr>
				<?php } }?>
				</tbody>
			</table>
			<span id="links"><?php echo $links; ?></span>
			<span style="float:right; margin-top:19px;"><a href="<?php echo base_url(); ?>admin/admin_attendanceform" class="printpdf btn btn-primary">New</a></span>
		</div>
	</div>
	<!-- Modal -->
	
	
	<div class="modal fade" id="edit_attendance">
	  <div class="modal-dialog" style="width:800px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Edit Attendance</h4>
		  </div>
		  <div class="modal-body">
			<form id="attendanceform_modal">
			<input type="hidden" name="recID" value="" />
				<table border="0" align="center" width="50%">
					<tr>
						<td width="50%"></td><td width="50%"></td>
					</tr>
					<tr>
						<input type="hidden" name="emp_id"/>
						<input type="hidden" name="emp_code"/>
						<td>Employee Name:</td>
						<td><input class="form-control" type="text" name="employee_name" /></td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td>Type:</td>
						<td>
							<input id="late" type="radio" name="type" value="Late" /> Late &nbsp;&nbsp;
							<input id="absent" type="radio" name="type" value="Absent" /> Absent &nbsp;&nbsp;
							<input id="awol" type="radio" name="type" value="Awol" /> Awol &nbsp;&nbsp;
						</td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td>Date of filling:</td>
						<td><input class="form-control" type="text" name="datefiled" /></td>
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
						<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>&nbsp;
						<a class="btn btn-danger btn-lg" id="updateattendance">Save Changes</a>
					</p>
				</div>
			</form>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

<script>
$(document).ready(function(){
	
	var emp_code = $('input[name=emp_code]');
	var emp_id = $('input[name=emp_id]');
	var employee_name = $('input[name=employee_name]');
	var type = $('input[name=type]');
	var reason = $('textarea[name=reason]');
	var remark = $('textarea[name=remark]');
	var recID = $('input[name=recID]');
	var updateattendance = $('#updateattendance');
	var datefiled = $('input[name=datefiled]');
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
	reason.alphanumeric({allow:' .'});
	remark.alphanumeric({allow:' .'});
	
	datefiled.datetimepicker({
		timeFormat: "hh:mm tt",
		dateFormat: "mm/dd/yy"
	});

	$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');


	$('.checkbox').each(function(index, value){
	    if ($(this).val() == '1') {
			$(this).attr('checked', true);
			$(this).siblings('.zero').attr('disabled', true);
		}else {
			$(this).removeAttr('checked');
			$(this).siblings('.zero').removeAttr('disabled');
		};
	});

	$('.checkbox').each(function(index, value){
		$(this).on('click', function(){
			if($(this).is(":checked")) {
				$(this).val('1');
			}else{
				$(this).val('0');
			};

			if ($(this).val() == '1') {
				$(this).attr('checked', true);
				$(this).siblings('.zero').attr('disabled', true);
			}else {
				$(this).removeAttr('checked');
				$(this).siblings('.zero').removeAttr('disabled');
			};

			var data = $(this).parent('#emp_status').serialize();
			$.ajax({
				url: ADMIN_URI + 'admin/update_status',
				type: 'post',
				data: data,
				dataType: 'json'
			});	
		});
	});
	
	$('#updateattendance').click(function(){
		var data = $('#attendanceform_modal').serialize();
		
		$.ajax({
			url: ADMIN_URI + 'admin/update_attendance',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data.success == 1){
					alertify('Update Successful', 'Notification');
				}
			},
			beforeSend: function(){
				updateattendance.text('Saving...');
			},
			complete: function(){
				$('#edit_attendance').modal('hide');
				updateattendance.text('Save Changes');
			}
		});
	});

	$('#okButton').click(function(){
		location.reload();
	});
	
	$('body').on('click', '.deletelink', function(){
		var id = $(this).parent().parent().attr('id');
		var x = confirm("Are you sure you want to Delete?");
		if(x) {
			$.ajax({
				url: ADMIN_URI + 'admin/delete_attendance',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				complete: function(){
					location.reload();
				}
			});
		}
	});
	
	$('body').on('click', '.editlink', function(){
		var id = $(this).parent().parent().attr('id');
		recID.val(id);
	
		$.ajax({
			url: ADMIN_URI + 'admin/edit_attendance',
			type: 'post',
			data: 'id=' + id,
			dataType: 'json',
			success: function(data){
				employee_name.val(data.fullname);
				emp_id.val(data.emp_id);
				emp_code.val(data.emp_code);
				reason.val(data.reason);
				remark.val(data.remark);
				datefiled.val(data.date_filed);
				
				if(data.type == 'Late'){
					$('#late').attr('checked','checked');	
				}else if(data.type == 'Absent'){
					$('#absent').attr('checked','checked');
				}else {
					$('#awol').attr('checked','checked');
				}
				$('#edit_attendance').modal('show');
				
			}
		});
	});

		// $('.search').keyup(function(){
		// 	var search = $(this).val();
		// 	var fieldname = $("thead span").attr('data-field');
		// 	var sort = $("thead span").attr('data-sort');

		// 	var type;
		// 	if($('#li_awol').hasClass('active')){ type = 'Awol'; } 
		// 		if($('#li_late').hasClass('active')) { type = 'Late'; }
		// 			if($('#li_absent').hasClass('active')) { type = 'Absent'; }

		// 	$.ajax({
		// 		url: ADMIN_URI + 'admin/admin_attendance_cpanel',
		// 		type: 'post',
		// 		data: {'search': search, 'fieldname': fieldname, 'sort': sort, 'type': type},
		// 		success: function(data){
		// 			$('#attendancetable').html(data);
		// 		}
		// 	});
		// });

	    $("#attendancestatus li").click(function(){
	    	var search = $('.search').val();
	    	var fieldname = $("thead span").attr('data-field');
			var i = $(this).attr('id');
			var type;
		
			if(i == "li_awol"){ type = 'Awol'; tab='Awol';}
			if(i == "li_absent"){ type = 'Absent'; tab='Absent'; } 
			if(i == "li_late"){ type = 'Late';  tab='Late';}

			$('#tab').val(tab);

			$.ajax({
				url: ADMIN_URI + 'admin/admin_attendance_cpanel',
				type: 'post',
				data: {'search': search, 'fieldname': fieldname, 'type': type,'tab':tab},
				success: function(data){
					$('#attendancetable').html(data.value);
					$('#links').html(data.pagination);
				}
			});
	    });
});
</script>
