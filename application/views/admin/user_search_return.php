
<input type="hidden" id="numrow" value="<?php echo $t_rows; ?>">
<?php if(!empty($userstable)) {
foreach ($userstable as $key => $users) { ?>
	
	<tr id="<?php echo $users->tl_id; ?>">
	<td><?php echo $users->company_name; ?>
	</td>
	<td style="max-width: 101px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap; "><?php echo $users->username; ?></td>
	<td style="max-width: 153px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap; "><?php echo $users->lastname; ?></td>
	<td style="max-width: 153px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap; "><?php echo $users->firstname; ?></td>
	<td style="max-width: 120px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap; "><?php echo $users->middlename; ?></td>
		<td align="center" colspan="2"><a class="printpdf btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> PDF</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="edituser btn btn-warning" target="_blank" href=<?php echo base_url(); ?>./employee/employee_edit?username=<?php echo $users->username; ?>><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>	
	</tr>
<?php } }?>