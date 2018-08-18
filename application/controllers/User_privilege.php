<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_privilege extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('Muser_privileges');
    }

    public function index(){
    	if ($this->uri->segment(2) === FALSE)
		{
		    if ($this->agent->is_referral())
			{
			    echo $this->agent->referrer();
			}
		}
		else
		{

	    	$data=array();
		    $id = $this->uri->segment(2);// user id

		    $permission=$this->Muser_privileges->get_data_by_user_id($id);
		    // get user info
		    $user=$this->Muser_privileges->user_info($permission->user_id);
		    $data["page_title"] = "privilege setup for <small> ".$user->user_name."</small>";
	    	$data["main_content"] = $this->load->view('user/user_privilege',['permission'=>$permission],true);
	    	$data["page_script"]='
	    		<script>
	    			$(document).ready(function(){
	    				var button=$("input[type=\'radio\']");
	    				$("input[name=\'check_all\']").click(function(){
	    					var value=$(this).val();

	    					if(value==1){
	    						$("input[type=\'radio\'][value=\'0\']").prop("checked",false);
	    						$("input[type=\'radio\'][value=\'1\']").prop("checked",true);
	    					}else{
	    						$("input[type=\'radio\'][value=\'1\']").prop("checked",false);
	    						$("input[type=\'radio\'][value=\'0\']").prop("checked",true);
	    					}
	    				})
	    			})
	    		</script>
	    	';
	    	$this->load->view('master',$data);

		}
    }


    public function update(){
    	$data['id'] = $this->input->post('id',TRUE);
    	$data['user_id'] = $this->input->post('user_id',TRUE);
    	$data['job'] = $this->input->post('job',TRUE);
	    $data['job_add'] = $this->input->post('job_add',TRUE);
	    $data['job_edit'] = $this->input->post('job_edit',TRUE);
	    $data['job_delete'] = $this->input->post('job_delete',TRUE);
	    $data['job_list'] = $this->input->post('job_list',TRUE);
	    $data['job_trash'] = $this->input->post('job_trash',TRUE);
	    $data['job_move'] = $this->input->post('job_move',TRUE);
	    $data['work_plan'] = $this->input->post('work_plan',TRUE);
	    $data['daily_update'] = $this->input->post('daily_update',TRUE);
	    $data['aditional_task'] = $this->input->post('aditional_task',TRUE);
	    $data['customer'] = $this->input->post('customer',TRUE);
	    $data['customer_add'] = $this->input->post('customer_add',TRUE);
	    $data['customer_edit'] = $this->input->post('customer_edit',TRUE);
	    $data['customer_delete'] = $this->input->post('customer_delete',TRUE);
	    $data['customer_list'] = $this->input->post('customer_list',TRUE);
	    $data['customer_trash'] = $this->input->post('customer_trash',TRUE);
	    $data['customer_move'] = $this->input->post('customer_move',TRUE);
	    $data['c_contact_add'] = $this->input->post('c_contact_add',TRUE);
	    $data['c_contact_edit'] = $this->input->post('c_contact_edit',TRUE);
	    $data['c_contact_delete'] = $this->input->post('c_contact_delete',TRUE);
	    $data['c_contact_list'] = $this->input->post('c_contact_list',TRUE);
	    $data['c_contact_trash'] = $this->input->post('c_contact_trash',TRUE);
	    $data['c_contact_move'] = $this->input->post('c_contact_move',TRUE);
	    $data['c_type'] = $this->input->post('c_type',TRUE);
	    $data['c_type_add'] = $this->input->post('c_type_add',TRUE);
	    $data['c_type_edit'] = $this->input->post('c_type_edit',TRUE);
	    $data['c_type_delete'] = $this->input->post('c_type_delete',TRUE);
	    $data['c_type_list'] = $this->input->post('c_type_list',TRUE);
	    $data['c_type_trash'] = $this->input->post('c_type_trash',TRUE);
	    $data['c_type_move'] = $this->input->post('c_type_move',TRUE);
	    $data['principle'] = $this->input->post('principle',TRUE);
	    $data['principle_add'] = $this->input->post('principle_add',TRUE);
	    $data['principle_edit'] = $this->input->post('principle_edit',TRUE);
	    $data['principle_delete'] = $this->input->post('principle_delete',TRUE);
	    $data['principle_list'] = $this->input->post('principle_list',TRUE);
	    $data['principle_trash'] = $this->input->post('principle_trash',TRUE);
	    $data['principle_move'] = $this->input->post('principle_move',TRUE);
	    $data['p_contact_add'] = $this->input->post('p_contact_add',TRUE);
	    $data['p_contact_edit'] = $this->input->post('p_contact_edit',TRUE);
	    $data['p_contact_delete'] = $this->input->post('p_contact_delete',TRUE);
	    $data['p_contact_list'] = $this->input->post('p_contact_list',TRUE);
	    $data['p_contact_trash'] = $this->input->post('p_contact_trash',TRUE);
	    $data['p_contact_move'] = $this->input->post('p_contact_move',TRUE);
	    $data['product'] = $this->input->post('product',TRUE);
	    $data['product_add'] = $this->input->post('product_add',TRUE);
	    $data['product_edit'] = $this->input->post('product_edit',TRUE);
	    $data['product_delete'] = $this->input->post('product_delete',TRUE);
	    $data['product_list'] = $this->input->post('product_list',TRUE);
	    $data['product_trash'] = $this->input->post('product_trash',TRUE);
	    $data['product_move'] = $this->input->post('product_move',TRUE);
	    $data['form_add'] = $this->input->post('form_add',TRUE);
	    $data['form_list'] = $this->input->post('form_list',TRUE);
	    $data['form_delete'] = $this->input->post('form_delete',TRUE);
	    $data['settings'] = $this->input->post('settings',TRUE);
	    $data['department'] = $this->input->post('department',TRUE);
	    $data['department_add'] = $this->input->post('department_add',TRUE);
	    $data['department_edit'] = $this->input->post('department_edit',TRUE);
	    $data['department_delete'] = $this->input->post('department_delete',TRUE);
	    $data['department_list'] = $this->input->post('department_list',TRUE);
	    $data['department_trash'] = $this->input->post('department_trash',TRUE);
	    $data['department_move'] = $this->input->post('department_move',TRUE);
	    $data['designation'] = $this->input->post('designation',TRUE);
	    $data['designation_add'] = $this->input->post('designation_add',TRUE);
	    $data['designation_edit'] = $this->input->post('designation_edit',TRUE);
	    $data['designation_delete'] = $this->input->post('designation_delete',TRUE);
	    $data['designation_list'] = $this->input->post('designation_list',TRUE);
	    $data['designation_trash'] = $this->input->post('designation_trash',TRUE);
	    $data['designation_move'] = $this->input->post('designation_move',TRUE);
	    $data['user'] = $this->input->post('user',TRUE);
	    $data['user_add'] = $this->input->post('user_add',TRUE);
	    $data['user_edit'] = $this->input->post('user_edit',TRUE);
	    $data['user_delete'] = $this->input->post('user_delete',TRUE);
	    $data['user_list'] = $this->input->post('user_list',TRUE);
	    $data['user_trash'] = $this->input->post('user_trash',TRUE);
	    $data['user_move'] = $this->input->post('user_move',TRUE);
	    $data['previlege'] = $this->input->post('previlege',TRUE);
	    $data['job_handle'] = $this->input->post('job_handle',TRUE);
	    $data['job_close'] = $this->input->post('job_close',TRUE);
	    $data['job_close_list'] = $this->input->post('job_close_list',TRUE);
	    $data['job_close_move'] = $this->input->post('job_close_move',TRUE);
	    $data['service'] = $this->input->post('service',TRUE);
	    $data['service_add'] = $this->input->post('service_add',TRUE);
	    $data['service_edit'] = $this->input->post('service_edit',TRUE);
	    $data['service_delete'] = $this->input->post('service_delete',TRUE);
	    $data['service_list'] = $this->input->post('service_list',TRUE);
	    $data['service_trash_list'] = $this->input->post('service_trash_list',TRUE);
	    $data['service_move'] = $this->input->post('service_move',TRUE);
	    $data['service_handler'] = $this->input->post('service_handler',TRUE);
	    $data['service_close'] = $this->input->post('service_close',TRUE);
	    $data['service_close_list'] = $this->input->post('service_close_list',TRUE);
	    $data['service_close_move'] = $this->input->post('service_close_move',TRUE);
	    $data['report'] = $this->input->post('report',TRUE);
	    $data['daily_task_report'] = $this->input->post('daily_task_report',TRUE);
	    $data['drowing_board'] = $this->input->post('drowing_board',TRUE);
	    $data['upcoming_tender'] = $this->input->post('upcoming_tender',TRUE);

	    $this->Muser_privileges->update($data);

	    $this->session->set_flashdata('success', 'User access permission successfully saved');

	    redirect('user-list','refresh');
    }
}