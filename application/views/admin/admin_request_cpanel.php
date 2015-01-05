<div style="width:1100px;margin:auto auto">
	<div style="margin:0 0 50px 984px">
		<form action="admin_user_request">
			<span style="position:relative;top:60px;right:120px;">Search:</span><input value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" class="search form-control" type="text" name="search" style="width:180px;position:relative;top:34px;right:65px;">
		</form>
	</div>
	<div style="width:150px;margin-right:25px;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="nonsearchdiv" style="width:925px;float:right;">
		<table class="table table-striped" border="0">
			<thead>
				<tr style="font-weight:bold">
					<td width="105px"><span data-field="company" data-sort="ASC">Company</span></td>
					<td width="105px"><span data-field="department" data-sort="ASC">Department</span></td>
					<td width="105px"><span data-field="position" data-sort="ASC">Position</span></td>
					<td width="105px"><span data-field="tbl_request.emp_code" data-sort="ASC">Employee No.</span></td>
					<td width="105px"><span data-field="firstname"  data-sort="ASC" style="cursor:pointer;">Name</span></td>
					<td width="105px"><span data-field="purpose" data-sort="ASC">Purpose</span></td>
					<td align="center" width="105px"><span data-field="status" data-sort="ASC">Status</span></td>
					<td colspan="2" align="center" width="300">Actions</td>
				</tr>
			</thead>
			<tbody id="request">
			<?php 
			if (!empty($requestable)) {
				foreach ($requestable as $key => $request) { ?>
					<tr id="<?php echo $request->rid; ?>">
						<td>
							<?php
							if ($request->company == '1') 
							{
								echo 'Circus Co. Ltd (Philippine Branch)';
							}
							elseif ($request->company == '2') 
							{
								echo 'Tavolozza';
							}else
							{
								echo 'HalloHallo Inc.';
							}?>
						</td>
						<td><?php
								switch ($request->department) {
                        			case '1':
                        				echo 'Systems Development';
                        				break;
                        			
                        			case '2':
                        				echo 'Web Design';
                        				break;

                        			case '3':
                        				echo 'GA - Human Resources';
                        				break;
                        			
                        			case '4':
                        				echo 'GA - Accounting';
                        				break;

                        			case '5':
                        				echo 'SWAT';
                        				break;
                        			
                        			case '6':
                        				echo 'Graphic Design';
                        				break;

                        			case '7':
                        				echo 'Systems Development';
                        				break;
                        			
                        			case '8':
                        				echo 'Web Design';
                        				break;

                        			case '9':
                        				echo 'Operations';
                        				break;
                        			
                        			case '10':
                        				echo 'Creatives';
                        				break;
                        				
                        			case '11':
                        				echo 'Sales And Marketing';
                        				break;
                        				
                        			case '12':
                        				echo 'Systems Development';
                        				break;
                        		}
							?>
						</td>
						<td><?php echo $request->position; ?></td>
						<td><?php echo $request->emp_code; ?></td>
						<td><?php echo $request->firstname.' '.$request->middlename.' '.$request->lastname; ?></td>
						<td><?php
							switch ($request->purpose) {
								case 0:
									Echo  "Undertime";
									break;
								case 1:
									Echo "Tardiness";
									break;
								case 2:
									Echo "Non Punching";
									break;
							}
						?></td>
						<td align="center">
						<?php
						if($request->status == 0) { Echo "<img src='" .base_url(). "images/common/red_dot.png' width='12px' height='12px' />"; }
							if($request->status == 1) { Echo "<img src='" .base_url(). "images/common/green_dot.png' width='12px' height='12px' />"; }
								if($request->status == 2) { Echo "<img src='" .base_url(). "images/common/blue_dot.png' width='12px' height='12px' />"; }
						?>
						</td>
						<td colspan="2" align="center"><a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a></td>
					</tr>
			<?php } }?>
			</tbody>
		</table>
		<span id="links"><?php echo $links; ?></span>
		<span style="float:right; margin-top:19px;"><a href="<?php echo base_url(); ?>admin/admin_requestform" class="edituser btn btn-primary">New</a></span>
		<br />
		<span>
			<img src='<?php Echo base_url(); ?>images/common/blue_dot.png' width='12px' height='12px' /> Pending &nbsp;&nbsp;&nbsp;
			<img src='<?php Echo base_url(); ?>images/common/green_dot.png' width='12px' height='12px' /> Approved &nbsp;&nbsp;&nbsp;
			<img src='<?php Echo base_url(); ?>images/common/red_dot.png' width='12px' height='12px' /> Denied
		</span>
	</div>
</div>

