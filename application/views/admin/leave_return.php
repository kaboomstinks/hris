				<?php 
				if (!empty($leavetable)) {
					foreach ($leavetable as $key => $leave) { ?>
						<tr id="<?php echo $leave->lid; ?>">
							<td width="80px">
								<?php
								if ($leave->company == '1') 
								{
									echo 'Circus Co. Ltd (Philippine Branch)';
								}
								elseif ($leave->company == '2') 
								{
									echo 'Tavolozza';
								}else
								{
									echo 'HalloHallo Inc.';
								}?>
							</td>
							<td width="80px"><?php echo $leave->dep_name; ?></td>
							<td width="80px"><?php echo $leave->position; ?></td>
							<td width="80px"><?php echo $leave->emp_code; ?></td>
							<td width="80px"><?php echo $leave->firstname.' '.$leave->middlename.' '.$leave->lastname; ?></td>
							<td width="80px"><?php echo $leave->type; ?></td>
							<td width="80px"><?php echo $leave->date_from; ?></td>
							<td width="80px"><?php echo $leave->date_to; ?></td>
							<td colspan="2" align="center">
								<a class="editlink btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="deletelink btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
							</td>
						</tr>
				<?php } }?>