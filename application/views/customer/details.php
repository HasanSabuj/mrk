
<div class="row">
	<div class="col-md-5 col-xs-12">
		<h3 class="text-center">Customer Profile:</h3>
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
							<td>Company Name</td>
							<td>:</td>
							<td><?=$customer_data->name?></td>
						</tr>
						
						<tr>
							<td>Phone No.</td>
							<td>:</td>
							<td><?=$customer_data->phone?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?=$customer_data->email?></td>
						</tr>
						<tr>
							<td>Website</td>
							<td>:</td>
							<td><?=$customer_data->website?></td>
						</tr>
						<tr>
							<td>Office Address</td>
							<td>:</td>
							<td><?=nl2br($customer_data->address)?></td>
						</tr>
						<tr>
							<td>Factory Address</td>
							<td>:</td>
							<td><?=nl2br($customer_data->address_fac)?></td>
						</tr>
						<tr>
							<td>Customer Type</td>
							<td>:</td>
							<td>
								<?php
								$sql="select name from customer_type where id=?";
								$type=$this->db->query($sql,[$customer_data->cust_type])->row();
								echo $type->name;
								?>
							</td>
						</tr>
						<tr>
							<td>Catygory</td>
							<td>:</td>
							<td><?php
								echo ($customer_data->cust_cat==1?'Intensive care':($customer_data->cust_cat==2?'Existing':($customer_data->cust_cat==3?'Less Important':'Prospect')));
							?></td>
						</tr>
						
						<tr>
							<td>Visiting Card</td>
							<td>:</td>
							<td>
								<?php
						            if($customer_data->attachments){
						              $cust_file='./public/uploads/customer/'.$customer_data->attachments;
						              if(file_exists($cust_file)){
						                echo'<a href="'.base_url().'public/uploads/customer/'.$customer_data->attachments.'" download><img style="width: 100%; display: block;" src="'.base_url().'public/uploads/customer/'.$customer_data->attachments.'" alt="image" /></a>';
						              }
						            }
						          ?>
							</td>
						</tr>
					</tbody>	
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-xs-12">
		<h3 class="text-center">Customer Contacts:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="contact_table">
					<thead>
						<tr>
							<th>Name</th>
							<th style="text-align: center;">Department<br/>&<br/>Designation</th>
							<th style="text-align: center;">Phone<br/>&<br/>Email</th>
							<th style="text-align: center;">Visiting<br/>Card</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="select * from contacts where customer_id=? and deleted=0";
							$contacts=$this->db->query($sql,[$customer_data->id])->result();
							foreach($contacts as $contact){
								echo'<tr>
									<td>'.$contact->name.'</td>
									<td>'.$contact->department.'<br/>'.$contact->designation.'</td>
									<td>'.$contact->phone.'<br/>'.$contact->email.'</td>
									<td class="text-center">'.($contact->vcard?'<a href="'.base_url().'public/uploads/customer/contact/'.$contact->vcard.'" download><img style="max-width:100px" src="'.base_url().'public/uploads/customer/contact/'.$contact->vcard.'" /></a>':'').'</td>
								</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>			
		<h3 class="text-center">JOB List:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="job_table">
					<thead>
						<tr>
							<th>Task No.</th>
							<th style="text-align: center;">Products</th>
							<th style="text-align: center;">Created By</th>
							<th style="text-align: center;">Created At</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="SELECT a.*,
							(select group_concat(product_id) from job_product
							 where job_id=a.id) as products,d.user_name FROM job_master a,users d WHERE d.id=a.created_by and a.customer=? order by a.id asc";
							$jobs=$this->db->query($sql,[$customer_data->id])->result();
							foreach($jobs as $val){
								 $sql="select group_concat(name SEPARATOR '<br> ') as product_name from products where id in(".$val->products.")";
				                  $items=$this->db->query($sql)->row();
				                  $items=$items->product_name;

								echo'<tr>
									<td><a href="'.base_url('job-details/'.$val->id).'" target="_blank">'.($val->type==1?'T-'.$val->id:($val->type==2?'CM-'.$val->id:($val->type==3?'MHD-'.$val->id:''))).'</a></td>
									<td>'.$items.'</td>
									<td>'.$val->user_name.'</td>
									<td>'.date("d/m/Y",strtotime($val->created_at)).'</td>
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
		<h3 class="text-center">Follow up history:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="follow_up_table">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Details Discuss Issue</th>
							<th>Follow up by</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="SELECT 
								a.id,
								a.working_day_id,
								a.customer_id,
								a.estimated_event,
								a.remark,
								a.status,
								a.update_time,
								c.user_id,
								c.month_date,
								d.user_name
								FROM work_plan_details_setup a,
								work_plan_details b,
								monthly_work_plan c,
								users d
								WHERE
								a.status=1
								and a.customer_id=?
								and b.id=a.working_day_id
								and c.id=b.monthly_work_plan_id
								and d.id=c.user_id
								order by c.month_date desc";

							$f_data=$this->db->query($sql,[$customer_data->id])->result();	
							$i=1;
							foreach($f_data as $val){
								echo'
									<tr>
										<td>'.$i.'</td>
										<td>'.date("d/m/Y",strtotime($val->month_date)).'</td>
										<td>'.nl2br($val->estimated_event).' '.($val->remark?'<hr/>'.nl2br($val->remark):'').'</td>
										<td>'.$val->user_name.'</td>
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