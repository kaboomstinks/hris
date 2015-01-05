<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="companycontainer" style="width:925px;float:right;margin-top:100px">
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td><span data-field="company_name" data-sort="ASC" style="cursor:pointer;">Company</span></td>
					<td><span data-field="company_abbr" data-sort="ASC" style="cursor:pointer;">Abbreviation</span></td>
					<td align="center" colspan="2">Actions</td>
				</tr>
			</thead>
			<tbody id="companytable">
				<?php foreach ($companies as $c) {  ?>
					<tr id='<?php echo $c['id']; ?>' >
						<td><?php echo $c['company_name']; ?></td>	
						<td><?php echo $c['company_abbr']; ?></td>
						<td colspan="2" align="center"><a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div>
			<span style="float:right; margin-top:19px;"><button id="add_company" class="btn btn-primary">New</button></span>
		</div>
	</div>
	
	<div class="modal fade" id="addcompany_modal">
	  <div class="modal-dialog"  style="width:280px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">Add Company</h3>
			<input type="hidden" name="errorVal" value="0">
		  </div>
		  <div class="modal-body">
		  <form id="addcompany_form">
		  	<input type="hidden" name="savemode" value="" />
		  	<input type="hidden" name="recID" value="" />
			<input style="width:250px" type="text" name="company_name" class="form-control" placeholder="Company Name" /><br />
			<input style="width:250px" type="text" name="company_abbr" class="form-control" placeholder="Company Abbreviation" /><br />
		  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" id="companysave">Save</button>
		  </div>
		</div>
	  </div>
	 </div>
</div>

<script>
	$(document).ready(function(){
		
		var company_name = $('input[name=company_name]');
		var company_abbr = $('input[name=company_abbr]');
		var errorVal = $('input[name=errorVal]');
		var addcompany_modal = $('#addcompany_modal');
		var savemode = $('input[name=savemode]');
		var recID = $('input[name=recID]');
		var companysave = $('#companysave');
		var modal_title = $('.modal-title');
		
		
		//============Input Limits================//
		
		company_name.alpha({allow:' ./'});
		company_abbr.alpha({allow:' .'});

		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');	

		$('#add_company').click(function(){
			addcompany_modal.modal('show');
			savemode.val(0);
			clearValues();
			modal_title.text('Add Company');
		});

		function validatecompany(){
			var valid = true;
			var error = '';
			
			if($.trim(company_name.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter company name' + '<br />';
			}
			
			if($.trim(company_abbr.val()) == ''){
				valid = false;
				errorVal.val(1);
				error += 'Enter company abbreviation' + '<br />';
			}
			
			if(error != ''){
				alertify(error, 'Error');
			}
			
			return valid;
		}

		function clearValues(){
			company_name.val('');
			company_abbr.val('');
		}

		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	

		$('.editlink').click(function(){
			var id = $(this).parent().parent().attr('id');
			modal_title.text('Edit Company');
			recID.val(id);
			savemode.val(1);

			$.ajax({
				url: ADMIN_URI + 'admin/edit_company',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					company_name.val(data.company_name);
					company_abbr.val(data.company_abbr);
					addcompany_modal.modal('show');
				}

			});
		});

		$('.deletelink').click(function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to delete this company?");

			if(x){
				$.ajax({
					url: ADMIN_URI + 'admin/delete_company',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		companysave.click(function(){
			
			if(validatecompany()){
				var data = $('#addcompany_form').serialize();
				var url;

				if(savemode.val() == 1){
					url = ADMIN_URI + 'admin/update_company';
				} else {
					url = ADMIN_URI + 'admin/add_company';
				}

				$.ajax({
					url: url,
					type: 'post',
					data: data,
					dataType: 'json',
					beforeSend: function(){
						companysave.text('Saving...');
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
						companysave.text('Save');
					}
				});
			} 

		});	
});
</script>