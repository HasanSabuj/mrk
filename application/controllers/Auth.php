<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
	/**
	 * This Controler for authenticate a user first 
	 * After that permit to access in system
	 */
	public function index()
	{
		// chekc authentication
        if(is_logged_in()){
        	redirect('dashboard');
        }

		if($this->input->post('user_email')){


			$this->form_validation->set_rules('user_email', 'email', 'trim|required|valid_email',
                    array('required' => 'You must provide a %s.','valid_email'=>'You must provide a valid %s')
            );
    		$this->form_validation->set_rules('password','password','required',array('required'=>'You must provide a %s'));


            if ($this->form_validation->run() == TRUE)
            {
                $email = $this->input->post('user_email',TRUE);
                $password = $this->input->post('password',TRUE);

	            $userData=$this->Muser->get_user_data($email);
	            if($userData){
	            	if(password_verify($password,$userData->password)){
						$data["auth"]=true;
						$data["userId"]=$userData->id;
						$data["userEmail"]=$userData->user_email;
						$data["userName"]=$userData->user_name;
						$data["userPic"]=$userData->profile_pic;
						$data["userRole"]=$userData->user_role;
						$data["loginTime"]=date("Y-m-d H:i:s");
						$this->load->model('Muser_privileges');
						$data["permissions"]=$this->Muser_privileges->get_data_by_user_id($userData->id);
		                $this->session->set_userdata($data);
	                	$this->session->set_flashdata('success', 'Hi! Welcome Back');
	                    redirect('dashboard', 'refresh');
		            }else{
		                 $this->session->set_flashdata('error', 'User email and Password mismatch.');
	                     redirect('auth', 'refresh');
		            }
	            }else{
					$this->session->set_flashdata('error', 'User email and Password mismatch.');
                     redirect('auth', 'refresh');
	            }
				
                
            }
            else
            {
                $this->load->view('login');
            }
		}else{
			$this->load->view('login');
		}
	}

	public function logout()
    {
    	// chekc authentication
        if(!is_logged_in()){
        	redirect('','refresh');
        }
    	$this->session->sess_destroy();
        redirect('', 'refresh');
    }

    public function pass_recover(){
    	//print_r($this->input->post());
    	
    	$data["color"]="green";
    	$data["msg"]="You are not a valid user";

    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email','');
    	if ($this->form_validation->run() == TRUE){
    		$email=$this->input->post('email',TRUE);
    		// checking for valid user
    		$result=$this->Muser->check_valid_user_by_email($email);
    		if(count($result)>0){
    			// send email for password recovery

				$id=base64_encode($result->id);
				$msg["subject"]='Password Recovery Mail';
				$msg["message"]='Please reset your password from <a href="'.base_url('pass-reset?q='.$id).'">here</a>';
				$msg["receipient"]=$email;
				
				
				if($this->Muser->store_email($msg)){
					$data["color"]="green";
    				$data["msg"]="Please check mail & reset your password";
				}else{
					$data["color"]="red";
    				$data["msg"]="Opps! something wrong.";
				}
    			
    		}else{
    			$data["color"]="red";
    			$data["msg"]="You are not a valid user";
    		}
    	}

    	echo json_encode($data);
    }

    // recovery form
    public function pass_reset_form(){
    	$data["page_title"] = "Password Recovery";
        $id=base64_decode($this->input->get('q',TRUE));
        $result=$this->Muser->getInfoById($id);
        if(count($result)>0){
	        
	        $this->load->view('pass_recover',['user'=>$result]);
        }
    }

    // save new pass
    public function pass_reset_set(){
    	$this->form_validation->set_rules('id', 'Email', 'trim|required','');
    	$this->form_validation->set_rules('n_pass', 'New Password', 'required');
		$this->form_validation->set_rules('c_pass', 'Confirm Password', 'required|matches[n_pass]');
		if($this->form_validation->run()==TRUE){
			$pass=password_hash($this->input->post('n_pass',TRUE), PASSWORD_DEFAULT);
			$id=$this->input->post('id',TRUE);
			$this->Muser->reset_password($pass,$id);
			$this->session->set_flashdata('success', 'Password reset done');
            redirect('auth', 'refresh');
		}else{
			$id=$this->input->post("id",TRUE);
            $result=$this->Muser->getInfoById($id);
	        if(count($result)>0){
		        
		        $this->load->view('pass_recover',['user'=>$result]);
	        }
		}
    }
}
