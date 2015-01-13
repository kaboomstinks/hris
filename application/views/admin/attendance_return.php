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
								}else
								{
									echo 'HalloHallo Inc.';
								}?>
							</td>
							<td width="80px"><?php echo $attendance->dep_name; ?></td>
							<td width="80px"><?php echo $attendance->position; ?></td>
							<td width="80px"><?php echo $attendance->emp_code; ?></td>
							<td width="80px"><?php echo date('m/d/Y h:i', $attendance->date_filed); ?></td>
							<td width="80px"><?php echo $attendance->firstname.' '.$attendance->middlename.' '.$attendance->lastname; ?></td>
							<td width="80px"><?php echo $attendance->reason; ?></td>
							<td colspan="2" align="center">
								<a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
							</td>
						</tr>
				<?php } ?>
			<?php } ?>