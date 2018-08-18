<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MDepartment');
    }

    // new department add form
    public function save(){
    	$data["page_title"] = "Add New Department";
    	$data["main_content"] = $this->load->view('department/save','',true);
    	$this->load->view('master',$data);
    }

    // insert data 
    public function insert(){
    	
    	if($this->input->post('name')){
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[department.name]',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'is_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

    			$this->MDepartment->create($data);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('department-list', 'refresh');
    			
    		}else{
    			
	            $this->save();
	            
    		}

    	}else{
    		$this->save();
    		
    	}
    	
    }

    // department list
    public function dlist(){

    	$departments=$this->MDepartment->getAllDepartments();

    	$data["page_title"] = "Department List";
    	$data["main_content"] = $this->load->view('department/list',['departments'=>$departments],true);


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
		    $res['data']=$this->MDepartment->getDataById($id);
		    $data["page_title"] = "Edit Department";
	    	$data["main_content"] = $this->load->view('department/edit',$res,true);
	    	$this->load->view('master',$data);
		}

    }

    // insert data 
    public function update(){
    	
    	if($this->input->post('id')){
    		$id=$this->input->post('id');
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[department.name.'.$id.']',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'edit_unique' => 'This %s already exists.'
                 	)
            );
    		
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['updated_by']=$this->session->userdata('userId');

    			$this->MDepartment->update($data,$id);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Updated');
	            redirect('department-list', 'refresh');
    			
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
    		redirect('department-list', 'refresh');
    		
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
		    $this->MDepartment->delete($id);
		    $this->session->set_flashdata('success', 'A Department deleted');
		    redirect('department-list', 'refresh');
		}
    }

    // trash list
    public function trash(){
    	$this->load->helper('date');
    	$departments=$this->MDepartment->getAllTrash();

    	$data["page_title"] = "Department List (Trash)";
    	$data["main_content"] = $this->load->view('department/list_trash',['departments'=>$departments],true);

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
		    $this->MDepartment->move($id);
		    $this->session->set_flashdata('success', 'A Department successully moved');
		    redirect('department-list', 'refresh');
		}
    }
}