<div style="width:1100px;margin:auto auto">
	<div style="margin:0 0 50px 984px">
	<form action="<?php echo base_url(); ?>admin/admin_changesched_cpanel">
		<span style="position:relative;top:60px;right:120px;">Search:</span>
		<input class="search form-control" type="text" name="search" style="width:180px;position:relative;top:34px;right:65px;">
		<input id="tab" type="hidden" name="tab" value="<?php echo @$_GET['tab']?>">
	</form>
	</div>
	<div style="width:150px;margin-right:25px;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div style="width:925px;float:right">
	<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'CHANGE SCHEDULE' ? '': 'Change Schedule');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<ul id="changestatus" class="nav nav-tabs">
			<li id="li_approved" class="<?php echo $approved; ?>"><a data-toggle="tab" href="#Approved">Approved</a></li>
			<li id="li_denied" class="<?php echo $denied; ?>"><a data-toggle="tab" href="#Denied">Denied</a></li>
			<!-- <li id="li_pending"><a data-toggle="tab" href="#Pending">Pending</a></li> -->
		</ul>
		<div class="tab-content" style="margin-top:-20px">
			<table class="table table-striped" style="margin-top:50px">
				<thead>
					<tr id="navigationfield" style="font-weight:bold" id="1">
						<td width="140px"><span data-field="company" data-sort="ASC">Company</span></td>
						<td width="110x"><span data-field="department" data-sort="ASC">Department</span></td>
						<td width="90px"><span data-field="position" data-sort="ASC">Position</span></td>
						<td width="90px"><span data-field="emp_code" data-sort="ASC">Employee Code</span></td>
						<td width="110px"><span data-field="firstname" data-sort="ASC" style="cursor:pointer">Name</span></td>
						<td width="90px"><span data-field="date_from" data-sort="ASC" style="cursor:pointer">Start</span></td>
						<td width="90px"><span data-field="date_to" data-sort="ASC">End</span></td>
						<td colspan="2" align="center">Actions</td>
					</tr>
				</thead>
				<tbody id="offsettable">


				<?php if (!empty($changeschedtable)) { ?>
					<?php foreach ($changeschedtable as $key => $change) { ?>
						<tr id='<?php echo $change->cid; ?>' >
							<td width="80px">
								<?php
								if ($change->company == '1') 
								{
									echo 'Circus Co. Ltd (Philippine Branch)';
								}
								elseif ($change->company == '2') 
								{
									echo 'Tavolozza';
								}else
								{
									echo 'HalloHallo Inc.';
								}?>
							</td>
							<td width="80px"><?php echo $change->dep_name; ?></td>
							<td><?php echo $change->position; ?></td>
							<td><?php echo $change->emp_code; ?></td>
							<td><?php echo $change->firstname.' '.$change->middlename.' '.$change->lastname; ?></td>
							<td><?php echo $change->date_from; ?></td>
							<td><?php echo $change->date_to; ?></td>
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
			<span style="float:right; margin-top:19px;"><a href="<?php echo base_url(); ?>admin/admin_changeschedform" class="printpdf btn btn-primary">New</a></span>
		</div>
	</div>
</div>

<div class="modal fade" id="editchangesched">
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
							<td>Beginning New Schedule:</td>
							<td><input class="form-control" type="text" name="beginsched" /></td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>
							<td>Ending New Schedule:</td>
							<td><input class="form-control" type="text" name="endsched" /></td>
						</tr>
						<tr><td><br /></td></tr>
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
							<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button> &nbsp;
							<a class="btn btn-danger btn-lg" id="updatechangesched">Save Changes</a>
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
		var beginsched = $('input[name=beginsched]');
		var endsched = $('input[name=endsched]');
		var datefiled = $('input[name=datefiled]');
		var recID = $('input[name=recID]');
		var editchangesched = $('#editchangesched');
		var updatechangesched = $('#updatechangesched');
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
		beginsched.numeric({allow:'/:amp'});
		endsched.numeric({allow:'/:amp'});

		beginsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		endsched.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
		
		datefiled.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});
	
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');

		$('body').on('click', '.editlink', function(){
			var id = $(this).parent().parent().attr('id');
			recID.val(id);
			
			$.ajax({
				url: ADMIN_URI + 'admin/edit_changesched',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					employee_name.val(data.fullname);
					emp_id.val(data.emp_id);
					emp_code.val(data.emp_code);
					datefiled.val(data.date_filed);
					beginsched.val(data.date_from);
					endsched.val(data.date_to);

					if(data.status == 1){
						$('#approve').attr('checked','checked');	
					}else {
						$('#denied').attr('checked','checked');	
					}

					if(data.changetype == 1){
						$('#changesched').attr('checked','checked');	
					}else {
						$('#offset').attr('checked','checked');	
					}
					
					editchangesched.modal('show');
				}
			});
		});

		$('#okButton').click(function(){
			location.reload();
		});

		$('#updatechangesched').click(function(){
			var data = $('#leaveform_modal').serialize();
			
			$.ajax({
				url: ADMIN_URI +'admin/update_changesched',
				type: 'post',
				data: data,
				dataType: 'json',
				success: function(data){
					if(data.success == 1){
						alertify('Update Successful', 'Notification');
					}
				},
				beforeSend: function(){
					updatechangesched.text('Saving...');
				},
				complete: function(){
					editchangesched.modal('hide');
					updatechangesched.text('Save Changes');
				}
			});
		});

		$('body').on('click', '.deletelink', function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to Delete?");
			if(x) {
				$.ajax({
					url: ADMIN_URI + 'admin/delete_changesched',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		 $("#changestatus li").click(function(){
		 	var search = searchinput.val();
	    	var fieldname = $("thead span").attr('data-field');
			var i = $(this).attr('id');
	    	var status;

	    	if(i == "li_denied"){ status = 0;  tab='denied';}
			if(i == "li_approved"){ status = 1; tab='approved';} 
			if(i == "li_pending"){ status = 2;  tab='pending';}
			$('#tab').val(tab);
		

			$.ajax({
				url: ADMIN_URI + 'admin/admin_changesched_cpanel',
				type: 'post',
				data: {'search': search, 'fieldname': fieldname, 'status': status, 'tab': tab},
				success: function(data){
					$('#offsettable').html(data.value);
					$('#links').html(data.pagination);
				}
			});
	    });

		 // $("thead span").click(function(){
			// var search = searchinput.val();
			// var fieldname = $(this).attr('data-field');
			// var sort = $(this).attr('data-sort')

			// if (sort == "ASC") { $(this).attr('data-sort', 'DESC') }
			// else{ $(this).attr('data-sort', 'ASC') };

			// var status;
			// if($('#li_denied').hasClass('active')) { status = 0; }
			// if($('#li_approved').hasClass('active')){ status = 1; } 
			// if($('#li_pending').hasClass('active')) { status = 2; }

			// if(fieldname == 'firstname' || fieldname == 'date_from'){
			// 	$.ajax({
			// 		url: ADMIN_URI + 'admin/admin_changesched_cpanel',
			// 		type: 'post',
			// 		data: {'search': search, 'fieldname': fieldname, 'sort': sort, 'status': status},
			// 		success: function(data){
			// 			$('#offsettable').html(data);
			// 		}
			// 	});
			// }
		
	  //   });


	
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
		});

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

			if ($(this).val() == '') { $('#links').css('display', 'block'); };
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
*/
	});

	
</script>
