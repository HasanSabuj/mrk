<div class="row">
	<div class="col-xs-12">
		<div class="x_panel">
	      <div class="x_title">
	        <a href="<?=base_url('job-list')?>" class="btn btn-primary btn-xs">Back</a>   
	        <ul class="nav navbar-right panel_toolbox">
	          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	          </li>
	          <li><a class="close-link"><i class="fa fa-close"></i></a>
	          </li>
	        </ul>
	        <div class="clearfix"></div>
	      </div>
	      <div class="x_content">
	      		<form method="post" action="<?=base_url('job-requirement-send')?>" class="form-horizontal form-label-left" novalidate enctype="multipart/form-data">
	      			<input type="hidden" name="job" value="<?=$job?>">
	      			<table class="table table-bordered">
	      			<?php

	      			$sql="select * from job_requirement_to_principle where job=?";
	      			$myArray=$this->db->query($sql,[$job])->result_array();
	      			if(count($myArray)>0){
	      				$myArray  = array_combine(range(1, count($myArray)), array_values($myArray));
	      			}
	      				foreach($products as $product){
	      					$sql="SELECT id,name from principles WHERE FIND_IN_SET(?, products)";
	      					$results=$this->db->query($sql,[$product["product_id"]])->result();
	      					echo'
	      						<tr>
	      							<td><b>'.$product["product_name"].'</b></td>
	      							<td>
	      								<table class="table table-bordered table-striped">
	      									<tr>
	      										<th>Principle</th>
	      										<th>Offer<br>Received</th>
	      										<th>Attachment</th>
	      									</tr>
	      							';
	      								foreach($results as $result){

	      									if(count($myArray)>0){
		      									$search = ['job_produt' => $product["id"], 'priciple' => $result->id];
												$keys = array_keys(
												    array_filter(
												        $myArray,
												        function ($v) use ($search) { return $v['job_produt'] == $search['job_produt'] && $v['priciple'] == $search['priciple']; }
												    )
												);
												if(count($keys)>0){
													$key = $keys[0];
												}else{
													$key='';
												}
											}else{
												$key='';
											}


											if($key){
												$offer_received=$myArray[$key]["offer_received"];
	      										echo'<tr><td><label><input type="checkbox" value="'.$result->id.'" name="principle['.$product["id"].']['.$result->id.']" checked onclick="update_requirement_to_principle(this)" data-product="'.$product["id"].'" data-key="'.$myArray[$key]["id"].'"> '.$result->name.'</label></td>';
	      									}else{
	      										$offer_received=0;

	      										echo'<tr><td><label><input type="checkbox" value="'.$result->id.'" name="principle['.$product["id"].']['.$result->id.']"> '.$result->name.'</label></td>';
	      									}
	      									echo'
	      									<td>
			      								<select name="offer_receive['.$product["id"].']['.$result->id.']">
			      									<option value="0" '.($offer_received==0?'selected':'').'>No</option>
			      									<option value="1" '.($offer_received==1?'selected':'').'>Yes</option>
			      								</select>
			      							</td>

			      							<td>
			      								<input type="file" name="attachments_'.$product["id"].'_'.$result->id.'[]" multiple>
			      							</td>
			      							</tr>
			      							';
	      								}
	      						echo'
	      							</table>
	      						</td>
	      						</tr>
	      					';
	      				}
	      			?>
	      			</table>
	      			<div class="ln_solid"></div>
			          <div class="form-group">
			            <div class="col-md-12 text-center">
			              <input id="send" type="submit" class="btn btn-success" name="save" value="Save"/>
			            </div>
			          </div>
	      		</form>
	      </div>
		</div>
	</div>
</div>