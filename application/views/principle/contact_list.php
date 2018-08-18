<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->p_contact_add==1):?>
      	<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#principle_add_new_contacts" data-name="<?=$principle_data->name?>" data-id="<?=$principle_data->id?>"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->p_contact_trash==1):?>
      	<a class="btn btn-danger btn-xs" href="<?php echo base_url('principle-contact-trash-list/'.$principle_data->id);?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash List</a>
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
              <th>Designation</th>
              <th>Field</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Visiting<br/>Card</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		foreach($contacts as $k=>$val){
          			echo'<tr>
			              <td>'.$val->name.'</td>
			              <td>'.$val->designation.'</td>
			              <td>'.$val->job_field.'</td>
			              <td>'.$val->phone.'</td>
			              <td>'.$val->email.'</td>
                    <td>'.($val->visiting_card?'<a href="data:image/jpeg;base64,'.base64_encode( $val->visiting_card ).'" download><img style="max-width: 100px; display: block;" src="data:image/jpeg;base64,'.base64_encode( $val->visiting_card ).'" alt="image" /></a>':'').'</td>
			              <td>';
                    if($this->session->userdata('permissions')->p_contact_edit==1):
			              echo'<a class="btn btn-primary btn-xs" href="javascript:void()" data-toggle="modal" data-target="#principle_list_page_edit_contacts" data-id="'.$val->id.'" data-name="'.$val->name.'" data-field="'.$val->job_field.'" data-designation="'.$val->designation.'" data-phone="'.$val->phone.'" data-email="'.$val->email.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
                  endif;
                  if($this->session->userdata('permissions')->p_contact_delete==1):
                    echo'<a class="btn btn-danger btn-xs" href="'.base_url().'principle-contact-trash/'.$principle_data->id.'/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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
<?php if($this->session->userdata('permissions')->p_contact_add==1):?>
<!--Insert Modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="principle_add_new_contacts">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Add New Contacts</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="add_new_contact" action="<?=base_url('principle-contact-ajax-add')?>">
          <input id="principle_id" name="principle_id" type="hidden">
          <div class="form-group">
            <label for="principle" class="control-label">Principle:</label>
            <input type="text" class="form-control" id="principle" readonly>
          </div>
          <div class="form-group">
            <label for="name" class="control-label">Name <sup>*</sup>:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="designation" class="control-label">Designation:</label>
            <input type="text" class="form-control" id="designation" name="designation">
          </div>
          <div class="form-group">
            <label for="job_field" class="control-label">Field:</label>
            <input type="text" class="form-control" id="job_field" name="job_field">
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
            <label class="control-label" for="pic">Visiting Card</label>
            <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="visiting_card" accept="image/gif, image/jpeg, image/png">
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
if($this->session->userdata('permissions')->p_contact_edit==1):
?>
<!--Update Modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="principle_list_page_edit_contacts">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Edit Contacts</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="edit_contact" action="<?=base_url('principle-contact-ajax-update')?>">
          <input id="id" name="id" type="hidden">
          <div class="form-group">
            <label for="name" class="control-label">Name <sup>*</sup>:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="designation" class="control-label">Designation:</label>
            <input type="text" class="form-control" id="designation" name="designation">
          </div>
          <div class="form-group">
            <label for="job_field" class="control-label">Field:</label>
            <input type="text" class="form-control" id="job_field" name="job_field">
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
            <label class="control-label" for="pic">Visiting Card</label>
            <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="visiting_card" accept="image/gif, image/jpeg, image/png">
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