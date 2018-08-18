<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designations extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MDesignation');
    }

    // new designation add form
    public function save(){
    	$data["page_title"] = "Add New Designation";
    	$data["main_content"] = $this->load->view('designation/save','',true);
    	$this->load->view('master',$data);
    }

    // insert data 
    public function insert(){
    	
    	if($this->input->post('name')){
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[designation.name]',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'is_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

    			$this->MDesignation->create($data);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('designation-list', 'refresh');
    			
    		}else{
    			
	            $this->save();
	            
    		}

    	}else{
    		$this->save();
    		
    	}
    	
    }

    // designation list
    public function dlist(){

    	$designations=$this->MDesignation->getAllDesignations();

    	$data["page_title"] = "Designation List";
    	$data["main_content"] = $this->load->view('designation/list',['designations'=>$designations],true);

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
		    $res['data']=$this->MDesignation->getDataById($id);
		    $data["page_title"] = "Edit Designation";
	    	$data["main_content"] = $this->load->view('designation/edit',$res,true);
	    	$this->load->view('master',$data);
		}

    }

    // insert data 
    public function update(){
    	
    	if($this->input->post('id')){
    		$id=$this->input->post('id');
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[designation.name.'.$id.']',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'edit_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['updated_by']=$this->session->userdata('userId');

    			$this->MDesignation->update($data,$id);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Updated');
	            redirect('designation-list', 'refresh');
    			
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
    		redirect('designation-list', 'refresh');
    		
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
		    $this->MDesignation->delete($id);
		    $this->session->set_flashdata('success', 'A Designation deleted');
		    redirect('designation-list', 'refresh');
		}
    }

    // trash list
    public function trash(){
    	$this->load->helper('date');
    	$designations=$this->MDesignation->getAllTrash();

    	$data["page_title"] = "Designation List (Trash)";
    	$data["main_content"] = $this->load->view('designation/list_trash',['designations'=>$designations],true);
    	
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
		    $this->MDesignation->move($id);
		    $this->session->set_flashdata('success', 'A Designation successully moved');
		    redirect('designation-list', 'refresh');
		}
    }
}