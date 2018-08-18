<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_type extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MCustomer_type');
    }

    // new customer type add form
    public function save(){
    	$data["page_title"] = "Add New Customer Type";
    	$data["main_content"] = $this->load->view('customer/customer_type_save','',true);
    	$this->load->view('master',$data);
    }

    // insert data 
    public function insert(){
    	
    	if($this->input->post('name')){
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[customer_type.name]',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'is_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

    			$this->MCustomer_type->create($data);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('customer-type-list', 'refresh');
    			
    		}else{
    			
	            $this->save();
	            
    		}

    	}else{
    		$this->save();
    		
    	}
    	
    }

    // customer type list
    public function clist(){

    	$customer_type=$this->MCustomer_type->getAllCustomerType();
    	$list['customer_type'] = $customer_type;

    	$data["page_title"] = "Customer Type List";
    	$data["main_content"] = $this->load->view('customer/customer_type_list',$list,true);
    	$this->load->view('master',$data);
    }

    // edit screen
    public function edit(){
    	if ($this->uri->segment(2) === FALSE)
		{
		    if ($this->agent->is_referral())
			{
			    echo $this->agent->referrer();
			}
		}
		else
		{
		    $id = $this->uri->segment(2);
		    $res['data']=$this->MCustomer_type->getDataById($id);
		    $data["page_title"] = "Edit Customer Type";
	    	$data["main_content"] = $this->load->view('customer/customer_type_edit',$res,true);
	    	$this->load->view('master',$data);
		}

    }

    // insert data 
    public function update(){
    	
    	if($this->input->post('id')){
    		$id=$this->input->post('id');
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[customer_type.name.'.$id.']',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'edit_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['updated_by']=$this->session->userdata('userId');

    			$this->MCustomer_type->update($data,$id);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Updated');
	            redirect('customer-type-list', 'refresh');
    			
    		}else{
    			if($this->input->post('name')){

    				$this->session->set_flashdata('error', '"'.$this->input->post('name').'" already exists');
    			}else{
    				$this->session->set_flashdata('error', 'You must provide a Name');
    			}
				$uri=$this->agent->referrer();
	   			redirect($uri);
	            
    		}

    	}else{
    		redirect('customer-type-list', 'refresh');
    		
    	}
    	
    }

    // soft delete
    public function delete(){
    	if ($this->uri->segment(2) === FALSE)
		{
		    if ($this->agent->is_referral())
			{
			    echo $this->agent->referrer();
			}
		}
		else
		{
		    $id = $this->uri->segment(2);
		    $this->MCustomer_type->delete($id);
		    $this->session->set_flashdata('success', 'A Customer type deleted');
		    redirect('customer-type-list', 'refresh');
		}
    }

    // trash list
    public function trash(){
    	$this->load->helper('date');
    	$customer_type=$this->MCustomer_type->getAllTrash();

    	$list['customer_type'] = $customer_type;

    	$data["page_title"] = "Customer Type List (Trash)";
    	$data["main_content"] = $this->load->view('customer/customer_type_list_trash',$list,true);
    	$this->load->view('master',$data);
    }

    // trash to move in main list
    public function move(){
    	if ($this->uri->segment(2) === FALSE)
		{
		    if ($this->agent->is_referral())
			{
			    echo $this->agent->referrer();
			}
		}
		else
		{
		    $id = $this->uri->segment(2);
		    $this->MCustomer_type->move($id);
		    $this->session->set_flashdata('success', 'A Customer type successully moved');
		    redirect('customer-type-list', 'refresh');
		}
    }
}