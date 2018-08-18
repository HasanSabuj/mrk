<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_event extends CI_Controller {
	private $service;
	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$this->service=$this->uri->segment(2);
        }


        $this->load->model('MService');
        $this->load->model('MService_event');
        $this->load->model('MContact');
    }


    public function service_event_register(){

    	// service details
    	$service_details=$this->MService->getInfoById($this->service);
    	$contacts=$this->MContact->getAllByCustomer($service_details[0]->customer);
    	$events=$this->MService_event->get_all_event_by_service_id($this->service);
    	$data["page_title"] = "Service Event Register";
    	$data["main_content"] = $this->load->view('service/event_register',['service_details'=>$service_details,'contacts'=>$contacts,'events'=>$events],true);
    	$data["page_script"]='<script>
    		$(document).ready(function(){
    			$("#myDatepicker1").datetimepicker({
                    format: \'DD-MM-YYYY\',
                    useCurrent: false
                });
                $("#myDatepicker2").datetimepicker({
                    format: \'DD-MM-YYYY\',
                    useCurrent: false
                });

                $("#save_service_event").click(function(){
                    
                	var service=$("#service_id");
                	var contact_id=$("#contact_id");
                	var event_title=$("#event_title");
                	var event_details=$("#event_details");
                	var note_date=$("#note_date");
                	var next_date=$("#next_date");
                    var attachment=$("#attachment");
                    var formData = new FormData($("#event_add_form")[0]);
                    var title=event_title.val();
                    if(title){
                        $(this).val("Wait...").prop("disabled",true);
                        $.ajax({
                            url: "'.base_url('service-event-save/"+service.val()+"').'",
                            dataType: "text",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,                         
                            type: "post",
                            success: function(response){
                                $("table#datatable-responsive tbody").prepend(response);
                                contact_id.val("");
                                event_title.val("");
                                event_details.val("");
                                note_date.val("");
                                next_date.val("");
                                attachment.val("");
                                $("#save_service_event").val("Save").prop("disabled",false);
                            }
                         });
                    }else{
                      event_title.focus();  
                    }
                })
    		})
    	</script>';
    	$this->load->view('master',$data);
    }

    public function service_event_register_save(){
        
    	$data=$this->MService_event->insert();

    	echo'
    		<tr>
    			<td>'.$data->user_name.'<br>@'.date("d-m-Y h:s a",strtotime($data->created_at)).'</td>
    			<td>'.$data->contact_name.'</td>
    			<td>'.$data->note_date.'</td>
    			<td><div>'.$data->event_title.'</div></td>
    			<td>'.nl2br($data->event_details).'</td>
    			<td>'.$data->next_date.'</td>
    		</tr>
    	';
    }

}