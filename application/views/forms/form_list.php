<div class="ln_solid"></div>
<div class="row">
	<div class="col-xs-12">
    <?php if($this->session->userdata('permissions')->form_add==1):?>
		<a href="<?=base_url('form-add')?>" class="btn btn-success">Create New Form</a>
  <?php endif;?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
          <div class="x_content">

            <div class="col-xs-3">
              <!-- required for floating -->
              <!-- Nav tabs -->
              <ul class="nav nav-tabs tabs-left">
              	<?php
              		foreach($forms as $k=>$val){
              			echo'<li>
                      <a href="#form_'.$val->id.'" data-toggle="tab" data-id="'.$val->id.'">';
                    if($this->session->userdata('permissions')->form_delete==1):  
                      echo'<span class="btn btn-danger btn-xs" data-href="'.base_url('form-delete/'.$val->id).'" onclick="delete_form(this)"><i class="fa fa-close"></i></span>';
                    endif;
                      echo $val->name.'</a></li>';
              		}
              	?>
              </ul>
            </div>

            <div class="col-xs-9">
              <!-- Tab panes -->
              <div class="tab-content" id="tab_result">
                
              </div>
            </div>

            <div class="clearfix"></div>

          </div>
        </div>
	</div>
</div>