<div class="row">
	<div class="col-xs-12">
		<a class="btn btn-success btn-xs" href="<?=base_url('daily-update-report')?>">Back</a>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="detail_table">
					<thead>
						<tr>
							<th>Date</th>
							<th class="text-center">Details</th>
						</tr>
					</thead>
				<?php
					foreach($dateWiseData as $k=>$data){
						echo'<tr>
							<td>'.date("d/m/Y",strtotime($k)).'</td>';
							echo'<td><table class="table">';
								foreach($data as $kk=>$thisData){
									if(count($thisData)>0):
										$user=$thisData[0]["user_name"];
										echo'<tr>';
											echo'<td>';
											echo '<b><u>'.$user.'</u></b>';
											foreach($thisData as $task){
												echo'<div class="'.($task["update_status"]==1?'bg-success':'bg-danger').'">
													'.(!empty($task["customer_name"])?'Customer: '.$task["customer_name"].' <br/>':'').' 
													'.(!empty($task["principle_name"])?'Principle: '.$task["principle_name"].' <br/>':'').' 
													'.$task["estimated_event"].'</br>
													'.($task["update_time"]!='0000-00-00 00:00:00'?date("d-m-Y H:i a",strtotime($task["update_time"])):'No Report').'<br/>
													'.$task["remark"].'
												</div>
												<div class="ln_solid"></div>
												';
											}
											echo'</td>';
										echo'</tr>';
									endif;
								}
							echo'</table></td>';
						echo'</tr>';
					}
				?>
				</table>
			</div>
		</div>
	</div>
</div>