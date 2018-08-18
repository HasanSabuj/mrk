<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->service_add==1):?>
        <a href="<?=base_url('service-create')?>" class="btn btn-primary btn-xs">New Service</a> 
      <?php endif;?>
      <?php if($this->session->userdata('permissions')->service_close_list==1):?>
        <a href="<?=base_url('service-close-list')?>" class="btn btn-warning btn-xs"><i class="fa fa-times"></i> Closed Service List</a>
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
              <th>Service No.</th>
              <th>Product</th>
              <th>Customer</th>
              <th>Contact</th>
              <th>Handler</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($services as $k=>$val){
                if($val->products){
                  $sql="select group_concat(name SEPARATOR '<br> ') as product_name from products where id in(".$val->products.")";
                  $items=$this->db->query($sql)->row();
                  $items=$items->product_name;
                }else{
                  $items='';
                }
                echo'<tr>
              <td>SR-'.$val->id.'</td>
              <td>'.$items.'</td>
              <td>'.$val->customer_name.'</td>
              <td>
              <span data-target="#contact_details_show" data-toggle="modal" data-designation="'.$val->designation.'" data-department="'.$val->department.'" data-email="'.$val->email.'" data-phone="'.$val->phone.'">'.$val->contact_name.'</span>
              </td>
              <td>';
              if($val->handler_name):
                echo'<b>'.$val->handler_name.' ('.$val->handler_desig.')</b>';
              endif;
              echo'</td>
              <td>'.$val->user_name.'</td>
              <td>'.date("d/m/Y",strtotime($val->created_at)).'</td>
              <td>';
            if($this->session->userdata('permissions')->service_handler==1):
              echo'<a class="btn btn-info btn-xs" href="'.base_url().'service-handler/'.$val->id.'"><i class="fa fa-users"></i> Handler</a>&nbsp;';
            endif;
            echo'<a class="btn btn-primary btn-xs" href="'.base_url().'service-event/'.$val->id.'"><i class="fa fa-book"></i> Event Register</a>&nbsp;';


            if($this->session->userdata('permissions')->service_close==1):
              echo'<a class="btn btn-warning btn-xs" href="'.base_url().'service-close/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-times"></i> Close</a>&nbsp;';
            endif;

            echo'<a class="btn btn-info btn-xs" href="'.base_url().'service-details/'.$val->id.'" target="_blank"><i class="fa fa-folder-open"></i> Details</a>&nbsp;';

            if($this->session->userdata('permissions')->service_edit==1):
              echo'<a class="btn btn-primary btn-xs" href="'.base_url().'service-edit/'.$val->id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>&nbsp;';
            endif;
            if($this->session->userdata('permissions')->service_delete==1):
              echo'<a class="btn btn-danger btn-xs" href="'.base_url().'service-trash/'.$val->id.'" onclick="return confirm(\'Are you sure?\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
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