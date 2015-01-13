<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div> <!-- End Aside Menu -->
	<div id="benefitcontainer" style="width:925px;float:right;margin-top:100px">
	<ol class="breadcrumb mt040">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">
					<?php
						$link = $_SERVER['REQUEST_URI'];
						$is_link = ($link == 'BENEFITS' ? '': 'Benefits');
						echo ($is_link);
					
					?>
				</li>
            </ol>
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td><span data-field="employee_name" data-sort="ASC" style="cursor:pointer;">Name</span></td>
					<td><span data-field="hmo" data-sort="ASC" style="cursor:pointer;">HMO</span></td>
					<td><span data-field="phone" data-sort="ASC" style="cursor:pointer;">Phone</span></td>
					<td><span data-field="gas" data-sort="ASC" style="cursor:pointer;">Gas</span></td>
					<td><span data-field="travel" data-sort="ASC" style="cursor:pointer;">Travel</span></td>
					<td><span data-field="entertainment" data-sort="ASC" style="cursor:pointer;">Entertainment</span></td>
					<td><span data-field="leaves" data-sort="ASC" style="cursor:pointer;">Leaves</span></td>
					<td align="center" colspan="2">Actions</td>
				</tr>
			</thead>
			<tbody id="benefittable">
				<?php foreach ($benefits as $b) { ?>
					<tr id='<?php echo $b['id']; ?>'>
						<td><?php echo $b['firstname'].' '.$b['lastname']; ?></td>
						<td><?php if($b['hmo'] == '' || $b['hmo'] == 0 ){echo 'none';} else {echo 'yes'; } ?></td>
						<td><?php if($b['phone'] == '' || $b['phone'] == 0 ){echo 'none';} else {echo 'yes'; } ?></td>
						<td><?php if($b['gas'] == '' || $b['gas'] == 0 ){echo 'none';} else {echo 'yes'; } ?></td>
						<td><?php if($b['travel'] == '' || $b['travel'] == 0 ){echo 'none';} else {echo 'yes'; } ?></td>
						<td><?php if($b['entertainment'] == '' || $b['entertainment'] == 0 ){echo 'none';} else {echo 'yes'; } ?></td>
						<td><?php if($b['leaves'] == ''){echo '0';} else {echo $b['leaves']; } ?></td>
						<td colspan="2" align="center"><a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
						</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
		<div>
			<span style="float:right; margin-top:19px;"><button id="add_benefit" class="btn btn-primary">New</button></span>
		</div>
	</div>
	
	<div class="modal fade" id="addbenefit_modal">
	  <div class="modal-dialog"  style="width:280px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" style="font-weight:bold">Add Benefit</h3>
			<input type="hidden" name="errorVal" value="0">
		  </div>
		  <div class="modal-body">
		  <form id="addbenefit_form">
		  	<input type="hidden" name="savemode" value="" />
		  	<input type="hidden" name="recID" value="" />
		  	<input type="hidden" name="employee_id" value="" />
		  	<input type="text" name="employee_name" class="form-control" /><br />
		  	<div class="input-group" style="margin-bottom:10px">
			  <span class="input-group-addon">Leave credits:</span>
			  <input type="text" name="leaves" style="width:70px" class="form-control" />
			</div>
			<span style="margin-right:55px">HMO:</span>&nbsp;&nbsp;<input type="radio" name="hmo" id="y_hmo" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="hmo" id="n_hmo" checked="checked" value="0" />None<br />
			<span style="margin-right:47px">Phone:</span>&nbsp;&nbsp;<input type="radio" name="phone" id="y_phone" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="phone" id="n_phone" checked="checked" value="0" />None<br />
			<span style="margin-right:62px">Gas:</span>&nbsp;&nbsp;<input type="radio" name="gas" id="y_gas" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="gas" id="n_gas" checked="checked" value="0" />None<br />
			<span style="margin-right:48px">Travel:</span>&nbsp;&nbsp;<input type="radio" name="travel" id="y_travel" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="travel" id="n_travel" checked="checked" value="0" />None<br />
			<span style="margin-right:-1px">Entertainment:</span>&nbsp;&nbsp;<input type="radio" name="ent" id="y_ent" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="ent" id="n_ent" checked="checked" value="0" />None<br />
			
		  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" id="benefitsave">Save</button>
		  </div>
		</div>
	  </div>
	 </div>
</div>

<script>
	$(document).ready(function(){
		
		var leaves = $('input[name=leaves]');
		var employee_name = $('input[name=employee_name]');
		var employee_id = $('input[name=employee_id]');
		var y_hmo = $('#y_hmo');
		var n_hmo = $('#n_hmo');
		var y_phone = $('#y_phone');
		var n_phone = $('#n_phone');
		var y_gas = $('#y_gas');
		var n_gas = $('#n_gas');
		var y_travel = $('#y_travel');
		var n_travel = $('#n_travel');
		var y_ent = $('#y_ent');
		var n_ent = $('#n_ent');
		var modal_title = $('.modal-title');
		var errorVal = $('input[name=errorVal]');

		var addbenefit_modal = $('#addbenefit_modal');
		var savemode = $('input[name=savemode]');
		var recID = $('input[name=recID]');
		var benefitsave = $('#benefitsave');
		var eData = {};
		eData.name = <?php if(isset($jsonSuggestion)){echo $jsonSuggestion;}else{echo '""';} ?>;

		employee_name.focus(function(){
			$('.jsonSuggest').css('width','250px');
		});

		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');

		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	

		$('#add_benefit').click(function(){
			addbenefit_modal.modal('show');
			employee_name.prop('readonly', false);
			modal_title.text('Add Benefit');
			savemode.val(0);
			setDefaultValues();

			employee_name.jsonSuggest({
				data:eData.name, 
				minCharacters: 2,
				onSelect: function(item){
					employee_id.val(item.id);
					if(item.emp_id != null){
						errorVal.val(1);
						alertify('This employee has benefits record already.', 'Notification');
						employee_name.val('');
					}
				}
			});	
		});

		function setDefaultValues(){
			employee_name.val('');
			leaves.val('');
			y_hmo.prop('checked', false);
			n_hmo.prop('checked', true);
			y_phone.prop('checked', false);
			n_phone.prop('checked', true);
			y_gas.prop('checked', false);
			n_gas.prop('checked', true);
			y_travel.prop('checked', false);
			n_travel.prop('checked', true);
			y_ent.prop('checked', false);
			n_ent.prop('checked', true);
		}

		$('.editlink').click(function(){
			var id = $(this).parent().parent().attr('id');
			modal_title.text('Edit Benefit');
			recID.val(id);
			savemode.val(1);
			employee_name.prop('readonly', true);
			
			$.ajax({
				url: ADMIN_URI + 'admin/edit_benefit',
				type: 'post',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data){
					employee_name.val(data.employee_name);
					leaves.val(data.leaves);

					if(data.hmo == 1){
						y_hmo.prop('checked', true);
					} else {
						n_hmo.prop('checked', true);
					}

					if(data.phone == 1){
						y_phone.prop('checked', true);
					} else {
						n_phone.prop('checked', true);
					}

					if(data.gas == 1){
						y_gas.prop('checked', true);
					} else {
						n_gas.prop('checked', true);
					}

					if(data.travel == 1){
						y_travel.prop('checked', true);
					} else {
						n_travel.prop('checked', true);
					}

					if(data.entertainment == 1){
						y_ent.prop('checked', true);
					} else {
						n_ent.prop('checked', true);
					}

					addbenefit_modal.modal('show');

				}
			});
		});

		$('.deletelink').click(function(){
			var id = $(this).parent().parent().attr('id');
			var x = confirm("Are you sure you want to delete this record?");

			if(x){
				$.ajax({
					url: ADMIN_URI + 'admin/delete_benefit',
					type: 'post',
					data: 'id=' + id,
					dataType: 'json',
					complete: function(){
						location.reload();
					}
				});
			}
		});

		benefitsave.click(function(){
			
				var data = $('#addbenefit_form').serialize();
				var url;

				if(savemode.val() == 1){
					url = ADMIN_URI + 'admin/update_benefit';
					goAjax(url,data);
				} else {
					url = ADMIN_URI + 'admin/add_benefit';
					if(employee_id.val() != ''){
						goAjax(url,data);
					} else {
						alertify('Please choose an employee.', 'Notification');
					}
				}

				function goAjax(url,data){
					$.ajax({
						url: url,
						type: 'post',
						data: data,
						dataType: 'json',
						beforeSend: function(){
							benefitsave.text('Saving...');
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
							benefitsave.text('Save');
						}
				});
			}
		});	
});
</script>