<!-- POP UP EDIT  -->
<div class="modal fade" id="editrequest">
	<div class="modal-dialog"  style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<form id="requestform_modal">
				<br />
				<br />
					<input type="hidden" name="recID" value="" />
					<table border="0" align="center" width="50%">
						<tr>
							<td width="50%"></td><td width="50%"></td>
						</tr>
						<tr>
							<input name="emp_id" type="hidden" />
							<input name="emp_code" type="hidden" />
							<td>Employee Name:</td>
							<td><input class="form-control" name="employee_name" type="text" required /></td>
						</tr>
							<tr><td><br /></td></tr>
							<tr>
								<td>Date Filed:</td>
								<td><input class="form-control" name="datefiled" type="text" required /></td>
							</tr>
							<tr><td><br /></td></tr>
						<tr>
							<td>Purpose:</td>
							<td align="center">
								<input id="tardy" type="radio" name="emp_purpose" value="1" checked /> Tardiness &nbsp;&nbsp;
								<input id="undertime" type="radio" name="emp_purpose" value="0" /> Under Time &nbsp;&nbsp;
								<input id="nonepunch" type="radio" name="emp_purpose" value="2" /> Non Punching
							</td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>
							<td>Reason:</td>
							<td><textarea class="form-control" name="emp_reason" style="resize:none;"></textarea></td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>
							<td>Remarks:</td>
							<td><textarea class="form-control" name="emp_remark" style="resize:none;"></textarea></td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>
							<td></td>
							<td align="center">
								<input id="approve" type="radio" name="emp_approval" value="1" checked /> Approved&nbsp;&nbsp;&nbsp;
								<input id="disapprove" type="radio" name="emp_approval" value="0" /> Disapproved
							</td>
						</tr>
						<tr><td><br /></td></tr>
					</table>
					<br /><br />
					<div class=" panel-footer">
						<p class=" text-center">
			           		<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button> &nbsp;
							<a class="btn btn-danger btn-lg" id="updaterequest">Save Changes</a>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
	
		var emp_code = $('input[name=emp_code]');
		var emp_id = $('input[name=emp_id]');
		var employee_name = $('input[name=employee_name]');
		var emp_purpose = $('input[name=emp_purpose]');
		var emp_reason = $('textarea[name=emp_reason]');
		var emp_remark = $('textarea[name=emp_remark]');
		var emp_approval = $('input[name=emp_approval]');
		var datefiled = $('input[name=datefiled]');
		var recID = $('input[name=recID]');
		var editrequest = $('#editrequest');
		var updaterequest = $('#updaterequest');
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
		
		//=================Input Limits======================//
		
		
		employee_name.alpha();
		datefiled.numeric({allow:' /:amp'});
		emp_reason.alphanumeric({allow:' .'});
		emp_remark.alphanumeric({allow:' .'});
		
		
		datefiled.datetimepicker({
			timeFormat: "hh:mm tt",
			dateFormat: "mm/dd/yy"
		});

		$('.printpdf').click(function(){
			var id = $(this).parent().parent().attr('id');
			window.open('<?php echo base_url(); ?>admin/admin_forms_reports?id=' + id +'', 'Reply', width=430,height=360);
		});
		
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');

		$('body').on('click', '.deletelink', function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to Delete?");
			if(x) {
				$.ajax({
					url: ADMIN_URI + 'admin/delete_request',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});
		
		$('#updaterequest').click(function(){
			var data = $('#requestform_modal').serialize();
			
			$.ajax({
				url: ADMIN_URI + 'admin/update_request',
				type: 'post',
				data: data,
				dataType: 'json',
				success: function(data){
					if(data.success == 1){
						alertify('Update Successful', 'Notification');
					}
				},
				beforeSend: function(){
					updaterequest.text('Saving...');
				},
				complete: function(){
					editrequest.modal('hide');
					updaterequest.text('Save Changes');
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
				url: ADMIN_URI + 'admin/edit_request',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					emp_id.val(data.emp_id);
					employee_name.val(data.fullname);
					emp_code.val(data.emp_code);
					emp_reason.val(data.reason);
					emp_remark.val(data.remark);
					datefiled.val(data.date_filed);
					
					if(data.status == 1){
						$('#approve').attr('checked','checked');	
					}else if(data.status == 0) {
						$('#disapprove').attr('checked','checked');	
					}else{
						$('#disapprove').attr('checked', false);
						$('#approve').attr('checked', false);
					}
					
					if(data.purpose == 0){
						$('#undertime').attr('checked','checked');	
					}else if(data.purpose == 1){
						$('#tardy').attr('checked','checked');
					}else{
						$('#nonepunch').attr('checked','checked');
					}
					editrequest.modal('show');
				}
			});
		});

		$('.search').keypress(function(){
			var search = $(this).val();
			var fieldname = $(".field").attr('data-field');
		    var sort = $(".field").attr('data-sort')
		    
			$.ajax({
				url: ADMIN_URI + 'admin/admin_user_request',
				type: 'post',
				data: {'search': search, '&fieldname': fieldname, '&sort': sort},
				success: function(data){
					$('#request').html(data);
				}
			});

			var row_num = $("#numrow").val();

		    if (row_num <= 5 || row_num == undefined) {
		    	$('#links').css('display', 'none');
		    }else{
		    	$('#links').css('display', 'block');
		    };

		    if ($(this).val() == '') {
		    	$('#links').css('display', 'block');
		    };

		});


	    $("thead span").click(function(){
	    	var search = $('.search').val();
	        var fieldname = $(this).attr('data-field');
	        var sort = $(this).attr('data-sort')
	        if (sort == "ASC") {
	        	$(this).attr('data-sort', 'DESC')
	        }else{
	        	$(this).attr('data-sort', 'ASC')
	        };

	        if(fieldname == 'firstname'){
	        	 $.ajax({
					url: ADMIN_URI + 'admin/admin_request_cpanel',
					type: 'post',
					data: {'search': search, 'fieldname': fieldname, 'sort': sort},
					success: function(data){
						$('#request').html(data);
					}
				});
	        }
	       
	    });

	    $('#links').on('click', function(){
	    	var s = $('.search').val();

	    	$('.pagination a').each(function(){
	    		var url = $(this).attr('href');

	    		if (s != undefined) {
		    		$(this).attr('href', url+'?search='+s)
	    		};
	    	});
	    })
	});
</script>