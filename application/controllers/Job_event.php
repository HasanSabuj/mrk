<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_event extends CI_Controller {
	private $job;
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
        	$this->job=$this->uri->segment(2);
        }


        $this->load->model('MJobs');
        $this->load->model('MJob_event');
        $this->load->model('MContact');
    }


    public function job_event_register(){

    	// job details
    	$job_details=$this->MJobs->getInfoById($this->job);
    	$contacts=$this->MContact->getAllByCustomer($job_details[0]->customer);
    	$events=$this->MJob_event->get_all_event_by_job_id($this->job);
    	$data["page_title"] = "Job Event Register";
    	$data["main_content"] = $this->load->view('jobs/event_register',['job_details'=>$job_details,'contacts'=>$contacts,'events'=>$events],true);
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

                /*$("#save_job_event").click(function(){
                    
                	var job=$("#job_id");
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
                            url: "'.base_url('job-event-save/"+job.val()+"').'",
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
                                $("#save_job_event").val("Save").prop("disabled",false);
                            }
                         });
                    }else{
                      event_title.focus();  
                    }
                })*/
    		})
    	</script>';
    	$this->load->view('master',$data);
    }

    public function job_event_register_save(){
        if($this->input->post('job',true)){
    	   $data=$this->MJob_event->insert();

           $this->session->set_flashdata('success', 'Saved');         
           redirect('job-event/'.$this->input->post("job",TRUE),'refresh');
        }else{

        }
    	
    }

}