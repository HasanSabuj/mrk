<div class="row">
	<div class="col-xs-12">
		<h3 class="text-center">Service Particulars:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="prof_table">
					<thead>
						<tr>
							<th>Parameter</th>
							<th>&nbsp;</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Service No.</td>
							<td>:</td>
							<td>SR-<?=$service_data[0]->id?></td>
						</tr>
						<tr>
							<td>Customer</td>
							<td>:</td>
							<td>
								<?php
									$sql="select name from customers where id=?";
									$cus=$this->db->query($sql,[$service_data[0]->customer])->row();
									echo $cus->name;
								?>
							</td>
						</tr>
						<tr>
							<td>Contact Person</td>
							<td>:</td>
							<td>
								<?php
									$sql="select name,designation from contacts where id=?";
									$con=$this->db->query($sql,[$service_data[0]->contact])->row();
									echo $con->name.' ('.$con->designation.')';
								?>
							</td>
						</tr>
						<tr>
							<td colspan="3">Products :</td>
							 <td style="display: none;"></td>
 							<td style="display: none;"></td>
						</tr>
						<tr>	
							<td colspan="3">
								<table class="table table-striped">
								<?php
									$sql="select a.id,a.name,b.additional_details
									 from products a, service_product b where a.id in(".$service_data[0]->products.") and b.service_id=".$service_data[0]->id." and b.product_id=a.id and b.deleted=0";
				                  $items=$this->db->query($sql)->result();
				                  $tr='';
				                  foreach($items as $item){

				                  	echo'<tr>
				                  		<td>'.$item->name.'</td>
				                  	</tr>';
				                  	if(!empty($item->additional_details)){
					                  	echo'<tr>
					                  		<td>'.nl2br($item->additional_details).'</td>
					                  	</tr>';
				                  	}
				                  }

								?>
								</table>
							</td>
							 <td style="display: none;"></td>
 							<td style="display: none;"></td>
						</tr>
						<tr>
							<td>Handler</td>
							<td>:</td>
							<td>
								<?=$service_data[0]->handler_name.' ('.$service_data[0]->handler_desig?>)
							</td>
						</tr>
						<tr>
							<td>Details</td>
							<td>:</td>
							<td><?=nl2br($service_data[0]->details)?></td>
						</tr>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h3 class="text-center">Event History:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="event_table">
					<thead>
		                <tr>
		                  <th>User</th>
		                  <th>Contact</th>
		                  <th>Event Date</th>
		                  <th>Title</th>
		                  <th>Description</th>
		                  <th>Next date</th>
		                  <th>Attachment</th>
		                </tr>
		              </thead>
		              <tbody>
		                <?php
		                $sql="select 
								a.*,
								(select name from contacts where id=a.contact_id) as contact_name,
								b.user_name
								from service_event_register a,
								users b
								where a.service_id=?
								and b.id=a.created_by order by a.id desc
							";
						$events=$this->db->query($sql,[$service_data[0]->id])->result();
		                  foreach($events as $data){

		                    echo'
		                      <tr>
		                        <td>'.$data->user_name.'<br>@'.date("d-m-Y h:s a",strtotime($data->created_at)).'</td>
		                        <td>'.$data->contact_name.'</td>
		                        <td>'.$data->note_date.'</td>
		                        <td>'.$data->event_title.'</td>
		                        <td>'.nl2br($data->event_details).'</td>
		                        <td>'.$data->next_date.'</td>
		                        <td>';
		                        if($data->attachment):
			                        $adata=json_decode($data->attachment);
			                        foreach($adata as $thisData){
			                        	if(!empty($thisData) && file_exists('./public/uploads/service/event_attachments/'.$thisData)){
			                        		echo '<a href="'.base_url('public/uploads/service/event_attachments/'.$thisData).'" download>'.$thisData.'</a><br/>';
			                        	}
			                        }
		                    	endif;
		                     echo'</td>
		                      </tr>
		                    ';
		                  }
		                ?>
		              </tbody>
				</table>
			</div>
		</div>
	</div>
</div>