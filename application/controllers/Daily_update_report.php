<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_update_report extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

    }


    public function index(){
    	$data["page_title"] = "Daily Task Report";
    	$data["main_content"] = $this->load->view('report/daily_task','',true);

    	$data["page_css"]='<link href="'.base_url().'vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">';

        $data["page_script"]='
        <script src="'.base_url().'vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script>
            $(document).ready(function() {
                $("#reservation").daterangepicker({
				  locale: {
					format: "YYYY/MM/DD"
				  }
				});
			})
        </script>
        '; 
          
       

    	$this->load->view('master',$data);
    }


    public function show_report(){
    	if(!$this->input->post('reservation',true)){
    		redirect('daily-update-report','refresh');

    	}
    	$reservation=$this->input->post('reservation',true);
    	$date_data=explode("-", $reservation);

    	$fdate=trim($date_data[0]);
    	$tdate=trim($date_data[1]);

    	$this->load->model('MWork_plan');
        $report_data=$this->MWork_plan->daily_update_report_data($fdate,$tdate);

        $dateWiseData=array();
        foreach($report_data as $thisData){
        	$dateWiseData[$thisData["work_date"]][$thisData["user_id"]][]=$thisData;
        }

        $data["page_title"] = "Daily Task Report<br/><small>From Date: ".date('d/m/Y',strtotime($fdate))." To Date: ".date('d/m/Y',strtotime($tdate))."</small>";
    	$data["main_content"] = $this->load->view('report/daily_task_report',['dateWiseData'=>$dateWiseData],true);

    	$data["page_script"]="
    		<script>
    			$(document).ready(function(){
    				$('#detail_table').DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', {
                                extend: 'pdf',
                                title: 'Daily Task Report From Date: ".date('d-m-Y',strtotime($fdate))." To Date: ".date('d-m-Y',strtotime($tdate))."'
                            }, 'print'
                        ],
                        'bSort': false,
                        'paging': false,
                        'bInfo' : false,
                        'bFilter':false,
                        'stripHtml': true
                    } );
    			})
    		</script>
    	";

    	$this->load->view('master',$data);
    }
}