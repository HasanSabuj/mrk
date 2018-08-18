<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      
      <div class="x_content">
        
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Task No.</th>
              <th>Custom No.</th>
              <th>Customer</th>
              <th>Offer By</th>
              <th>Task Position</th>
              <th>Drawing By</th>
              <th>Revise/Initial</th>
              <th>Visit Site</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($jobs as $k=>$val){
                echo'<tr>
              <td>'.($val->type==1?'T-'.$val->id:($val->type==2?'CM-'.$val->id:($val->type==3?'MHD-'.$val->id:''))).'</td>
              <td>'.$val->custome_no.'</td>
              <td>'.$val->customer_name.'</td>
              <td><input type="text" value="'.$val->offer_by.'" name="offer_by" id="offer_by" onchange="update_this_in_job_master(this,'.$val->id.')"></td>
              <td>
                <select name="de_job_position" id="de_job_position" onchange="update_this_in_job_master(this,'.$val->id.')">
                  <option value="0">Not Started</option>
                  <option value="1" '.($val->de_job_position==1?'selected':'').'>Cancel</option>
                  <option value="2" '.($val->de_job_position==2?'selected':'').'>Pending</option>
                  <option value="3" '.($val->de_job_position==3?'selected':'').'>Working</option>
                  <option value="4" '.($val->de_job_position==4?'selected':'').'>Complete</option>
                </select>
              </td>
              <td><input type="text" value="'.$val->drawing_by.'" name="drawing_by" id="drawing_by" onchange="update_this_in_job_master(this,'.$val->id.')"></td>
              <td>
                <select name="de_ini_rev" id="de_ini_rev" onchange="update_this_in_job_master(this,'.$val->id.')">
                  <option value="0">Select</option>
                  <option value="1" '.($val->de_ini_rev==1?'selected':'').'>Initial</option>
                  <option value="2" '.($val->de_ini_rev==2?'selected':'').'>Revise</option>
                </select>
              </td>
              <td>
              	<select name="visit_site" id="visit_site" onchange="update_this_in_job_master(this,'.$val->id.')">
              		<option value="0">Select</option>
              		<option value="1" '.($val->visit_site==1?'selected':'').'>Yes</option>
                  <option value="2" '.($val->visit_site==2?'selected':'').'>No</option>
              		<option value="3" '.($val->visit_site==3?'selected':'').'>Needed</option>
              	</select>
              </td>
              
              <!--<td>
              	<select name="de_approved_by_cus" id="de_approved_by_cus" onchange="update_this_in_job_master(this,'.$val->id.')">
              		<option value="0">Select</option>
              		<option value="1" '.($val->de_approved_by_cus==1?'selected':'').'>Yes</option>
              		<option value="2" '.($val->de_approved_by_cus==2?'selected':'').'>No</option>
              	</select>
              </td>-->
              <td>
                <textarea name="de_remark" id="de_remark" onchange="update_this_in_job_master(this,'.$val->id.')" class="form-control">'.$val->de_remark.'</textarea>
              </td>
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