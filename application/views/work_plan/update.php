<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <b>Today: 
          <?php
          $datestring = '%d/%m/%Y (%l)';
          $time = time();
          echo mdate($datestring, $time);
        ?></b>
        <?php if($this->session->userdata('permissions')->aditional_task==1):?>
        &nbsp;&nbsp;<button class="btn btn-success btn-xs" data-id="" data-toggle="modal" data-target="#work_plan_add_customer" >Additional Task</button>
        <?php endif;?>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-striped " id="result_table">
          <?php
          if($working_day_id==0){
            $working_day_id='';
          }else{
            $working_day_id=$working_day_id;
          }

            if(count($plan)>0){
              foreach($plan as $k=>$val){
                echo'
                  <tr>
                    <td style="width:30px;"><input type="checkbox" '.($val->status==1?'checked="checked"':'').' value="'.$val->id.'" onclick="update_status(this)"></td>
                    <td>
                     '.(!empty($val->customer_name)?'<b>Customer:</b> '.$val->customer_name.' <br/>':'').'
                     '.(!empty($val->principle_name)?'<b>Principle:</b> '.$val->principle_name.' <br/>':'').'
                     '.$val->estimated_event.'
                     </td>
                  </tr>
                  <tr>  
                    <td colspan="2">
                      <textarea placeholder="Describe Detail of Above Task" class="form-control textarea" onchange="update_details(this)" data-id="'.$val->id.'">'.$val->remark.'</textarea>
                    </td>
                  </tr>
                ';
                $working_day_id=$val->working_day_id;
              }

              echo'<tr>
                  <td colspan="2" class="text-center">
                    <button class="btn btn-success" id="daily_update_send">Update</button>
                  </td>
                </tr>';

            }else{
              echo'
                <tr>
                  <td>No pre plan available</td>
                </tr>
              ';
            }
          ?>
        </table>
      </div>
    </div>
  </div>
</div>      
<?php if($this->session->userdata('permissions')->aditional_task==1):?>
<!--Insert Modal-->
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true" id="work_plan_add_customer">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Add New</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="work_plan_add_form" action="<?=base_url('work-plan-event-ajax-add')?>">
          <input id="working_day_id" name="working_day_id" type="hidden" value="<?=$working_day_id?>">
          <input id="customer_id" name="customer_id" type="hidden">
          <input id="principle_id" name="principle_id" type="hidden">
          <div class="form-group">
            <label for="customer" class="control-label">Customer:</label>
            <div class="input-group">
            <input type="text" class="form-control" id="customer_for_work_plan" placeholder="Search Customer">
            <span class="input-group-addon"  id="clear_customer_list">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </span>
            </div>
            <div id="customer_search_result">
              <ul></ul>
            </div>
          </div>
          <div class="form-group">
            <label for="principle" class="control-label">Principle:</label>
            <div class="input-group">
            <input type="text" class="form-control" id="principle_for_work_plan" placeholder="Search Principle">
            <span class="input-group-addon"  id="clear_principle_list">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </span>
            </div>
            <div id="principle_search_result">
              <ul></ul>
            </div>
          </div>
          <div class="form-group">
            <label for="estimated_event" class="control-label">Estimated Event:</label>
            <textarea class="form-control" name="estimated_event" id="estimated_event"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_event">Add Now</button>
      </div>

    </div>
  </div>
</div>
<?php endif;?>