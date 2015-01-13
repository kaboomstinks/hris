<?php if (!empty($changeschedtable)) { ?>
	<?php foreach ($changeschedtable as $key => $change) { ?>
		<tr id="<?php echo $change->cid; ?>">
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
					echo 'HalloHallo Inc';
				}?>
			</td>
			<td width="80px"><?php echo $change->dep_name; ?></td>
			<td width="80px"><?php echo $change->position; ?></td>
			<td width="80px"><?php echo $change->emp_code; ?></td>
			<td width="80px"><?php echo $change->firstname.' '.$change->middlename.' '.$change->lastname; ?></td>
			<td width="80px"><?php echo $change->date_from; ?></td>
			<td width="80px"><?php echo $change->date_to; ?></td>
			<td colspan="2" align="center">
				<a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				&nbsp;
				<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
			</td>
		</tr>
<?php } ?>
<?php } ?>