<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MContact');
    }

    // insert data
    public function ajax_add(){

        
    	$data['name'] = $this->input->post('name',TRUE);
    	$data['department'] = $this->input->post('department',TRUE);
    	$data['designation'] = $this->input->post('designation',TRUE);
    	$data['phone'] = $this->input->post('phone',TRUE);
    	$data['email'] = $this->input->post('email',TRUE);
    	$data['customer_id'] = $this->input->post('customer_id',TRUE);
    	$data['created_by'] = $this->session->userdata('userId');

    	$id=$this->MContact->create($data);

        if ($_FILES['vcard']['name']){
            $config['file_name'] = $id;
            $config['upload_path'] = './public/uploads/customer/contact/';
            $config['allowed_types'] = '*';
            $config['overwrite'] = TRUE;
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload("vcard"))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                //die();
            }
            else
            {
                $filedata = $this->upload->data();
                $contact_pic=$filedata['file_name'];
                $this->MContact->update_pic($contact_pic,$id);
            }

            
        }


    	echo'1';
    }

    // update data
    public function ajax_update(){
    	$data['name'] = $this->input->post('name',TRUE);
    	$data['department'] = $this->input->post('department',TRUE);
    	$data['designation'] = $this->input->post('designation',TRUE);
    	$data['phone'] = $this->input->post('phone',TRUE);
    	$data['email'] = $this->input->post('email',TRUE);
    	$data['updated_by'] = $this->session->userdata('userId');
    	$data['id'] = $this->input->post('id',TRUE);

    	$this->MContact->update($data);
        $id=$data['id'];
        if ($_FILES['vcard']['name']){
            $config['file_name'] = $id;
            $config['upload_path'] = './public/uploads/customer/contact/';
            $config['allowed_types'] = '*';
            $config['overwrite'] = TRUE;
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload("vcard"))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                //die();
            }
            else
            {
                $filedata = $this->upload->data();
                $contact_pic=$filedata['file_name'];
                $this->MContact->update_pic($contact_pic,$id);
            }

            
        }

    	echo'1';
    }

    // contact list
    public function list_by_customer(){

    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$customer_id=$this->uri->segment(2);
        	$this->load->model('MCustomers');
        	$customer_data=$this->MCustomers->getInfoById($customer_id);
        	$data["page_title"] = "Contacts List of ".$customer_data->name;
            $contacts=$this->MContact->getAllByCustomer($customer_id);
            $data["main_content"] = $this->load->view('customer/contact_list',array('contacts'=>$contacts,'customer_data'=>$customer_data),true);

	    	$data["page_script"] = '
			    <script src="'.base_url().'public/js/pages/customer-contact-list.js"></script>';
            $this->load->view('master',$data);
        }
    }

    // trash
    public function contact_trash(){
    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }elseif ($this->uri->segment(3) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
        	$customer = $this->uri->segment(2);
        	$id=$this->uri->segment(3);
            $this->MContact->delete($id);
            $this->session->set_flashdata('success', 'A Customer contact deleted');
            redirect('customer-contact-list/'.$customer, 'refresh');
        }
    }

    // trash list by customer
    public function trash_list_by_customer(){
    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
        	$this->load->helper('date');
        	$customer_id=$this->uri->segment(2);
        	$this->load->model('MCustomers');
        	$customer_data=$this->MCustomers->getInfoById($customer_id);
        	$data["page_title"] = "Contacts Trash List of ".$customer_data->name;
            $contacts=$this->MContact->getAllTrashByCustomer($customer_id);
            $data["main_content"] = $this->load->view('customer/contact_trash_list',array('contacts'=>$contacts,'customer_data'=>$customer_data),true);

	    	$data["page_script"] = '
			    <script src="'.base_url().'public/js/pages/customer-contact-list.js"></script>';
            $this->load->view('master',$data);
        }
    }

    // move
    public function move(){
    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }elseif ($this->uri->segment(3) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
        	$customer = $this->uri->segment(2);
        	$id=$this->uri->segment(3);
            $this->MContact->move($id);
            $this->session->set_flashdata('success', 'A Customer contact moved to main list');
            redirect('customer-contact-list/'.$customer, 'refresh');
        }
    }

    public function contact_option_list(){
        $customer_id=$this->input->post('id',TRUE);
        $data=$this->MContact->getAllByCustomer($customer_id);
        $options='';
        foreach($data as $k=>$val){
            $options.='<option value="'.$val->id.'">'.$val->name.'</option>';
        }

        echo $options;
    }
}