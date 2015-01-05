<?php 
if (!empty($requestable)) { ?>
	<input type="hidden" value="<?php echo $numrow; ?>" id="numrow">
	<?php foreach ($requestable as $key => $request) { ?>
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
					echo 'HalloHallo Alliance';
				}?>
			</td>
			<td><?php echo $request->department; ?></td>
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