<div class="row">
	<div class="col-md-5 col-xs-12">
		<h3 class="text-center">Job Particulars:</h3>
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
							<td>Job No.</td>
							<td>:</td>
							<td><?=($job_data[0]->type==1?'T':($job_data[0]->type==2?'CM':'MHD'))?>-<?=$job_data[0]->id?></td>
						</tr>
						<tr>
							<td>Custom No.</td>
							<td>:</td>
							<td><?=$job_data[0]->custome_no?></td>
						</tr>
						<tr>
							<td>Customer</td>
							<td>:</td>
							<td>
								<?php
									$sql="select name from customers where id=?";
									$cus=$this->db->query($sql,[$job_data[0]->customer])->row();
									echo $cus->name;
								?>
							</td>
						</tr>
						<tr>
							<td>Prime Contact</td>
							<td>:</td>
							<td>
								<?php
									$sql="select name,designation from contacts where id=?";
									$con=$this->db->query($sql,[$job_data[0]->prime_contact])->row();
									echo $con->name.' ('.$con->designation.')'.'<br/>';
									echo $job_data[0]->contact_phone;
								?>
							</td>
						</tr>
						<tr>
							<td colspan="3">Products :</td>
							 <td style="display: none;"></td>
 							<td style="display: none;"></td>
						</tr>
							<?php
								$sql="select a.id,a.name,b.requirement_details,b.additional_details
								 from products a, job_product b where a.id in(".$job_data[0]->products.") and b.job_id=".$job_data[0]->id." and b.product_id=a.id and b.deleted=0";
			                  $items=$this->db->query($sql)->result();
			                  $tr='';
			                  foreach($items as $item){

			                  	echo'<tr>
			                  		<td>'.$item->name.'</td>
			                  		<td style="display: none;"></td>
 									<td style="display: none;"></td>
			                  	</tr>';
			                  	$datas=json_decode($item->requirement_details);
			                  	foreach($datas as $data){
			                  		echo'<tr>
			                  			<td>'.$data->label.'</td>
			                  			<td>:</td>
 										<td>'.$data->value.'</td>
			                  		</tr>';
			                  	}
			                  	if(!empty($item->additional_details)){
				                  	echo'<tr>
				                  		<td colspan="3">'.nl2br($item->additional_details).'</td>
				                  	</tr>';
			                  	}
			                  }

							?>
						<tr>
							<td>Handler</td>
							<td>:</td>
							<td>
								Cor : <?=$job_data[0]->co_handler_name.' ('.$job_data[0]->co_desig?>)
              					<br/>Mar : <?=$job_data[0]->ma_handler_name.' ('.$job_data[0]->ma_desig?>)
							</td>
						</tr>
						<tr>
							<td>Details</td>
							<td>:</td>
							<td><?=nl2br($job_data[0]->job_details)?></td>
						</tr>
					</tbody>
				</table>
				<!--<button onclick="do_dl()">Download All Attachment</button>-->
				<?php
					$sql="select attachment_name from job_attachment where job_id=?";
					$result=$this->db->query($sql,[$job_data[0]->id])->result_array();
					if(count($result)>0){
						echo'<p>Attachments:</p>';
						echo'<ul>';
						$li='';
						$all_attachment=array();
						foreach($result as $data){
							if(!empty($data["attachment_name"]) && file_exists('./public/uploads/job/'.$data["attachment_name"])){
								$li.='<li>
									<a class="download_file" href="'.base_url('public/uploads/job/'.$data["attachment_name"]).'" download>'.$data["attachment_name"].'</a>
								</li>';
								$all_attachment[]["download"]=base_url('public/uploads/job/'.$data["attachment_name"]);
								$all_attachment[]["filename"]=$data["attachment_name"];
							}
						}
						echo $li;
						echo'</ul>';
					}


				?>


				
			</div>
		</div>
	</div>
	<div class="col-md-7 col-xs-12">
		<h3 class="text-center">Sended Requirement Details:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="contact_table">
					<thead>
						<tr>
							<th>Product</th>
							<th></th>
							<th>Principle</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="select
								b.id as pid,
								a.id,
								a.offer_received,
								c.name as product_name,
								d.name as principle_name
								from job_requirement_to_principle a, job_product b, products c, principles d 
								where a.job=".$job_data[0]->id." and b.id=a.job_produt and c.id=b.product_id and d.id=a.priciple
								and b.deleted=0
								order by b.id
							";
							$result=$this->db->query($sql)->result();
							$tr=array();
							foreach($result as $data){
								$tr[$data->pid][]=$data;
							}
							$tableRow='';
							foreach($tr as $row){
								$product=$row[0]->product_name;
								$principle='';
								foreach($row as $data){
									$principle.=''.$data->principle_name.' ('.($data->offer_received==1?'Yes':'No').')<hr/>';

									// for attachment
									$asql="select attachment_name from job_principle_offer_attachment where principle_requirement_id=".$data->id."";
									$aresult=$this->db->query($asql)->result();
									if(count($aresult)>0){
										foreach($aresult as $adata){
											if(!empty($adata->attachment_name) && file_exists('./public/uploads/job/principle_requirement/'.$adata->attachment_name)){
											$principle.='<a href="'.base_url('public/uploads/job/principle_requirement/'.$adata->attachment_name).'" download>'.$adata->attachment_name.'</a></br>';
											}
										}
									}

								}
								echo '<tr>
									<td>'.nl2br($product).'</td>
									<td>:</td>
									<td>'.$principle.'</td>
								</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
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
		                
							$userRole=$this->session->userdata('userRole');
							if($userRole!=3){
								$sql="select 
									a.*,
									(select name from contacts where id=a.contact_id) as contact_name,
									b.user_name
									from job_event_register a,
									users b
									where a.job_id=?
									and b.id=a.created_by order by a.id desc
								";
							}else{
								$user=$this->session->userdata('userId');
								$sql="select 
									a.*,
									(select name from contacts where id=a.contact_id) as contact_name,
									b.user_name
									from job_event_register a,
									users b
									where a.job_id=?
									and b.id=a.created_by and a.created_by={$user} order by a.id desc
								";
							}
						$events=$this->db->query($sql,[$job_data[0]->id])->result();
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
			                        	if(!empty($thisData) && file_exists('./public/uploads/job/event_attachments/'.$thisData)){
			                        		echo '<a href="'.base_url('public/uploads/job/event_attachments/'.$thisData).'" download>'.$thisData.'</a><br/>';
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