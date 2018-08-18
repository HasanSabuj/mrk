<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->c_contact_add==1):?>
      	<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#customer_list_page_add_new_contacts" data-name="<?=$customer_data->name?>" data-id="<?=$customer_data->id?>"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->c_contact_trash==1):?>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('customer-contact-trash-list/'.$customer_data->id);?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Department</th>
              <th>Designation</th>
              <th>Phone & Email</th>
              <th>Vcard</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($contacts as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>'.$val->department.'</td>
			              <td>'.$val->designation.'</td>
			              <td>'.$val->phone.'<br/>'.$val->email.'</td>
			              <td class="text-center">'.($val->vcard?'<a href="'.base_url().'public/uploads/customer/contact/'.$val->vcard.'" download><img style="max-width:100px" src="'.base_url().'public/uploads/customer/contact/'.$val->vcard.'" /></a>':'').'</td>
			              <td>';
                    if($this->session->userdata('permissions')->c_contact_edit==1):
			              echo'<a class="btn btn-primary btn-xs" href="javascript:void()" data-toggle="modal" data-target="#customer_list_page_edit_contacts" data-id="'.$val->id.'" data-name="'.$val->name.'" data-department="'.$val->department.'" data-designation="'.$val->designation.'" data-phone="'.$val->phone.'" data-email="'.$val->email.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
                  endif;
                  if($this->session->userdata('permissions')->c_contact_delete==1):
                    echo'<a class="btn btn-danger btn-xs" href="'.base_url().'customer-contact-trash/'.$customer_data->id.'/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
<?php if($this->session->userdata('permissions')->c_contact_add==1):?>
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
          <div class="form-group">
            <label for="file" class="control-label">Visiting Card:</label>
            <input type="file" class="form-control" id="file" name="vcard">
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
<?php 
endif;
if($this->session->userdata('permissions')->c_contact_edit==1):
?>  
<!--Update Modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="customer_list_page_edit_contacts">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Edit Contacts</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="edit_contact" action="<?=base_url('contact-ajax-update')?>">
          <input id="id" name="id" type="hidden">
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
          <div class="form-group">
            <label for="file" class="control-label">Visiting Card:</label>
            <input type="file" class="form-control" id="file" name="vcard">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_contact">Update Now</button>
      </div>

    </div>
  </div>
</div>
<?php endif;?>