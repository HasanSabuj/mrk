
<form method="post" action="<?=base_url('job-update')?>" enctype="multipart/form-data">
<input type="hidden" name="job" value="<?=$job[0]->id?>">	
<div class="row">
	<div class="col-xs-12">
	<?php if($this->session->userdata('permissions')->job==1):?>
		<a class="btn btn-primary btn-xs" href="<?=base_url('job-list')?>"><span class="glyphicon glyphicon-th-list"></span> Job List</a>
	<?php endif;?>
	</div>	
	<div class="col-xs-12">
		<div class="form-group">
			<label>Job Type:</label>
			<select name="type" class="form-control">
				<option value="1" <?=($job[0]->type==1?'selected':'')?>>Tender</option>
				<option value="2" <?=($job[0]->type==2?'selected':'')?>>Capital Mechineries</option>
				<option value="3" <?=($job[0]->type==3?'selected':'')?>>Metarial Handling Dept</option>
			</select>
		</div>
		<div class="form-group">
			<label>Custom Job Number:</label>
			<input type="text" name="custome_no" class="form-control" value="<?=$job[0]->custome_no?>">
		</div>
		<div class="form-group">
			<label>Company / Customer :</label>
			<input type="text"  class="form-control" value="<?=$job[0]->customer_name?>"  autocomplete="off"  readonly>
		</div>
		<div class="form-group">
			<label>Prime Contact:</label>
			<div>
				<select id="prime_contact" name="prime_contact" class="form-control">
					<?php
						foreach($contacts as $k=>$val){
							echo'<option value="'.$val->id.'" '.($val->id==$job[0]->prime_contact?'selected':'').'>'.$val->name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<input type="button" id="select_product" value="Add Product" class="btn btn-success" data-toggle="modal" data-target="#job_product">
		</div>
		<div class="col-md-12" id="selected_product_result">

			<?php
			$data=$this->session->userdata('modify_cart_products');
			//print_r($data);
			if(count($data)>0){
				echo'<div class="x_panel">
					<p class="lead">Products:</p>
		          <div class="x_content">

		            <div class="col-xs-3">
		              <!-- required for floating -->
		              <!-- Nav tabs -->
		              <ul class="nav nav-tabs tabs-left">';
		              	$form='';
	              		foreach($data as $k=>$val){
	              			echo'<li>
	              			<span data-toggle="tooltip" title="Delete This Product" style="cursor:pointer;position:absolute;left:-30px;z-index:999;" class="btn btn-danger btn-xs" onclick="modify_cart_to_remove(this)" data-index="'.$k.'"><i class="fa fa-close"></i></span>
	              			<a href="#form_'.$k.'" data-toggle="tab" data-id="'.$k.'" data-toggle="tooltip" title="Select This Product" >
	              			 '.$val["product_name"].'</a></li>';
	              			$form.='
	              				<div class="tab-pane" id="form_'.$k.'">';
	    					$form.='<p class="lead">'.$val["product_name"].'</p>';
	    					$elements=json_decode($val["data"]);
	    					//print_r($elements);
					    	foreach ($elements as $key => $value) {
					    		$form.='
					    			<div class="form-group">
					    			<label class="control-label">'.$value->label.' '.($value->required==1?'<span class="required">* </span>':'').':</label>
	    								<input  onchange="this_value_update(this)" data-selfindex="'.$key.'" data-index="'.$k.'" type="text" class="form-control '.($value->required==1?'form-field':'').'" name="'.$value->label.'" '.($value->required==1?'required':'').'  autocomplete="off" data-required="'.($value->required==1?'1':'0').'" value="'.$value->value.'">
	    							</div>	
					    		';
					    	}

	    					$form.='<div class="form-group"><label>Description:</label><textarea class="form-control" name="description" data-index="'.$k.'" onchange="this_value_update(this)" data-selfindex="dd" >'.$val["description"].'</textarea></div></div>';
	              		}
		              
		        echo'</ul>
		            </div>

		            <div class="col-xs-9">
		              <!-- Tab panes -->
		              <div class="tab-content" id="tab_result">
		                '.$form.'
		              </div>
		            </div>

		            <div class="clearfix"></div>

		          </div>
		        </div>';
	    	}
	        ?>
		</div>
		<div class="form-group">
			<label>Job Details:</label>
			<textarea name="job_details" class="form-control"><?=$job[0]->job_details?></textarea>
		</div>
		<div class="form-group">
			<input type="file" name="attachments[]" multiple class="form-control" accept="image/gif, image/jpeg, image/png, application/pdf, application/vnd.ms-excel">
		</div>
		<!--<div class="form-group">
			<label>Drowing <input type="checkbox" value="1" name="drowing"> </label><br/>
			<label>Offer <input type="checkbox" value="1" name="offer"> </label>
		</div>-->
	</div>
	<div class="col-xs-12 text-center">
		<input type="submit" name="save" value="Update Job" class="btn btn-success">
	</div>
</div>
</form>
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true" id="job_product">
  <div class="modal-dialog modal-md">  	
    <form method="post" action="<?=base_url('set-product-for-job')?>" id="job_product_setup_form" novalidate>
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	        </button>
	        <h4 class="modal-title" id="myModalLabel2">Select Product</h4>
	      </div>

	      <div class="modal-body">
		      	<div class="form-group">
					<label>Product <span class="required">*</span> :</label>
					
					<div class="input-group">
		            <input type="text" id="search_product" class="form-control" placeholder="Select Product By Search" required autocomplete="off">
		            <input type="hidden" name="product_id" id="product_id" required>
		            <span class="input-group-addon"  id="clear_product_list">
		              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		            </span>
		            </div>
					<div id="product_search_result">
						<ul>
							
						</ul>
					</div>
				</div>
		      	<div id="product_requirement_form">
		      		
		      	</div>
		      	<div class="form-group">
		      		<label>Description:</label>
		      		<textarea class="form-control" id="description"></textarea>
		      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <input type="submit" class="btn btn-primary" id="save_job_product" name="add_new" value="Add Now">
	      </div>
	    </div>
    </form>
  </div>
</div>