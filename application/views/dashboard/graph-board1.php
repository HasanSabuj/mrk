<div class="row">
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
      <?php
          $this->load->helper('date');
      ?>
        <div class="x_title">
          <h2>Daily Work Update</h2>
          <?php if($this->session->userdata('permissions')->aditional_task==1):?>
          &nbsp;&nbsp;<button class="btn btn-success btn-xs" data-id="" data-toggle="modal" data-target="#work_plan_add_customer" >Additional Task</button>
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
          <b>Today: 
            <?php
            $datestring = '%d/%m/%Y (%l)';
            $time = time();
            echo mdate($datestring, $time);
          ?></b>
          
          <table class="table table-striped " id="result_table">
            <?php
            $working_day_id=$plan[1];

              if(count($plan[0])>0){
                foreach($plan[0] as $k=>$val){
                  echo'
                    <tr>
                      <td style="width:30px;"><input type="checkbox" '.($val->status==1?'checked="checked"':'').' value="'.$val->id.'" onclick="update_status(this)"></td>
                      <td>
                      '.(!empty($val->customer_name)?'<b>Customer:</b> '.$val->customer_name.'<br/>':'').'
                      '.(!empty($val->principle_name)?'<b>Principle:</b> '.$val->principle_name.'<br/>':'').'
                      <b>Event:</b> '.$val->estimated_event.'
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

  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Calendar</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div id='calendar'></div>

      </div>
    </div>
  </div>
</div>
  
<div class="row">
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="form-group">
          <div class='input-group date' id='myDatepicker2'>
              <input type='text' class="form-control" id="daily_update_refresh_date" />
              <span class="input-group-addon">
                 <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
      </div>
      <div class="x_title">
        <h2>Daily Update Report <small>of</small> <small id="target_report_date">Yestertday</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <ul class="list-unstyled timeline" id="daily_update_report_content">
          <?php
            foreach($daily_update as $k=>$val){
              $user=$val[0]["user_name"];
              $profile_pic=$val[0]["profile_pic"];
                echo'<li>
                      <div class="block" style="min-height:145px;">
                        <div class="tags" data-toggle="tooltip" title="'.$user.'">
                          <a href="javascript:void(0)" class="tag">
                            <span>'.$user.'</span>
                          </a>
                        </div>';
                          if($profile_pic){
                              $user_file='./public/uploads/user/'.$profile_pic;
                              if(file_exists($user_file)){
                                echo'<div style="position:absolute;top:53px;left:0;max-width:85px">
                                        <img src="'.base_url().'public/uploads/user/'.$profile_pic.'" alt="image" class="img-circle" width="100%"/>
                                      </div>';
                              }
                            }
                        echo'<div class="block_content">';
                        foreach($val as $task){
                          echo'<h2 class="title '.($task["status"]==1?'green':'red').'">
                                <a>
                                 '.(!empty($task["customer_name"])?'Customer: '.$task["customer_name"].'</br>':'').'
                                 '.(!empty($task["principle_name"])?'Principle: '.$task["principle_name"].'</br>':'').'
                                 '.$task["estimated_event"].'
                                </a>
                            </h2>
                          <div class="byline">
                            <span>'.($task["update_time"]!='0000-00-00 00:00:00'?date("d-m-Y H:i a",strtotime($task["update_time"])):'No Report').'</a>
                          </div>
                          <p class="excerpt">'.$task["remark"].'</p>';
                          if($this->session->userdata('userRole')==1):
                            echo'<div class="form-group">
                              <label>MD Sir\'s Comment:</label>
                              <textarea class="form-control" data-id="'.$task["id"].'" onchange="u_report_comment(this)">'.$task["s_comments"].'</textarea>
                            </div>';
                          else:
                            echo'<div class="form-group">
                              <label>MD Sir\'s Comment:</label>
                              <p>'.$task["s_comments"].'</p>
                            </div>';
                          endif;

                        }
                          

                    echo'  </div>
                      </div>
                    </li>';
            }

          ?>
        </ul>
      </div>
    </div>
  </div> 
</div>

<div class="modal fade" id="event_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                <input type="hidden" id="start">
                <input type="hidden" id="end">
                    <div class="form-group">
                        <label>Event Title:</label>
                        <input id="title" name="title" type="text" class="form-control" />
                    </div>                            
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                       
                    </div>
                    <div class="form-group">
                        <label>Event Time:</label>
                        <input id="e_time" name="e_time" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
                        <span class="help-block">Click to pick a color</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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