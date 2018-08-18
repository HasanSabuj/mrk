<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('Calendar_model');
    }

    public function index(){
        
    	$data["page_title"] = "Dashboard";
        $role=$this->session->userdata('userRole');

        if($role==1){
            // admin
    	   

        }elseif($role==1){
            // power

        }else{
            //user

        }

        $daily_update=array();

        $this->load->model('MWork_plan');
        $plan=$this->MWork_plan->daily_plan($this->session->userdata('userId'));

        //if($role==1){}
         $daily_update_report_data=$this->MWork_plan->daily_update_report();

         foreach($daily_update_report_data as $value){
            $daily_update[$value["user_id"]][]=$value;
         }
        

        $data["main_content"] = $this->load->view('dashboard/graph-board1',['plan'=>$plan,'daily_update'=>$daily_update],true);

       $data["page_css"]='
            <style>
                #customer_search_result{position:relative;}
                #customer_search_result ul{
                    margin: 0px;
                    padding: 0px;
                    position: absolute;
                    z-index: 999;
                    list-style: none;
                    background: #fff;
                    display: block;
                    width: 100%;
                    max-height: 250px;
                    overflow: auto;}
                #customer_search_result ul li{cursor:pointer;}
                #customer_search_result ul li:hover{background:#edededed}

                #principle_search_result{position:relative;}
                #principle_search_result ul{
                    margin: 0px;
                    padding: 0px;
                    position: absolute;
                    z-index: 999;
                    list-style: none;
                    background: #fff;
                    display: block;
                    width: 100%;
                    max-height: 250px;
                    overflow: auto;}
                #principle_search_result ul li{cursor:pointer;}
                #principle_search_result ul li:hover{background:#edededed}    
            </style>
       ';

       $data["page_script"] = '
            <script src="'.base_url().'public/js/calander-main.js"></script>

            ';
          
        $data["page_script"].='
        <script>
            $(document).ready(function() {
                $("#myDatepicker2").datetimepicker({
                    format: \'YYYY-MM-DD\',
                    useCurrent: false
                }).on("dp.change", function (ev) {
                    update_daily_report_content();
                });



                // insert modal on hide 
                $("#work_plan_add_customer").on("hide.bs.modal", function (event) {
                  var modal = $(this)
                  modal.find(".modal-body input#customer_for_work_plan").val("")
                  modal.find(".modal-body input#principle_for_work_plan").val("")
                  modal.find(".modal-body input#customer_id").val("")
                  modal.find(".modal-body input#principle_id").val("")
                  modal.find(".modal-body textarea#estimated_event").val("")
                  modal.find(".modal-body #message_show_area").empty()
                });

                $("#customer_for_work_plan").keyup(function(){
                    //alert("adsfadf");
                    var cust_name=$(this).val();
                    $.post("'.base_url('ajax-customer-search').'",{cust_name:cust_name},function(data){
                        $("#customer_search_result ul").html(data);
                        //alert(data);
                    })
                });

                $("#principle_for_work_plan").keyup(function(){
                    //alert("adsfadf");
                    var prin_name=$(this).val();
                    $.post("'.base_url('ajax-principle-search').'",{prin_name:prin_name},function(data){
                        $("#principle_search_result ul").html(data);
                        //alert(data);
                    })
                });


                // insert event for work plan 
                $("#save_event").click(function(){
                    $(this).prop("disabled",true);
                    var url = $("#work_plan_add_form").attr(\'action\')
                    $.post(url,$("#work_plan_add_form").serialize(),function(response){
                        $("#save_event").prop("disabled",false);
                        //location.reload();
                        if(response==1){
                            $("#work_plan_add_form").find("#customer_id").val("")
                            $("#work_plan_add_form").find("#customer_for_work_plan").val("")
                            $("#work_plan_add_form").find("#principle_id").val("")
                            $("#work_plan_add_form").find("#principle_for_work_plan").val("")
                            $("#work_plan_add_form").find("#estimated_event").val("")

                            $(".modal-body").find("#message_show_area").html(\'<div class="alert alert-success">\
                              <button class="close" data-dismiss="alert">×</button>\
                              <strong>Success!</strong> Event Added\
                            </div>\')

                            // load result content 
                            var work_day_id=$("#work_plan_add_form").find("#working_day_id").val();
                            load_table_content_of_selected_working_day_id(work_day_id);

                        }else{
                            $(".modal-body").find("#message_show_area").html(\'<div class="alert alert-info">\
                              <button class="close" data-dismiss="alert">×</button>\
                              <strong>Info!</strong> Ops! something went wrong\
                            </div>\')
                        }
                    })
                })

                // customer list clear 
                $("#clear_customer_list").click(function(){
                      var modal = $("#work_plan_add_customer")
                      modal.find(".modal-body input#customer_for_work_plan").val("")
                      modal.find(".modal-body input#customer_id").val("")
                      modal.find(".modal-body #customer_search_result ul").empty()
                })

                // principle list clear 
                $("#clear_principle_list").click(function(){
                      var modal = $("#work_plan_add_customer")
                      modal.find(".modal-body input#principle_for_work_plan").val("")
                      modal.find(".modal-body input#principle_id").val("")
                      modal.find(".modal-body #principle_search_result ul").empty()
                })

                $("#daily_update_send").click(function(){
                    alert("Daily update successfully submited");
                })


            });

            // daily update report Comment
            function u_report_comment(data){
                var id=$(data).attr("data-id");
                var value=$(data).val();

                $.post("'.base_url('u_report_comment').'",{id:id,value:value},function(result){
                    $.noop();
                })
            }


            function select_this_customer(data){
                var customer_id = $(data).attr("data-id");
                var customer_name = $(data).text();
                $("#customer_id").val(customer_id);
                $("#customer_for_work_plan").val(customer_name);
                $("#customer_search_result ul").empty();
                $("#estimated_event").focus();
            }


            function select_this_principle(data){
                var principle_id = $(data).attr("data-id");
                var principle_name = $(data).text();
                $("#principle_id").val(principle_id);
                $("#principle_for_work_plan").val(principle_name);
                $("#principle_search_result ul").empty();
                $("#estimated_event").focus();
            }

            function load_table_content_of_selected_working_day_id(id){
                $.post("'.base_url('get-working-plan-detail-by-id-for-table/"+id+"').'",{id:id},function(result){
                    $("#result_table").html(result);
                })
            }

            function update_status(data){
                var id= $(data).val();
                var status;
                if (!$(data).is(":checked")) {
                    // not checked 
                    status=0;
                }else{
                    // checked 
                    status=1;
                }

                $.post("'.base_url('update-work-plan-status').'",{id:id,status:status},function(response){
                    $.noop();
                });
            }

            function update_details(data){
                var id= $(data).attr("data-id");
                var remark= $(data).val();
                $.post("'.base_url('update-work-plan-details').'",{id:id,remark:remark},function(response){
                    $.noop();
                });

            }

            function daily_update_send(){
                alert("Daily update successfully submited");
            }


            function update_daily_report_content(){
                var target_date=$("#daily_update_refresh_date").val();
                //alert(target_date);
                $.post("'.base_url('daily-update-report-refresh').'",{target_date:target_date},function(response){
                    $("#target_report_date").html(target_date);
                    $("#daily_update_report_content").html(response);
                });
            }

        </script>
        ';  
          
       

    	$this->load->view('master',$data);
    }

    // daily update report comment
    public function u_report_comment(){
        $this->load->model('MWork_plan');
        $this->MWork_plan->u_report_comment();
    }
    /*Get all Events */

    Public function getEvents()
    {
        $result=$this->Calendar_model->getEvents();
        echo json_encode($result);
    }
    /*Add new event */
    Public function addEvent()
    {
        $result=$this->Calendar_model->addEvent();
        echo $result;
    }
    /*Update Event */
    Public function updateEvent()
    {
        $result=$this->Calendar_model->updateEvent();
        echo $result;
    }
    /*Delete Event*/
    Public function deleteEvent()
    {
        $result=$this->Calendar_model->deleteEvent();
        echo $result;
    }
    Public function dragUpdateEvent()
    {   

        $result=$this->Calendar_model->dragUpdateEvent();
        echo $result;
    }


    public function daily_update_report_refresh(){
        $date_value=$this->input->post('target_date',TRUE);

        $this->load->model('MWork_plan');
        $daily_update_report_data=$this->MWork_plan->daily_update_report($date_value);
        if(count($daily_update_report_data)>0){

         foreach($daily_update_report_data as $value){
            $daily_update[$value["user_id"]][]=$value;
         }

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
        }else{
            echo'<li>
                    No data found
            </li>';
        }
    }

    // email service
    public function mail_method(){
        $data["page_title"]='eMail Service';
        $data["main_content"]=$this->load->view('eMail','',TRUE);
        $data["last_script"]='
        <script>
            $(document).ready(function(){
                $MENU_TOGGLE.click();
            })
        </script>
        ';
        $this->load->view('master',$data);
    }

}