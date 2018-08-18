<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->customer_add==1):?>
        <a href="<?=base_url('customer-add')?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Add New Customer</a>&nbsp;
        <?php 
        endif;
        if($this->session->userdata('permissions')->customer_trash==1):
        ?>
        <a href="<?=base_url('customer-trash-list')?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Trash List</a>
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
              <th>Contacts</th>
              <th>Customer Type</th>
              <th>Category</th>
              <th>Created By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php

              foreach($customers as $k=>$val){
                $contacts_data=array_keys(array_column($contacts,'customer_id'),$val->id);
                echo'<tr>
              <td>'.$val->name.'</td>
              <td>';
                if(count($contacts_data)>0){
                  foreach($contacts_data as $thisData){
                    echo'<span data-target="#contact_details_show" data-toggle="modal" data-designation="'.$contacts[$thisData]["designation"].'" data-department="'.$contacts[$thisData]["department"].'" data-email="'.$contacts[$thisData]["email"].'" data-phone="'.$contacts[$thisData]["phone"].'">'.$contacts[$thisData]["name"].'</span><br/>';
                  }
                }
              echo'</td>
              <td>'.$val->customer_type_name.'</td>
              <td>'.($val->cust_cat==1?'Very Important':($val->cust_cat==2?'Existing':($val->cust_cat==3?'Less Important':'Prospect'))).'</td>
              <td>'.$val->user_name.'</td>
              <td>';
            if($this->session->userdata('permissions')->c_contact_add==1):
              echo'<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#customer_list_page_add_new_contacts" data-name="'.$val->name.'" data-id="'.$val->id.'"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>&nbsp;';
            endif;
            if($this->session->userdata('permissions')->c_contact_list==1):
              echo'<a class="btn btn-success btn-xs" href="'.base_url().'customer-contact-list/'.$val->id.'"><i class="fa fa-group"></i> Contacts</a>&nbsp;';
            endif;

            echo'<a class="btn btn-info btn-xs" href="'.base_url().'customer-details/'.$val->id.'" target="_blank"><i class="fa fa-folder-open"></i> Details</a>&nbsp;';
            
            if($this->session->userdata('permissions')->customer_edit==1):  
              echo'<a class="btn btn-primary btn-xs" href="'.base_url().'customer-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
            endif;  
            if($this->session->userdata('permissions')->customer_delete==1):
              echo'<a class="btn btn-danger btn-xs" href="'.base_url().'customer-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
        <form method="post" id="add_new_contact" action="<?=base_url('contact-ajax-add')?>" enctype="multipart/form-data">
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

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="contact_details_show">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2"></h4>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td>Department</td>
            <td>&nbsp;:&nbsp;</td>
            <td id="myModalDepartment"></td>
          </tr>
          <tr>
            <td>Designation</td>
            <td>&nbsp;:&nbsp;</td>
            <td id="myModalDesignation"></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>&nbsp;:&nbsp;</td>
            <td id="myModalEmail"></td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>&nbsp;:&nbsp;</td>
            <td id="myModalPhone"></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>