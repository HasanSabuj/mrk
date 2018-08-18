<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->service_add==1):?>
        <a href="<?=base_url('service-create')?>" class="btn btn-primary btn-xs">New Service</a> 
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->service_list==1):?>
          <a class="btn btn-primary btn-xs" href="<?=base_url('service-list')?>"><span class="glyphicon glyphicon-th-list"></span> Service List</a>
        <?php endif;?>
      <?php if($this->session->userdata('permissions')->service_trash_list==1):?>
        <a href="<?=base_url('service-trash-list')?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Trash List</a>
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
              <th>SR No.</th>
              <th>Close Note</th>
              <th>Closed By</th>
              <th>Closed At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($services as $k=>$val){
                echo'<tr>
              <td>SR-'.$val->id.'</td>
              <td>'.$val->close_note.'</td>
              <td>'.$val->user_name.'</td>
              <td>'.date("d/m/Y",strtotime($val->updated_at)).'</td>
              <td>';
            if($this->session->userdata('permissions')->service_close_move==1):
              echo'<a class="btn btn-success btn-xs" href="'.base_url().'service-close-move/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><i class="glyphicon glyphicon-ok-sign"></i> Move</a>&nbsp;';
            endif;
            //echo'<a class="btn btn-primary btn-xs" href="'.base_url().'job-event/'.$val->id.'"><i class="fa fa-book"></i> Event Register</a>&nbsp;';
              echo'<a class="btn btn-info btn-xs" href="'.base_url().'service-details/'.$val->id.'"><i class="fa fa-eye"></i> Details</a>&nbsp;';
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