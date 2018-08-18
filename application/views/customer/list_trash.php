<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->customer_add==1):?>
      	<a href="<?=base_url('customer-add')?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Add New Customer</a>&nbsp;
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->customer_list==1):?>  
        <a href="<?=base_url('customer-list')?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-th-list"></span> Customer List</a>
      <?php endif;?>  
        <ul class="nav navbar-right panel_toolbox">		
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
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
              <th>Customer Name</th>
              <th>Customer Type</th>
              <th>Category</th>
              <th>Deleted By</th>
              <th>Deleted At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($customers as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>'.$val->type.'</td>
			              <td>'.($val->cust_cat==1?'Intensive care':($val->cust_cat==2?'Existing':($val->cust_cat==3?'Less Important':'Prospect'))).'</td>
			              <td>'.$val->user_name.'</td>
			              <td>'.nice_date($val->deleted_at,"d/m/Y h:i a").'</td>
			              <td>';
                    if($this->session->userdata('permissions')->customer_move==1):
                    echo'<a class="btn btn-success btn-xs" href="'.base_url().'customer-trash-to-main/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Move</a>';
                    endif;
                    echo'</td>
			            </tr>';
          		}
          	?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>