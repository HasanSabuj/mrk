<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->department_add==1):?>
      	<a class="btn btn-primary btn-xs" href="<?php echo base_url('department-add');?>"><span class="glyphicon glyphicon-plus"></span> Add New Department</a>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->department_trash==1):?>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('department-trash-list');?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Department Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($departments as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>';
                    if($this->session->userdata('permissions')->department_edit==1):
                    echo'<a class="btn btn-primary btn-xs" href="'.base_url().'department-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
                  endif;
                  if($this->session->userdata('permissions')->department_delete==1):
                    echo'<a class="btn btn-danger btn-xs" href="'.base_url().'department-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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