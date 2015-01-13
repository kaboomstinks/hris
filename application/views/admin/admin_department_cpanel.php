<style>

::-webkit-input-placeholder { /* WebKit browsers */
	 font-style: italic;
     color: GrayText !important;
}
.form-control option:first-child{
display:none;
}

::-webkit-input-placeholder{
opacity:0.4
}

:-moz-placeholder {
opacity:0.4
}

::-moz-placeholder { 
opacity:0.4 
}

:-ms-input-placeholder {  
opacity:0.4
}

</style>
<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="departmentcontainer" style="width:925px;float:right;margin-top:100px">
	<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'DEPARTMENT' ? '': 'Department');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td><span data-field="department_name" data-sort="ASC" style="cursor:pointer;">Department</span></td>
					<td><span data-field="department_abbr" data-sort="ASC" style="cursor:pointer;">Abbreviation</span></td>
					<td align="center" colspan="2">Actions</td>
				</tr>
			</thead>
			<tbody id="departmenttable">
				<?php foreach ($departments as $d) {  ?>
					<tr id='<?php echo $d['id']; ?>' >
						<td><?php echo $d['dep_name']; ?></td>	
						<td><?php echo $d['dep_abbr']; ?></td>
						<td colspan="2" align="center"><a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div>
			<span id="links" style="float:left;"><?php echo $links; ?></span>
			<span style="float:right; margin-top:19px;"><button id="add_department" class="btn btn-primary">New</button></span>
		</div>
	</div>
	
	<div class="modal fade" id="adddepartment_modal">
	  <div class="modal-dialog" style="width:280px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">Add Department</h3>
			<input type="hidden" name="errorVal" value="0">
		  </div>
		  <div class="modal-body">
		  <form id="adddepartment_form">
		  	<input type="hidden" name="savemode" value="" />
		  	<input type="hidden" name="recID" value="" />
		  	<select class="form-control" name="company_id" style="width:250px">
		  		<option value="1">Circus Co. Ltd (Philippine Branch)</option>
		  		<option value="2">Tavolozza</option>
		  		<option value="3">HalloHallo Inc.</option>
		  	</select><br />
			<input style="width:250px" type="text" name="department_name" class="form-control" placeholder="Department Name" /><br />
			<input style="width:250px" type="text" name="department_abbr" class="form-control" placeholder="Department Abbreviation" /><br />
		  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" id="departmentsave">Save</button>
		  </div>
		</div>
	  </div>
	 </div>
</div>

<script>
	$(document).ready(function(){
		
		var department_name = $('input[name=department_name]');
		var department_abbr = $('input[name=department_abbr]');
		var errorVal = $('input[name=errorVal]');
		var company_id = $('select[name=company_id]');
		var adddepartment_modal = $('#adddepartment_modal');
		var savemode = $('input[name=savemode]');
		var recID = $('input[name=recID]');
		var departmentsave = $('#departmentsave');
		var modal_title = $('.modal-title');
		
		//============Input Limits================//
		
		department_name.alpha({allow:' '});
		department_abbr.alpha({allow:' '});

		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');
		
		$('#add_department').click(function(){
			adddepartment_modal.modal('show');
			savemode.val(0);
			clearValues();
			modal_title.text('Add Department');
		});

		function validatedepartment(){
			var valid = true;
			var error = '';
			
			if($.trim(department_name.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter department name' + '<br />';
			}
			
			if($.trim(department_abbr.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter department abbreviation' + '<br />';
			}
			
			if(error != ''){
				alertify(error, 'Error');
			}
			
			return valid;
		}

		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	


		function clearValues(){
			company_id.val(1);
			department_name.val('');
			department_abbr.val('');
		}

		
		$('.editlink').click(function(){
			var id = $(this).parent().parent().attr('id');
			modal_title.text('Edit Department');
			recID.val(id);
			savemode.val(1);

			$.ajax({
				url: ADMIN_URI + 'admin/edit_department',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					company_id.val(data.company_id);
					department_name.val(data.dep_name);
					department_abbr.val(data.dep_abbr);
					adddepartment_modal.modal('show');
				}
			});
		});

		$('.deletelink').click(function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to delete this department?");

			if(x){
				$.ajax({
					url: ADMIN_URI + 'admin/delete_department',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		departmentsave.click(function(){
			
			if(validatedepartment()){
				var data = $('#adddepartment_form').serialize();
				var url;

				if(savemode.val() == 1){
					url = ADMIN_URI + 'admin/update_department';
				} else {
					url = ADMIN_URI + 'admin/add_department';
				}

				$.ajax({
					url: url,
					type: 'post',
					data: data,
					dataType: 'json',
					beforeSend: function(){
						departmentsave.text('Saving...');
					},
					success: function(data){
						if(data.success == 0){
							errorVal.val(1);
							alertify(data.msg, 'Error');
						} else {
							errorVal.val(0);
							alertify(data.msg, 'Notification');
						}
					},
					complete: function(){
						departmentsave.text('Save');
					}
				});
			} 

		});	
});
</script>