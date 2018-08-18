<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principles extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MPrinciples');
        $this->load->model('MProducts');
    }

    // add
    public function add(){
    	$data["page_title"] = "Add New Principle";
        $products=$this->MProducts->productListDropdown();
    	$data["main_content"] = $this->load->view('principle/save',array('products'=>$products),true);
    	$this->load->view('master',$data);
    }

    // insert
    public function insert(){
    	if($this->input->post('name')){
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[principles.name]',
                array(
                	'required' => 'You must provide a %s.',
             		'is_unique' => 'This %s already exists.'
             	)
            );
    		
    		if ($this->form_validation->run() == TRUE){

                if($this->input->post('products')){

                    $products=implode(',', $this->input->post('products',TRUE));
                }
                else{
                    $products='';
                }

                $data['name']=$this->input->post('name',TRUE);
    			$data['products']=$products;
    			$data['phone']=$this->input->post('phone',TRUE);
    			$data['email']=$this->input->post('email',TRUE);
    			$data['website']=$this->input->post('website',TRUE);
    			$data['country']=$this->input->post('country',TRUE);
    			$data['address']=$this->input->post('address',TRUE);
    			$data['ref_bd']=$this->input->post('ref_bd',TRUE);
    			$data['ref_global']=$this->input->post('ref_global',TRUE);
    			$data['esta_year']=$this->input->post('esta_year',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

                if ($_FILES['visiting_card']['name']){
                    $data["visiting_card"]=addslashes(file_get_contents($_FILES['visiting_card']['tmp_name']));
                }
    			$this->MPrinciples->create($data);

    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('principle-list', 'refresh');
    			
    		}else{
    			
	            $this->add();
	            
    		}

    	}else{
    		$this->add();
    		
    	}
    }


    // principle list
    public function plist(){

    	$principles=$this->MPrinciples->getPrinciplelist();
        $this->load->model('PContact');
        $contacts=$this->PContact->get_all_contacts();
    	$data["page_title"] = "Principle List";
    	$data["main_content"] = $this->load->view('principle/list',array('principles'=>$principles,'contacts'=>$contacts),true);
    	

    	$data["page_script"] = '
        <script src="'.base_url().'public/js/pages/principle-contact-list.js"></script>
        <script>
            $(document).ready(function(){
                $("#contact_details_show").on("show.bs.modal", function (event) {
                  var button = $(event.relatedTarget) // Button that triggered the modal
                  var name = button.text()
                  var job_field = button.data("job")
                  var designation = button.data("designation")
                  var email = button.data("email")
                  var phone = button.data("phone")
                  var modal = $(this)
                  modal.find("#myModalLabel2").text(name)
                  modal.find("#myModalDepartment").text(job_field)
                  modal.find("#myModalDesignation").text(designation)
                  modal.find("#myModalEmail").text(email)
                  modal.find("#myModalPhone").text(phone)
                });
            })
        </script>
        ';
    	$this->load->view('master',$data);
    }

    // insert contact data
    public function contact_ajax_add(){
    	$this->load->model('PContact');
    	$data['name'] = $this->input->post('name',TRUE);
    	$data['designation'] = $this->input->post('designation',TRUE);
    	$data['job_field'] = $this->input->post('job_field',TRUE);
    	$data['phone'] = $this->input->post('phone',TRUE);
    	$data['email'] = $this->input->post('email',TRUE);
    	$data['principle_id'] = $this->input->post('principle_id',TRUE);
    	$data['created_by'] = $this->session->userdata('userId');
        if ($_FILES['visiting_card']['name']){
            $data["visiting_card"]=file_get_contents($_FILES['visiting_card']['tmp_name']);
        }
    	$this->PContact->create($data);

    	echo'1';
    }

    public function contacts(){
    	if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$this->load->model('PContact');
        	$principle_id=$this->uri->segment(2);
        	$principle_data=$this->MPrinciples->getInfoById($principle_id);
        	$data["page_title"] = "Contacts List of ".$principle_data->name;
            $contacts=$this->PContact->getAllByPrinciple($principle_id);
            $data["main_content"] = $this->load->view('principle/contact_list',array('contacts'=>$contacts,'principle_data'=>$principle_data),true);
            

	    	$data["page_script"] = '
			    <script src="'.base_url().'public/js/pages/principle-contact-list.js"></script>';
            $this->load->view('master',$data);
        }
    }

    // contact update
    public function contact_ajax_update(){
    	$this->load->model('PContact');
    	$data['name'] = $this->input->post('name',TRUE);
    	$data['designation'] = $this->input->post('designation',TRUE);
    	$data['job_field'] = $this->input->post('job_field',TRUE);
    	$data['phone'] = $this->input->post('phone',TRUE);
    	$data['email'] = $this->input->post('email',TRUE);
    	$data['updated_by'] = $this->session->userdata('userId');
    	$data['id'] = $this->input->post('id',TRUE);
        if ($_FILES['visiting_card']['name']){
            $data["visiting_card"]=file_get_contents($_FILES['visiting_card']['tmp_name']);
        }
    	$this->PContact->update($data);

    	echo'1';
    }

    // principle edit
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
            $data["page_title"] = "Edit Principle";
            $id=$this->uri->segment(2);
            $principle=$this->MPrinciples->getInfoById($id);
            $products=$this->MProducts->productListDropdown();
            $data["main_content"] = $this->load->view('principle/edit',array('principle'=>$principle,'products'=>$products),true);
            
            $this->load->view('master',$data);
        }
    }

    // update principle info
    public function update(){
        if($this->input->post('id')){
            $id=$this->input->post('id');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[principles.name.'.$id.']',
                    array(
                        'required' => 'You must provide a %s.',
                        'edit_unique' => 'This %s already exists.'
                    )
            );
            
            if ($this->form_validation->run() == TRUE){

                if($this->input->post('products')){

                    $products=implode(',', $this->input->post('products',TRUE));
                }
                else{
                    $products='';
                }

                $data['name']=$this->input->post('name',TRUE);
                $data['products']=$products;
                $data['phone']=$this->input->post('phone',TRUE);
                $data['email']=$this->input->post('email',TRUE);
                $data['website']=$this->input->post('website',TRUE);
                $data['address']=$this->input->post('address',TRUE);
                $data['country']=$this->input->post('country',TRUE);
                $data['ref_bd']=$this->input->post('ref_bd',TRUE);
                $data['ref_global']=$this->input->post('ref_global',TRUE);
                $data['esta_year']=$this->input->post('esta_year',TRUE);
                $data['updated_by']=$this->session->userdata('userId');
                $data['updated_at']=date('Y-m-d H:i:s', time());

                // delete image
                if($this->input->post('delete_current')){
                    $this->delete_img($id);
                }

                if ($_FILES['visiting_card']['name']){
                    $data["visiting_card"]=file_get_contents($_FILES['visiting_card']['tmp_name']);
                }

                $this->MPrinciples->update($data,$id);

                $this->session->set_flashdata('success', '"'.$data['name'].'" Successfully updated');
                redirect('principle-list', 'refresh');
                
            }else{
                
                $this->session->set_flashdata('error', 'Ops! something wents wrong');
                redirect('principle-list', 'refresh');
                
            }

        }else{
           $this->session->set_flashdata('error', 'Ops! something wents wrong');
           redirect('principle-list', 'refresh');
            
        }
    }

    // principle delete
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
            $this->MPrinciples->delete($id);
            $this->session->set_flashdata('success', 'A Principle deleted');
            redirect('principle-list', 'refresh');
        }
    }
    // principle trash list
    public function trash(){

        $this->load->helper('date');
        $principles=$this->MPrinciples->getAllTrash();

        $data["page_title"] = "Principle Trash List";
        $data["main_content"] = $this->load->view('principle/trash_list',array('principles'=>$principles),true);
        
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
            $this->MPrinciples->move($id);
            $this->session->set_flashdata('success', 'A Principle successully moved');
            redirect('principle-list', 'refresh');
        }
    }

    //
    public function trash_list_by_priciple(){
        if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
            $this->load->model('PContact');
            $this->load->helper('date');
            $principle_id=$this->uri->segment(2);

            $principle_data=$this->MPrinciples->getInfoById($principle_id);

            $data["page_title"] = "Contacts Trash List of ".$principle_data->name;
            $principles=$this->PContact->getAllTrashByPrinciple($principle_id);
            
            $data["main_content"] = $this->load->view('principle/contact_trash_list',array('principles'=>$principles,'principle_data'=>$principle_data),true);
            

            $data["page_script"] = '
                <script src="'.base_url().'public/js/pages/principle-contact-list.js"></script>';
            $this->load->view('master',$data);
        }
    }

    // contact trash
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
            $principle = $this->uri->segment(2);
            $id=$this->uri->segment(3);
            $this->load->model('PContact');
            $this->PContact->delete($id);
            $this->session->set_flashdata('success', 'A Principle contact deleted');
            redirect('principle-contact-list/'.$principle, 'refresh');
        }
    }

    // contact move
    public function c_move(){
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
            $principle = $this->uri->segment(2);
            $id=$this->uri->segment(3);
            $this->load->model('PContact');
            $this->PContact->move($id);
            $this->session->set_flashdata('success', 'A Principle contact moved to main list');
            redirect('principle-contact-list/'.$principle, 'refresh');
        }
    }


    // delete image
    public function delete_img($id){
        $this->MPrinciples->delete_image($id);
    }


    // details as report
    public function details(){
        if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
            $principle = $this->uri->segment(2);

            $principle_data=$this->MPrinciples->getInfoById($principle);

            $data["page_title"] = "Detail about principle: ".$principle_data->name;
            
            $data["main_content"] = $this->load->view('principle/details',['principle_data'=>$principle_data],true);
            
            $data["page_script"]="
                <script>
                    $(document).ready(function() {
                        $('#prof_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', {
                                    extend: 'pdf',
                                    title: 'Profile of ".$principle_data->name."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':false,
                            'stripHtml': true
                        } );
                        $('#contact_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel',{
                                    extend: 'pdf',
                                    title: 'Contact List of ".$principle_data->name."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':false,
                            'stripHtml': true,
                            'title':'my title'
                        } );
                    } );
                </script>
            ";
            $this->load->view('master',$data);
        
        }
    }
}