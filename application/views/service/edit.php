
<form method="post" action="<?=base_url('service-update')?>" enctype="multipart/form-data">
<input type="hidden" name="service" value="<?=$service[0]->id?>">	
<div class="row">
	<div class="col-xs-12">
	<?php if($this->session->userdata('permissions')->service_list==1):?>
		<a class="btn btn-primary btn-xs" href="<?=base_url('service-list')?>"><span class="glyphicon glyphicon-th-list"></span> Service List</a>
	<?php endif;?>
	</div>	
	<div class="col-xs-12">
		<div class="form-group">
			<label>Company / Customer :</label>
			<input type="text"  class="form-control" value="<?=$service[0]->customer_name?>"  autocomplete="off"  readonly>
		</div>
		<div class="form-group">
			<label>Contact:</label>
			<div>
				<select id="prime_contact" name="contact" class="form-control">
					<?php
						foreach($contacts as $k=>$val){
							echo'<option value="'.$val->id.'" '.($val->id==$service[0]->contact?'selected':'').'>'.$val->name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<input type="button" id="select_product" value="Add Product" class="btn btn-success" data-toggle="modal" data-target="#service_product">
		</div>
		<div class="col-md-12" id="selected_product_result">

			<?php
			$data=$this->session->userdata('modify_service_cart_products');
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
	              			echo'<li><a href="#form_'.$k.'" data-toggle="tab" data-id="'.$k.'"><span style="cursor:pointer;" class="btn btn-danger btn-xs" onclick="modify_cart_to_remove(this)" data-index="'.$k.'"><i class="fa fa-close"></i></span> '.$val["product_name"].'</a></li>';
	              			$form.='
	              				<div class="tab-pane" id="form_'.$k.'">';
	    					$form.='<p class="lead">'.$val["product_name"].'</p>';
	    					

	    					$form.='<div class="form-group"><label>Details:</label><textarea class="form-control" name="description" data-index="'.$k.'" onchange="this_value_update(this)" data-selfindex="dd" >'.$val["description"].'</textarea></div></div>';
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
			<label>Service Details:</label>
			<textarea name="details" class="form-control"><?=$service[0]->details?></textarea>
		</div>
	</div>
	<div class="col-xs-12 text-center">
		<input type="submit" name="save" value="Update Service" class="btn btn-success">
	</div>
</div>
</form>
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true" id="service_product">
  <div class="modal-dialog modal-md">  	
    <form method="post" action="<?=base_url('set-product-for-service')?>" id="service_product_setup_form" novalidate>
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
		      	<div class="form-group">
		      		<label>Details:</label>
		      		<textarea class="form-control" id="description"></textarea>
		      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <input type="submit" class="btn btn-primary" id="save_service_product" name="add_new" value="Add Now">
	      </div>
	    </div>
    </form>
  </div>
</div>