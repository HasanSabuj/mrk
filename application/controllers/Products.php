<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MProducts');
    }

    public function add(){
    	$data["page_title"] = "Add New Product";
        $this->load->model('MForm_name');
        $forms=$this->MForm_name->get_all_forms();
    	$data["main_content"] = $this->load->view('product/save',['forms'=>$forms],true);
    	$this->load->view('master',$data);

    }


    public function img_upload(){
    	
    	if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                $destination = './public/uploads/product/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                if(move_uploaded_file($location, $destination)){
                	echo base_url().'public/uploads/product/' . $filename;//change this URL
                }
            }
            else
            {
              echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }

    }

    public function img_delete(){
    	$src = $this->input->post('src'); // $src = $_POST['src'];
  		$file_name = str_replace(base_url(), '', $src); // striping host to get relative path
        if(unlink($file_name))
        {
            echo 'File Delete Successfully';
        }
    }

    public function insert(){
    	$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[products.name]',
                array(
                	'required' => 'You must provide a %s.',
             		'is_unique' => 'This %s already exists.'
             	)
            );
        $this->form_validation->set_rules('requirement_form_id', 'Requirement Form', 'trim|required',
                array(
                    'required' => 'You must provide a %s.'
                )
            );
    	if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['requirement_form_id']=$this->input->post('requirement_form_id',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

    			$id=$this->MProducts->create($data);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('product-list', 'refresh');
    			
    		}else{
    			
	            $this->add();
	            
    		}
    }

    // product list
    public function plist(){
    	$products=$this->MProducts->getAllProducts();
    	$data["page_title"] = "Product List";
    	$data["main_content"] = $this->load->view('product/list',array('products'=>$products),true);
    	
    	$data["page_script"] = '
        <script>
            $(document).ready(function(){
                $("#form_element_show").on("show.bs.modal", function (event) {
                  var button = $(event.relatedTarget) // Button that triggered the modal
                  var name = button.text()
                  var id = button.data("fid")
                  var modal = $(this)
                  //modal.find("#myModalLabel2").text(name)
                  $.post("'.base_url('get_form_by_id_ajax').'",{id:id,name:name},function(result){
                        $(".modal-body").html(result);
                    })
                });
            })
        </script>';
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
            $data["page_title"] = "Edit Product";
            $id=$this->uri->segment(2);
            $product=$this->MProducts->getInfoById($id);
            $this->load->model('MForm_name');
            $forms=$this->MForm_name->get_all_forms();
            $data["main_content"] = $this->load->view('product/edit',array('product'=>$product,'forms'=>$forms),true);
            
            $this->load->view('master',$data);
        }
    }

    // update info
    public function update(){
    	$id=$this->input->post('id');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[products.name.'.$id.']',
                array(
                    'required' => 'You must provide a %s.',
                    'edit_unique' => 'This %s already exists.'
                )
        );
        $this->form_validation->set_rules('requirement_form_id', 'Requirement Form', 'trim|required',
                array(
                    'required' => 'You must provide a %s.'
                )
        );

        if ($this->form_validation->run() == TRUE){


                $data['name']=$this->input->post('name',TRUE);
                $data['requirement_form_id']=$this->input->post('requirement_form_id',TRUE);
                $data['updated_by']=$this->session->userdata('userId');

                $this->MProducts->update($data,$id);

                $this->session->set_flashdata('success', '"'.$data['name'].'" Successfully updated');
                redirect('product-list', 'refresh');
                
            }else{
                
                $this->session->set_flashdata('error', 'Ops! something wents wrong');
                redirect('product-list', 'refresh');
                
            }
    }

    // product delete 
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
            $this->MProducts->delete($id);
            $this->session->set_flashdata('success', 'A Product deleted');
            redirect('product-list', 'refresh');
        }
    }

    // trash list
    public function trash(){
        $this->load->helper('date');
        $products=$this->MProducts->getAllTrash();

        $data["page_title"] = "Product List (Trash)";
        $data["main_content"] = $this->load->view('product/list_trash',array('products'=>$products),true);
        
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
            $this->MProducts->move($id);
            $this->session->set_flashdata('success', 'A Product successully moved');
            redirect('product-list', 'refresh');
        }
    }
}