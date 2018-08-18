<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->designation_add==1):?>
      	<a class="btn btn-primary btn-xs" href="<?php echo base_url('designation-add');?>"><span class="glyphicon glyphicon-plus"></span> Add New Designation</a>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->designation_trash==1):?>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('designation-trash-list');?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Designation Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($designations as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>';
                  if($this->session->userdata('permissions')->designation_edit==1):
                    echo'<a class="btn btn-primary btn-xs" href="'.base_url().'designation-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
                  endif;
                  if($this->session->userdata('permissions')->designation_delete==1):
                    echo'<a class="btn btn-danger btn-xs" href="'.base_url().'designation-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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