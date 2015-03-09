<div style="width:1100px;margin:auto auto">
	<div style="width:150px;margin:100px 25px 0 0;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div id="departmentcontainer" style="width:925px;float:right;margin-top:100px">
		<table class="table table-striped">
			<thead>
				<tr style="font-weight:bold">
					<td width="118px">Company</td>
					<td width="118px">Department</td>
					<td width="100px">Position</td>
					<td width="115px">Name</td>
					<td width="80px">Time In</td>
					<td width="80px">Status</td>
					<td>Reason</td>
					<td>Remarks</td>
				</tr>
			</thead>
		</table>
		<div  style="width:940px; height:450px; overflow:scroll;">
			<form method="post">
				<table class="table table-striped">
					<tbody id="biometrics_databody">
						<?php
						
							if (!empty($biometrics_data))
							{	
							// Dump all data according to biometrics record
								foreach ($biometrics_data as $key => $html) {       
									if (!empty($html)) {
									foreach ($html as $key => $value) {
										
										echo $value;
									} }
								
								}
							}
						?>
					</tbody>
				</table>
				<input type="hidden" name="data" value='' />
			</form>
				<?php if(!empty($biometrics_data)){ ?>
					<span style="float:right; margin-top:19px;">
						<button id="bulk_save_records" class="btn btn-default" type="submit" />Save Records</button><br /><br />
					</span>
				<?php } ?>	
			
		</div>
		<div>
			<span style="float:right; margin-top:19px;">
				<?php echo form_open_multipart('admin/do_upload'); ?>
				<input type='radio' name='shift' value='1'> AM shift <br>
				<input type='radio' name='shift' value='2'> PM shift <br>
				<input type='radio' name='shift' value='3'> Mid shift <br>
				<input class="btn btn-warning" type="submit" id="upload_bio_file" value="Upload txt file" /><br /><br />
				<input type="file" name="userfile" size="20" />
			</span>
		</div>
		<div>
			<span style="float:left; margin-top:19px;">
				<input type='radio' name='shift' value='1'> AM shift <br>
				<input type='radio' name='shift' value='2'> PM shift <br>
				<input type='radio' name='shift' value='3'> Mid shift <br>
				<button class="btn btn-warning " id="generate_record" type="button">Generate Attendance</button>
			</span>
		</div>


		<!-- ************************************** Offset Dates Modal *********************************************-->
		<div class="modal fade" id="offsetdates_modal">
		  <div class="modal-dialog"  style="width:280px">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" style="font-weight:bold">Offset Dates</h3>
				<input type="hidden" name="errorVal" value="0">
			  </div>
			  <div class="modal-body">
			  <form id="offsetdates_form">
			  	<input type="hidden" name="savemode" value="" />
			  	<input type="hidden" name="emp_code" value="" />
				<input style="width:250px" type="text" name="date_from" class="form-control" placeholder="Start Date" /><br />
				<input style="width:250px" type="text" name="date_to" class="form-control" placeholder="End Date" /><br />
			  </form>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="offsetdates_save">Save</button>
			  </div>
			</div>
		  </div>
		</div>

	</div>
</div>

<script>
	$(document).ready(function(){

		var errorVal = $('input[name=errorVal]');

		$('input[name=date_from], input[name=date_to]').numeric({allow:'/ampm'});
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');


		$('#bulk_save_records').click(function(){

			var data_array = '[';
			
			$("input[name='wholedata\\[\\]']").each(function(){		

				data_array += $(this).val();

				var type_val = $(this).parent().children(':nth-child(8)').children(':checked').val();
				var reason_val = $(this).parent().children(':nth-child(9)').children().val();
				var remark_val = $(this).parent().children(':nth-child(10)').children().val();
				var data_array_length = data_array.length - 1;
				var newdata_array = data_array.substr(0, data_array_length);

				newdata_array += ',"type":"' + type_val + '","reason":"' + reason_val + '","remark":"' + remark_val + '"},';
				data_array = newdata_array; 
				
			});

			var full_data_array_length = data_array.length - 1; 
			var full_newdata_array = data_array.substr(0, full_data_array_length);
			full_newdata_array += ']';

			

			/*************************** END OF CREATION OF JSON *************************************/

			$.ajax({
				url: ADMIN_URI + 'admin/biometrics_save_attendance',
				type: 'post',
				data: 'data=' + full_newdata_array,
				dataType: 'json',
				success: function(data){
					if(data.success == 1){
						errorVal.val(0);
						alertify(data.msg, 'Notification');
					} else {
						errorVal.val(1);
						alertify(data.msg, 'Error');			
					}
					
				}

			});
		});
	

	 	$('input[name=date_from], input[name=date_to]').datetimepicker({
			timeFormat: 'hh:mm tt',
			dateFormat: "mm/dd/yy"
		});

	
		$('body').on('change', '.r_offset', function(){
			var emp_code = $(this).parent().parent().attr('id');
			 
			$('input[name=date_from], input[name=date_to]').val('');

			$('#offsetdates_modal').modal('show');
			$('input[name=emp_code]').val(emp_code);
		});

		$('#offsetdates_save').click(function(){
			var dateStart = $('input[name=date_from]').val();
			var dateEnd  = $('input[name=date_to]').val();
			var emp_code = $('input[name=emp_code]').val()
			var postData = {dateS: dateStart, dateE:dateEnd, empC: emp_code};
			var urls = ADMIN_URI +'admin/biometrics_offset'
			 $.ajax({
			 		url: urls,
			 		type: 'post',
			 		dateType:'json',
			 		data: postData,
			 		success : function(data)
			 		{
			 			if (data.success == 0)
			 			{
			 				alertify('Something went wrong', 'Error');
			 			} 

			 			$('#offsetdates_modal').modal('hide');
			 		}
			 });
			
		});

		$('#okButton').click(function(){
			if(errorVal.val() == 0){
				location.reload(); 	// reload only when user was successfully saved... 
			} else {
				return;
			}
		});	

		$urls = ADMIN_URI + 'generaterecord.php';

		$('#generate_record').click(function(){
		
			var shift = $('input:radio[name=shift]:checked').val();

			var datavalue = {shiftdata: shift};	
			$.ajax({
				url: $urls,
				type: 'post',
				dataType: 'json',
				data : datavalue,
				success : function(data){
				result = data;

					if (result.response == 1){
						window.location.href = 'biometrics_cpanel?file='+ result.filegen+'&shift='+result.shift;
					} else {
						window.location.href = 'biometrics_cpanel';
					}
					
				}
			
			});
	});

		
});
</script>