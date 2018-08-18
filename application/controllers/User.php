<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MDepartment');
        $this->load->model('MDesignation');
    }

    public function profile(){
    	if($this->input->post('id')){

    		$this->form_validation->set_rules('user_name', 'Name', 'trim|required',
                    array('required' => 'You must provide a %s.')
            );

			if ($this->form_validation->run() == TRUE){
	    		$id=$this->input->post('id');

	    		if($this->input->post('delete_current')){
                    $this->delete_user_image($id);

                }

				$name=$this->input->post('user_name',TRUE);
				$profile_pic='';
	    		$phone=$this->input->post('phone',TRUE);
	    		$pre_add=$this->input->post('pre_add',TRUE);
	    		$per_add=$this->input->post('per_add',TRUE);

				if ($_FILES['profile_pic']['name']){
				    $config['file_name'] = $this->session->userdata('userId');
				    $config['upload_path'] = './public/uploads/user/';
				    $config['allowed_types'] = 'gif|jpg|png';
				    $config['overwrite'] = TRUE;
				    $this->upload->initialize($config);

				    if ( ! $this->upload->do_upload("profile_pic"))
				    {
				        $error = array('error' => $this->upload->display_errors());
				        print_r($error);
				        die();
				    }
				    else
				    {
				        $filedata = $this->upload->data();
				        $profile_pic=$filedata['file_name'];
				        $con['image_library'] = 'gd2';
				        $con['source_image'] = './public/uploads/user/' .$profile_pic;
				        $con['maintain_ratio'] = false;
				        $con['width'] = 128;
				        $con['height'] = 128;
				        $this->load->library('image_lib', $con);
				        $this->image_lib->resize();
				        $this->image_lib->clear();
				    }
				}
				$this->Muser->profile_update($id,$name,$profile_pic,$phone,$pre_add,$per_add);

	    		$this->session->set_flashdata('success', 'Profile successfully updated');
	    		redirect('profile','refresh');
	    	}else{
	    		//redirect('profile');
	    		$data["page_title"] = "User Profile";
		    	$data["user_info"] = $this->Muser->get_user_data($this->session->userdata('userEmail'));
		    	$data["main_content"] = $this->load->view('user/profile',$data,true);
		    	$this->load->view('master',$data);
    		}
    	}else{
	    	$data["page_title"] = "User Profile";
	    	$data["user_info"] = $this->Muser->get_user_data($this->session->userdata('userEmail'));
	    	$data["main_content"] = $this->load->view('user/profile',$data,true);
	    	$this->load->view('master',$data);
    	}
    }

    // delete_user_image
    public function delete_user_image($id){

    	$userData=$this->Muser->getInfoById($id);

        $filePath='./public/uploads/user/'.$userData->profile_pic;
        if(file_exists($filePath)){
            if(!unlink($filePath)){
                
            }else{
                $this->Muser->update_pic('',$id);
            }
        }
    }

    // new user add form
    public function save(){
    	$data["page_title"] = "Add New User";
    	$departments=$this->MDepartment->getSelectList();
    	$designations=$this->MDesignation->getSelectList();
    	$data["main_content"] = $this->load->view('user/save',['departments'=>$departments,'designations'=>$designations],true);
    	$data["page_script"] = '
    		<script>
    			$(document).ready(function(){
    				$("#show_password").click(function(){
    					var x = document.getElementById("password");
					    if (x.type === "password") {
					        x.type = "text";
					        $(this).removeClass("fa-eye").addClass("fa-eye-slash");
					    } else {
					        x.type = "password";
					        $(this).removeClass("fa-eye-slash").addClass("fa-eye");
					    }
    				})
    			})
    		</script>
    	';
    	$this->load->view('master',$data);
    }

    // insert data 
    public function insert(){
    	
    	if($this->input->post('user_name')){
    		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]',
                    array(
                    	'required' => 'You must provide a %s.',
                    	'valid_email'=>'You must provide a valid %s',
                 		'is_unique' => 'This %s already exists.'
                 	)
            );
    		
    		$this->form_validation->set_rules('user_name','Name','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('phone','Phone No.','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('password','Password','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('department','Department','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('designation','Designation','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('user_role','User Role','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('status','User Status','required',array('required'=>'You must provide a %s'));



    		if ($this->form_validation->run() == TRUE){
    			$password=$this->input->post('password',TRUE);
    			$pass=password_hash($password, PASSWORD_DEFAULT);

    			$data['user_name']=$this->input->post('user_name',TRUE);
    			$data['phone']=$this->input->post('phone',TRUE);
    			$data['user_email']=$this->input->post('user_email',TRUE);
    			$data['pre_add']=$this->input->post('pre_add',TRUE);
    			$data['per_add']=$this->input->post('per_add',TRUE);
    			$data['department']=$this->input->post('department',TRUE);
    			$data['designation']=$this->input->post('designation',TRUE);
    			$data['password']=$pass;
    			
    			if($this->session->userdata('userRole')==3){
    				$data['user_role']=3;
    				$data['status']=2;
    			}else{
    				$data['user_role']=$this->input->post('user_role',TRUE);
    				$data['status']=$this->input->post('status',TRUE);
    			}

    			$data['created_by']=$this->session->userdata('userId');

    			$last_user=$this->Muser->create($data);

                $this->Muser->privilege($last_user);




    			if ($_FILES['profile_pic']['name']){
				    $config['file_name'] = $last_user;
				    $config['upload_path'] = './public/uploads/user/';
				    $config['allowed_types'] = 'gif|jpg|png';
				    $config['overwrite'] = TRUE;
				    $this->upload->initialize($config);

				    if ( ! $this->upload->do_upload("profile_pic"))
				    {
				        $error = array('error' => $this->upload->display_errors());
				        print_r($error);
				        die();
				    }
				    else
				    {
				        $filedata = $this->upload->data();
				        $profile_pic=$filedata['file_name'];
				        $con['image_library'] = 'gd2';
				        $con['source_image'] = './public/uploads/user/' .$profile_pic;
				        $con['maintain_ratio'] = false;
				        $con['width'] = 128;
				        $con['height'] = 128;
				        $this->load->library('image_lib', $con);
				        $this->image_lib->resize();
				        $this->image_lib->clear();

				        $this->Muser->update_pic($profile_pic,$last_user);
				    }
				}



    			if($this->session->userdata('userRole')==3){
    				$this->session->set_flashdata('success', '"'.$data['user_name'].'" Successfully Added & Waiting for Approval');
    			}else{
    				$this->session->set_flashdata('success', '"'.$data['user_name'].'" Successfully Added');
    			}

	            redirect('privilege-setup/'.$last_user, 'refresh');
    			
    		}else{
    			
	            $this->save();
	            
    		}

    	}else{
    		$this->save();
    		
    	}
    	
    }

    // user list
    public function ulist(){

    	$users=$this->Muser->getAllUsers();

    	$data["page_title"] = "User List";
    	$data["main_content"] = $this->load->view('user/list',['users'=>$users],true);
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
		    $res['data']=$this->Muser->getInfoById($id);
		    $res['departments']=$this->MDepartment->getSelectList();
    		$res['designations']=$this->MDesignation->getSelectList();
		    $data["page_title"] = "Edit User";
	    	$data["main_content"] = $this->load->view('user/edit',$res,true);
	    	$data["page_script"] = '
	    	<script>
    			$(document).ready(function(){
    				$("#show_password").click(function(){
    					var x = document.getElementById("password");
					    if (x.type === "password") {
					        x.type = "text";
					        $(this).removeClass("fa-eye").addClass("fa-eye-slash");
					    } else {
					        x.type = "password";
					        $(this).removeClass("fa-eye-slash").addClass("fa-eye");
					    }
    				})
    			})
    		</script>
	    	';
	    	$this->load->view('master',$data);
		}

    }

    // insert data 
    public function update(){
    	
    		$this->form_validation->set_rules('user_name','Name','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('phone','Phone No.','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('department','Department','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('designation','Designation','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('user_role','User Role','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('status','User Status','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('id','User Id','required',array('required'=>'You must provide a %s'));

    		$id=$this->input->post('id',TRUE);



    		if ($this->form_validation->run() == TRUE){

    			if($this->input->post('delete_current')){
                    $this->delete_user_image($id);

                }
                $data['id']=$id;
    			$data['user_name']=$this->input->post('user_name',TRUE);
    			$data['phone']=$this->input->post('phone',TRUE);
    			$data['pre_add']=$this->input->post('pre_add',TRUE);
    			$data['per_add']=$this->input->post('per_add',TRUE);
    			$data['department']=$this->input->post('department',TRUE);
    			$data['designation']=$this->input->post('designation',TRUE);
    			
    			if($this->session->userdata('userRole')==3){
    				$data['user_role']=3;
    				$data['status']=2;
    			}else{
    				$data['user_role']=$this->input->post('user_role',TRUE);
    				$data['status']=$this->input->post('status',TRUE);
    			}

    			$data['updated_by']=$this->session->userdata('userId');

    			$this->Muser->update($data);





    			if ($_FILES['profile_pic']['name']){
				    $config['file_name'] = $id;
				    $config['upload_path'] = './public/uploads/user/';
				    $config['allowed_types'] = 'gif|jpg|png';
				    $config['overwrite'] = TRUE;
				    $this->upload->initialize($config);

				    if ( ! $this->upload->do_upload("profile_pic"))
				    {
				        $error = array('error' => $this->upload->display_errors());
				        print_r($error);
				        die();
				    }
				    else
				    {
				        $filedata = $this->upload->data();
				        $profile_pic=$filedata['file_name'];
				        $con['image_library'] = 'gd2';
				        $con['source_image'] = './public/uploads/user/' .$profile_pic;
				        $con['maintain_ratio'] = false;
				        $con['width'] = 128;
				        $con['height'] = 128;
				        $this->load->library('image_lib', $con);
				        $this->image_lib->resize();
				        $this->image_lib->clear();

				        $this->Muser->update_pic($profile_pic,$id);
				    }
				}



    			if($this->session->userdata('userRole')==3){
    				$this->session->set_flashdata('success', '"'.$data['user_name'].'" Successfully Updated & Waiting for Approval');
    			}else{
    				$this->session->set_flashdata('success', '"'.$data['user_name'].'" Successfully Updated');
    			}
	            redirect('user-list', 'refresh');
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
		    $this->Muser->delete($id);
		    $this->session->set_flashdata('success', 'A User deleted');
		    redirect('user-list', 'refresh');
		}
    }

    // trash list
    public function trash(){
    	$this->load->helper('date');
    	$users=$this->Muser->getAllTrash();

    	$data["page_title"] = "User List (Trash)";
    	$data["main_content"] = $this->load->view('user/list_trash',['users'=>$users],true);
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
		    $this->Muser->move($id);
		    $this->session->set_flashdata('success', 'A User successully moved');
		    redirect('user-list', 'refresh');
		}
    }
}