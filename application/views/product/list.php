<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      	<a class="btn btn-primary btn-xs" href="<?php echo base_url('product-add');?>"><span class="glyphicon glyphicon-plus"></span> Add New Product</a>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('product-trash-list');?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Product Name</th>
              <th>Requirement Form</th>
              <th>Created By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($products as $k=>$val){
          			echo'<tr>
                    <td>'.$val->name.'</td>
			              <td data-fid="'.$val->requirement_form_id.'" data-toggle="modal" data-target="#form_element_show">'.$val->form_name.'</td>
                    <td>'.$val->user_name.'</td>
			              <td><a class="btn btn-primary btn-xs" href="'.base_url().'product-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;<a class="btn btn-danger btn-xs" href="'.base_url().'product-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a></td>
			            </tr>';
          		}
          	?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="form_element_show">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>