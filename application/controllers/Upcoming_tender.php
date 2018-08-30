<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upcoming_tender extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MUpcoming_tender');
    }

    public function tlist(){
    	$tenders=$this->MUpcoming_tender->tlist();

    	$data["page_title"] = "Upcoming Tender List";
    	$data["main_content"] = $this->load->view('upc_tender/list',array('tenders'=>$tenders),true);
    	$this->load->view('master',$data);
    }

    public function create(){
    	$data["page_title"] = "Create New";
    	$data["main_content"] = $this->load->view('upc_tender/create','',true);
    	$this->load->view('master',$data);
    }

    public function save(){
    	if($this->input->post()){
    		$data['customer']=$this->input->post('customer',true);
    		$data['product']=$this->input->post('product',true);
    		$data['submission_date']=$this->input->post('submission_date',true);
    		$data['ernest_money']=$this->input->post('ernest_money',true);
    		$data['opening_date']=$this->input->post('opening_date',true);
    		$data['priority']=$this->input->post('priority',true);
    		$id=$this->MUpcoming_tender->save($data);

            
            if(!empty($_FILES['attachments']['name'][0])){

                if(count($_FILES['attachments']['name'])>0){
                    $this->load->library('upload');
                    //$this->uploadfile($_FILES['userfile']);
                    $files = $_FILES;
                    $cpt = count($_FILES['attachments']['name']);
                    $attachment=array();
                    for($i=0; $i<$cpt; $i++)
                    {   

                            $_FILES['attachments']['name']= $id.'_'.time().'_'.$files['attachments']['name'][$i];
                            $_FILES['attachments']['type']= $files['attachments']['type'][$i];
                            $_FILES['attachments']['tmp_name']= $files['attachments']['tmp_name'][$i];
                            $_FILES['attachments']['error']= $files['attachments']['error'][$i];
                            $_FILES['attachments']['size']= $files['attachments']['size'][$i]; 


                            $this->upload->initialize($this->set_upload_options());
                            if ( ! $this->upload->do_upload('attachments'))
                            {
                                $error = array('error' => $this->upload->display_errors());
                                print_r($error);
                                //die();
                            }
                            $filedata = $this->upload->data();
                            $attachment[]=$filedata['file_name'];

                    }

                    $this->MUpcoming_tender->save_attachment($attachment,$id);
                }

            }    

    		$this->session->set_flashdata('success', 'Successfully Added');
	        redirect('upcoming-tender', 'refresh');
    	}
    }

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
            $id=$this->uri->segment(2);
            $tender=$this->MUpcoming_tender->get_by_id($id);

            $data["page_title"] = "Edit Upcoming Tender";
            $data["main_content"] = $this->load->view('upc_tender/edit',array('tender'=>$tender),true);
            $this->load->view('master',$data);
        }
    }

    public function update(){
        if(!empty($this->input->post('id',true))){
            $id=$data['id']=$this->input->post('id',true);
            $data['customer']=$this->input->post('customer',true);
            $data['product']=$this->input->post('product',true);
            $data['submission_date']=$this->input->post('submission_date',true);
            $data['ernest_money']=$this->input->post('ernest_money',true);
            $data['opening_date']=$this->input->post('opening_date',true);
            $data['priority']=$this->input->post('priority',true);

            $this->MUpcoming_tender->update($data);

            if($this->input->post('delete_current')){
                $this->delete_attach_image($id);

            }

            if(!empty($_FILES['attachments']['name'][0])){

                if(count($_FILES['attachments']['name'])>0){
                    $this->load->library('upload');
                    //$this->uploadfile($_FILES['userfile']);
                    $files = $_FILES;
                    $cpt = count($_FILES['attachments']['name']);
                    $attachment=array();
                    for($i=0; $i<$cpt; $i++)
                    {   

                            $_FILES['attachments']['name']= $id.'_'.time().'_'.$files['attachments']['name'][$i];
                            $_FILES['attachments']['type']= $files['attachments']['type'][$i];
                            $_FILES['attachments']['tmp_name']= $files['attachments']['tmp_name'][$i];
                            $_FILES['attachments']['error']= $files['attachments']['error'][$i];
                            $_FILES['attachments']['size']= $files['attachments']['size'][$i]; 


                            $this->upload->initialize($this->set_upload_options());
                            if ( ! $this->upload->do_upload('attachments'))
                            {
                                $error = array('error' => $this->upload->display_errors());
                                print_r($error);
                                //die();
                            }
                            $filedata = $this->upload->data();
                            $attachment[]=$filedata['file_name'];

                    }

                    $this->MUpcoming_tender->save_attachment($attachment,$id);
                }

            }

            $this->session->set_flashdata('success', 'Successfully Updated');
            redirect('upcoming-tender', 'refresh');
        }
    }

    public function remove(){
    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
            $id=$this->uri->segment(2);
            if($this->MUpcoming_tender->remove($id)){
    			$this->session->set_flashdata('success', 'Successfully deleted');
	        	redirect('upcoming-tender', 'refresh');
	    	}else{
	    		$this->session->set_flashdata('danger', 'Ops! something wrong');
	        	redirect('upcoming-tender', 'refresh');
	    	}
        }
    }

    public function delete_attach_image($id){
        $upc_data=$this->MUpcoming_tender->get_by_id($id);

        $filePath='./public/uploads/upct/'.$upc_data->attachments;
        if(file_exists($filePath)){
            if(!unlink($filePath)){
                
            }else{
                $this->MUpcoming_tender->update_pic('',$id);
            }
        }
    }

    private function set_upload_options()
    {   
    //  upload an image and document options
        $config = array();
        $config['upload_path'] = './public/uploads/upct/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = TRUE;


        return $config;
    }
}