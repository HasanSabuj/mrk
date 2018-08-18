<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_plan extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MWork_plan');
    }

    public function index(){
    	$role=$this->session->userdata('userRole');

    	$data["page_title"] = "Monthly Work Plan";
		$data["main_content"] = $this->load->view('work_plan/view','',true);
		$data['page_css'] = '
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
		<script>
			$(document).ready(function() {

			  $("#txtDate").datetimepicker({
                    format: \'MMM-YYYY\',
                    useCurrent: false
                })

			  $("#select").click(function(){
			  	var data = $("#txtDate").val();
			  	if(data){
			  		$("#msg_area").html("");
				  	$(this).val("wait...").attr("disabled","disabled");
				  	$.post("'.base_url('ajax-get-work-plan').'",{data:data},function(response){
				  		$("#select").val("Select").removeAttr("disabled");
				  		$("#plan_content").html(response);
				  		$(".page_title_text").show();
				  	})
			  	}else{
			  		$("#msg_area").html(\'<div class="alert alert-info alert-dismissible">\
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
					  <strong>Info!</strong> Please Select a Month First.\
					</div>\');
			  		
			  	}
			  });

			  // insert modal on show 
			  $("#work_plan_add_customer").on("show.bs.modal", function (event) {
				  var button = $(event.relatedTarget) // Button that triggered the modal
				  var working_day_id = button.data("id")
				  var modal = $(this)
				  modal.find(".modal-body input#working_day_id").val(working_day_id)
				});	

				// insert modal on hide 
				  $("#work_plan_add_customer").on("hide.bs.modal", function (event) {
					  var modal = $(this)
					  modal.find(".modal-body input#customer_for_work_plan").val("")
					  modal.find(".modal-body input#customer_id").val("")
					  modal.find(".modal-body input#principle_for_work_plan").val("")
					  modal.find(".modal-body input#principle_id").val("")
					  modal.find(".modal-body input#working_day_id").val("")
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
					var url = $("#work_plan_add_form").attr(\'action\')
					$.post(url,$("#work_plan_add_form").serialize(),function(response){
						//console.log(response);
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
					        load_result_content_of_selected_working_day_id(work_day_id);
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
				$("#clear_principle_list").click(function(){
					  var modal = $("#work_plan_add_customer")
					  modal.find(".modal-body input#principle_for_work_plan").val("")
					  modal.find(".modal-body input#principle_id").val("")
					  modal.find(".modal-body #customer_search_result ul").empty()
				})

			});


			function printDiv() {
				$(".btn-xs").hide();
		        //Get the HTML of div
		        var divElements = document.getElementById("plan_content").innerHTML;
		        var oldPage = document.body.innerHTML;
		        document.body.innerHTML = 
		          "<html><head><title></title></head><body>" + 
		          divElements + "</body>";
		  
		        var css = "@page { size: landscape; }",
		          head = document.head || document.getElementsByTagName(\'head\')[0],
		          style = document.createElement(\'style\');

		        style.type = \'text/css\';
		        style.media = \'print\';

		        if (style.styleSheet){
		            style.styleSheet.cssText = css;
		        } else {
		            style.appendChild(document.createTextNode(css));
		        }

		        head.appendChild(style);
		        //Print Page
		        window.print();
		        //Restore orignal HTML
		        document.body.innerHTML = oldPage;

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

			function load_result_content_of_selected_working_day_id(id){
				$.post("'.base_url('get-working-plan-detail-by-id/"+id+"').'",{id:id},function(result){
					$("#result_"+id+"").html(result);
				})
			}

			function remove_event_plan(data){
				if(confirm(\'Are you sure?\')){
					var id= $(data).parent().attr("data-id");
					$.post("'.base_url('remove-event-plan/"+id+"').'",{id:id},function(result){
						 // load result content
				        load_result_content_of_selected_working_day_id(result);
					})
				}
			}

		</script>
		';
		$this->load->view('master',$data);

    }

    public function get_work_plan(){
    	$user=$this->session->userdata('userId');
    	$date_value=$this->input->post('data',true);
    	$new_date = date("Y-m-01", strtotime($date_value));

    	$data=$this->MWork_plan->get_data_by_user_id($user,$new_date);
    	$this->load->helper('date');
    	$content=$this->load->view('work_plan/table',['data'=>$data],true);
    	echo $content;
    }

    // customer search
    public function cust_search(){
    	$user_role=$this->session->userdata('userRole');
    	$cust=$this->input->post('cust_name',true);
    	$this->load->model('MCustomers');
    	$data=$this->MCustomers->get_customer($user_role,$cust);
    	$return_string="";
    	foreach($data as $k=>$val){
    		$return_string.="
    			<li data-id='".$val->id."' onclick='select_this_customer(this)'>".$val->name."</li>
    		";
    	}

    	echo $return_string;
    }
    // principle search
    public function princ_search(){
    	$user_role=$this->session->userdata('userRole');
    	$princ=$this->input->post('prin_name',true);
    	$this->load->model('MPrinciples');
    	$data=$this->MPrinciples->get_principle($princ);
    	$return_string="";
    	foreach($data as $k=>$val){
    		$return_string.="
    			<li data-id='".$val->id."' onclick='select_this_principle(this)'>".$val->name."</li>
    		";
    	}

    	echo $return_string;
    }


    // work plan event insert for setup 
    public function plan_event_insert(){
    	$data["working_day_id"] = $this->input->post('working_day_id',TRUE);
    	$data["customer_id"] = $this->input->post('customer_id',TRUE);
    	$data["principle_id"] = $this->input->post('principle_id',TRUE);
    	$data["estimated_event"] = $this->input->post('estimated_event',TRUE);
    	$this->MWork_plan->work_plan_details_setup_insert($data);
    	echo '1';
    }


    // plan_detail_by_plan_details_id
    public function plan_detail_by_plan_details_id($id,$wdate=''){

    	$data=$this->MWork_plan->plan_detail_by_plan_details_id($id);
    	$delete=true;
    	$thisMonth=date("Y-m");
    	if($wdate){
    		$planMonth=date("Y-m",strtotime($wdate));
    		if($thisMonth!=$planMonth){
    			$delete=false;
    		}
    	}
    	if(count($data)>0){
	    	$result='<table border="1" width="100%">
	    		<tr>
	    			<th>Customer</th>
	    			<th>Principle</th>
	    			<th>Event</th>
	    			<th>Action</th>
	    		</tr>
	    	';

	    	foreach($data as $k=>$val){

	    		$result.='<tr>
	    			<td>'.$val->customer_name.'</td>
	    			<td>'.$val->principle_name.'</td>
	    			<td>'.$val->estimated_event.'</td>
	    			<td style="width:70px;text-align:center;" data-id="'.$val->id.'">';
	    		if($delete):
	    		$result.='<a href="javascript:void(0)" onclick="remove_event_plan(this)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
	    		endif;
	    		$result.='	
	    			</td>
	    		</tr>';
	    	}

	    	$result.='</table>';

	    	echo $result;
	    }else{
	    	echo'';
	    }
    }

    // remove_event_plan
    public function remove_event_plan($id){
    	$data=$this->MWork_plan->remove_event_plan($id);
    	echo $data->working_day_id;	
    }

    // daily work update
    public function daily_update(){
    	$this->load->helper('date');
    	$data["page_title"] = "Daily Update";
    	$user=$this->session->userdata('userId');
    	
    	$plan=$this->MWork_plan->daily_plan($user);


		$data["main_content"] = $this->load->view('work_plan/update',['plan'=>$plan[0],'working_day_id'=>$plan[1]],true);

		$data['page_css'] = '
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
		<script>
			$(document).ready(function() {
				
				// insert modal on hide 
				  $("#work_plan_add_customer").on("hide.bs.modal", function (event) {
					  var modal = $(this)
					  modal.find(".modal-body input#customer_for_work_plan").val("")
					  modal.find(".modal-body input#customer_id").val("")
					  modal.find(".modal-body input#principle_for_work_plan").val("")
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
					  modal.find(".modal-body input#principle_for_work_plan").val("")
					  modal.find(".modal-body input#principle_id").val("")
					  modal.find(".modal-body #customer_search_result ul").empty()
				})

				$("#daily_update_send").click(function(){
					alert("Daily update successfully submited");
				})


			});

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

		</script>
		';

		$this->load->view('master',$data);
    }

    public function plan_detail_by_plan_details_id_for_table($id){

    	$data=$this->MWork_plan->plan_detail_by_plan_details_id($id);
    	if(count($data)>0){
    		echo'<tbody>';
	    	foreach($data as $k=>$val){
	    		echo'
                  <tr>
                    <td style="width:30px;"><input type="checkbox" onclick="update_status(this)" value="'.$val->id.'" '.($val->status==1?'checked="checked"':'').'></td>
                    <td>
                    '.(!empty($val->customer_name)?'<b>Customer:</b> '.$val->customer_name.'<br/>':'').'
                    '.(!empty($val->principle_name)?'<b>Principle:</b> '.$val->principle_name.'<br/>':'').'
                    '.$val->estimated_event.'</td>
                  </tr>
                  <tr>
                  	<td colspan="2">
                  		<textarea placeholder="Describe Detail of Above Task" class="form-control textarea" onchange="update_details(this)" data-id="'.$val->id.'">'.$val->remark.'</textarea>
                  	</td>
                  </tr>
                ';
	    	}
	    	echo'<tr>
	    		<td colspan="2" class="text-center">
	    			<button class="btn btn-success" id="daily_update_send" onclick="daily_update_send()">Update</button>
	    		</td>
	    	</tr>';
	    	echo'</tbody>';

	    }else{
	    	echo '';
	    }
    }

    // update_work_plan_status

    public function update_work_plan_status(){
    	$id=$this->input->post("id",TRUE);
    	$status=$this->input->post("status",TRUE);
    	$this->MWork_plan->update_work_plan_status($id,$status);
    }

    public function update_work_plan_details(){
    	$id=$this->input->post("id",TRUE);
    	$remark=$this->input->post("remark",TRUE);
    	$this->MWork_plan->update_work_plan_details($id,$remark);
    }


}