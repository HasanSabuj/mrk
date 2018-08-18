
<div class="row">
	<div class="col-md-5 col-xs-12">
		<h3 class="text-center">Principle Profile:</h3>
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
							<td>Name</td>
							<td>:</td>
							<td><?=$principle_data->name?></td>
						</tr>
						<tr>
							<td>Products</td>
							<td>:</td>
							<td>
								<?php
									if($principle_data->products){
									  $sql="select group_concat(name SEPARATOR '<br> ') as product_name from products where id in(".$principle_data->products.")";
									  $items=$this->db->query($sql)->row();
									  $items=$items->product_name;
									}else{
									  $items='';
									}
									echo $items;
								?>
							</td>
						</tr>

						<tr>
							<td>Phone No.</td>
							<td>:</td>
							<td><?=$principle_data->phone?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?=$principle_data->email?></td>
						</tr>
						<tr>
							<td>Website</td>
							<td>:</td>
							<td><?=$principle_data->website?></td>
						</tr>
						<tr>
							<td>Country</td>
							<td>:</td>
							<td><?=$principle_data->country?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td>:</td>
							<td><?=nl2br($principle_data->address)?></td>
						</tr>
						<tr>
							<td>Reference in BD</td>
							<td>:</td>
							<td><?=nl2br($principle_data->ref_bd)?></td>
						</tr>
						<tr>
							<td>Reference in Global</td>
							<td>:</td>
							<td><?=nl2br($principle_data->ref_global)?></td>
						</tr>
						<tr>
							<td>Year of Establisment</td>
							<td>:</td>
							<td><?=$principle_data->esta_year?></td>
						</tr>
						<tr>
							<td>Visiting Card</td>
							<td>:</td>
							<td>
								<?php
									if($principle_data->visiting_card){
									              
									    echo'<a href="data:image/jpeg;base64,'.base64_encode( $principle_data->visiting_card ).'" download><img style="width: 100%; display: block;" src="data:image/jpeg;base64,'.base64_encode( $principle_data->visiting_card ).'" alt="image" /></a>';
									  
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
		<h3 class="text-center">Principle Contacts:</h3>
		<div class="x_panel">
			<div class="x_content">
				<table class="table table-striped" id="contact_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Designation</th>
							<th>Field</th>
							<th>Phone</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql="select * from principle_contacts where principle_id=? and deleted=0";
							$contacts=$this->db->query($sql,[$principle_data->id])->result();
							foreach($contacts as $contact){
								echo'<tr>
									<td>'.$contact->name.'</td>
									<td>'.$contact->designation.'</td>
									<td>'.$contact->job_field.'</td>
									<td>'.$contact->phone.'</td>
									<td>'.$contact->email.'</td>
								</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>			

	</div>
</div>
