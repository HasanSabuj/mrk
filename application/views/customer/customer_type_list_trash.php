<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->c_type_add==1):?>
      	<a class="btn btn-primary btn-xs" href="<?php echo base_url('customer-type-add');?>"><span class="glyphicon glyphicon-plus"></span> Add New Customer Type</a>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->c_type_list==1):?>
      	<a class="btn btn-success btn-xs" href="<?php echo base_url('customer-type-list');?>"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Customer Type List</a>
      <?php endif;?>
        <ul class="nav navbar-right panel_toolbox">		
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Customer Type Name</th>
              <th>Deleted By</th>
              <th>Deleted At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($customer_type as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>'.$val->user_name.'</td>
			              <td>'.nice_date($val->deleted_at,"d/m/Y h:i a").'</td>
			              <td>';
                    if($this->session->userdata('permissions')->c_type_move==1):
                    echo'<a class="btn btn-success btn-xs" href="'.base_url().'customer-type-trash-to-main/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Move</a>';
                  endif;

                  echo' </td>
			            </tr>';
          		}
          	?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>