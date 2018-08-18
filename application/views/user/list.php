<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->user_add==1):?>
      	<a class="btn btn-primary btn-xs" href="<?php echo base_url('user-add');?>"><span class="glyphicon glyphicon-plus"></span> Add New User</a>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->user_trash==1):?>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('user-trash-list');?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Name</th>
              <th>Phone</th>
              <th>Picture</th>
              <th>Designation</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($users as $k=>$val){
          			echo'<tr>
			              <td>'.$val->user_name.'</td>
			              <td>'.$val->phone.'</td>
			              <td>';
			              
							if($val->profile_pic){
							  $user_file='./public/uploads/user/'.$val->profile_pic;
							  if(file_exists($user_file)){
							    echo'<div class="image view view-first">
						                <a href="'.base_url().'public/uploads/user/'.$val->profile_pic.'" download><img style="max-width: 80px;" src="'.base_url().'public/uploads/user/'.$val->profile_pic.'" alt="image" /></a>
						              </div>';
							  }
							}
			              echo'</td>
			              <td>'.$val->des_name.'</td>
			              <td>'.($val->user_role==1?'Admin':($val->user_role==2?'Power User':'User')).'</td>
			              <td>'.($val->status==1?'Active':'Inactive').'</td>
			              <td>';
                    if($this->session->userdata('permissions')->previlege==1):
                      echo'<a class="btn btn-warning btn-xs" href="'.base_url('privilege-setup/'.$val->id).'"><span class="glyphicon glyphicon-lock"></span> Privilege</a>&nbsp;';
                    endif;
                    if($this->session->userdata('permissions')->user_edit==1):
                      echo'<a class="btn btn-primary btn-xs" href="'.base_url().'user-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
                    endif;
                    if($this->session->userdata('permissions')->user_delete==1):
                      echo'<a class="btn btn-danger btn-xs" href="'.base_url().'user-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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