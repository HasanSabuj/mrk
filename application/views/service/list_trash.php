<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->service_add==1):?>
      	<a href="<?=base_url('service-create')?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> New Service</a>&nbsp;
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->service_list==1):?>
        <a href="<?=base_url('service-list')?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-th-list"></span> Service List</a>
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
              <th>SR No.</th>
              <th>Deleted By</th>
              <th>Deleted At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($services as $k=>$val){
          			echo'<tr>
			              <td>SR-'.$val->id.'</td>
			              <td>'.$val->user_name.'</td>
			              <td>'.nice_date($val->deleted_at,"d/m/Y h:i a").'</td>
			              <td>';
                  if($this->session->userdata('permissions')->service_move==1):
                    echo'<a class="btn btn-success btn-xs" href="'.base_url().'service-trash-to-main/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Move</a>';
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