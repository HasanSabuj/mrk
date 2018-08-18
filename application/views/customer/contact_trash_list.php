<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      	<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#customer_list_page_add_new_contacts" data-name="<?=$customer_data->name?>" data-id="<?=$customer_data->id?>"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>
      	<a class="btn btn-success btn-xs" href="<?php echo base_url('customer-contact-list/'.$customer_data->id);?>"><span class="glyphicon glyphicon-th-list"></span> Contact List</a>
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
              <th>Name</th>
              <th>Deleted By</th>
              <th>Deleted At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($contacts as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>'.$val->user_name.'</td>
			              <td>'.nice_date($val->deleted_at,"d/m/Y h:i a").'</td>
                    <td><a class="btn btn-success btn-xs" href="'.base_url().'customer-contact-trash-to-main/'.$customer_data->id.'/'.$val->id.'" onclick="return confirm(\'Are you want to move it again in main list?\')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Move</a></td>
			            </tr>';
          		}
          	?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--Insert Modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="customer_list_page_add_new_contacts">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Add New Contacts</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="add_new_contact" action="<?=base_url('contact-ajax-add')?>">
          <input id="customer_id" name="customer_id" type="hidden">
          <div class="form-group">
            <label for="customer" class="control-label">Customer:</label>
            <input type="text" class="form-control" id="customer" readonly>
          </div>
          <div class="form-group">
            <label for="name" class="control-label">Name <sup>*</sup>:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="department" class="control-label">Department:</label>
            <input type="text" class="form-control" id="department" name="department">
          </div>
          <div class="form-group">
            <label for="designation" class="control-label">Designation:</label>
            <input type="text" class="form-control" id="designation" name="designation">
          </div>
          <div class="form-group">
            <label for="phone" class="control-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_contact">Add Now</button>
      </div>

    </div>
  </div>
</div>
