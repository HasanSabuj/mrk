<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->job_add==1):?>
        <a href="<?=base_url('job-create')?>" class="btn btn-primary btn-xs">New Job</a> 
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->job_list==1):?>
          <a class="btn btn-primary btn-xs" href="<?=base_url('job-list')?>"><span class="glyphicon glyphicon-th-list"></span> Job List</a>
        <?php endif;?>
      <?php if($this->session->userdata('permissions')->job_trash==1):?>
        <a href="<?=base_url('job-trash-list')?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Trash List</a>
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
              <th>Taks No.</th>
              <th>Custom No.</th>
              <th>Close Note</th>
              <th>Status</th>
              <th>Closed By</th>
              <th>Closed At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($jobs as $k=>$val){
                echo'<tr>
              <td>'.($val->type==1?'T-'.$val->id:($val->type==2?'CM-'.$val->id:($val->type==3?'MHD'.$val->id:''))).'</td>
              <td>'.$val->custome_no.'</td>
              <td>'.$val->close_note.'</td>
              <td>'.($val->flag==1?'Won':'Lost').'</td>
              <td>'.$val->user_name.'</td>
              <td>'.date("d/m/Y",strtotime($val->updated_at)).'</td>
              <td>';
            if($this->session->userdata('permissions')->job_close_move==1):
              echo'<a class="btn btn-success btn-xs" href="'.base_url().'job-close-move/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><i class="glyphicon glyphicon-ok-sign"></i> Move</a>&nbsp;';
            endif;
            echo'<a class="btn btn-primary btn-xs" href="'.base_url().'job-event/'.$val->id.'"><i class="fa fa-book"></i> Event Register</a>&nbsp;';
              echo'<a class="btn btn-info btn-xs" href="'.base_url().'job-details/'.$val->id.'"><i class="fa fa-eye"></i> Details</a>&nbsp;';
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