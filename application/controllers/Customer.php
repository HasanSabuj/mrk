<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MCustomers');
        $this->load->model('MCustomer_type');
    }


    // new customer add form
    public function save(){
    	$data["page_title"] = "Add New Customer";
        $customer_type=$this->MCustomer_type->getSelectList();
    	$data["main_content"] = $this->load->view('customer/save',array('customer_type'=>$customer_type),true);
    	$this->load->view('master',$data);
    }

    // insert data 
    public function insert(){
    	
    	if($this->input->post('name')){
    		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[customers.name]',
                    array(
                    	'required' => 'You must provide a %s.',
                 		'is_unique' => 'This %s already exists.'
                 	)
            );
            $this->form_validation->set_rules('phone','Phone No.','required',array('required'=>'You must provide a %s'));
            $this->form_validation->set_rules('email','Email','required',array('required'=>'You must provide a %s'));
    		$this->form_validation->set_rules('cust_type','Customer Type','required',array('required'=>'You must provide a %s'));

    		$this->form_validation->set_rules('cust_cat','Customer Category','required',array('required'=>'You must provide a %s'));
    		if ($this->form_validation->run() == TRUE){
    			$data['name']=$this->input->post('name',TRUE);
    			$data['phone']=$this->input->post('phone',TRUE);
    			$data['email']=$this->input->post('email',TRUE);
    			$data['website']=$this->input->post('website',TRUE);
                $data['address']=$this->input->post('address',TRUE);
    			$data['address_fac']=$this->input->post('address_fac',TRUE);
    			$data['cust_type']=$this->input->post('cust_type',TRUE);
    			$data['cust_cat']=$this->input->post('cust_cat',TRUE);
    			$data['lat']=$this->input->post('lat',TRUE);
    			$data['lon']=$this->input->post('lon',TRUE);
    			$data['created_by']=$this->session->userdata('userId');

    			$id=$this->MCustomers->create($data);

                if ($_FILES['attachments']['name']){
                    $config['file_name'] = $id;
                    $config['upload_path'] = './public/uploads/customer/';
                    $config['allowed_types'] = '*';
                    $config['overwrite'] = TRUE;
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload("attachments"))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        //die();
                    }
                    else
                    {
                        $filedata = $this->upload->data();
                        $customer_pic=$filedata['file_name'];
                        $this->MCustomers->update_pic($customer_pic,$id);
                    }

                    
                }
    			$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
	            redirect('customer-list', 'refresh');
    			
    		}else{
    			
	            $this->save();
	            
    		}

    	}else{
    		$this->save();
    		
    	}
    	
    }

    // customer list
    public function clist(){
    	$role=$this->session->userdata('userRole');
    	if($role==3){
            $creator=$this->session->userdata('userId');
    		$customers=$this->MCustomers->getCustomerListByCreator($creator);
    	}else{
    		$customers=$this->MCustomers->getAllCustomers();
    	}
        $this->load->model('MContact');
        $contacts=$this->MContact->get_all_contacts();

    	$data["page_title"] = "Customer List";
    	$data["main_content"] = $this->load->view('customer/list',array('customers'=>$customers,'contacts'=>$contacts),true);

    	$data["page_script"] = '
        <script src="'.base_url().'public/js/my-custom.js"></script>
        <script>
            $(document).ready(function(){
                $("#contact_details_show").on("show.bs.modal", function (event) {
                  var button = $(event.relatedTarget) // Button that triggered the modal
                  var name = button.text()
                  var department = button.data("department")
                  var designation = button.data("designation")
                  var email = button.data("email")
                  var phone = button.data("phone")
                  var modal = $(this)
                  modal.find("#myModalLabel2").text(name)
                  modal.find("#myModalDepartment").text(department)
                  modal.find("#myModalDesignation").text(designation)
                  modal.find("#myModalEmail").text(email)
                  modal.find("#myModalPhone").text(phone)
                });
            })
        </script>
        ';
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
            $data["page_title"] = "Edit Customer";
            $customer_type=$this->MCustomer_type->getSelectList();
            $id=$this->uri->segment(2);
            $customer=$this->MCustomers->getInfoById($id);
            $data["main_content"] = $this->load->view('customer/edit',array('customer_type'=>$customer_type,'customer'=>$customer),true);
            $this->load->view('master',$data);
        }
    }

    // update 
    public function update(){
        if($this->input->post('id')){
            $id=$this->input->post('id');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|edit_unique[customers.name.'.$id.']',
                    array(
                        'required' => 'You must provide a %s.',
                        'edit_unique' => 'This %s already exists.'
                    )
            );
            $this->form_validation->set_rules('phone','Phone No.','required',array('required'=>'You must provide a %s'));
            $this->form_validation->set_rules('email','Email','required',array('required'=>'You must provide a %s'));
            $this->form_validation->set_rules('cust_type','Customer Type','required',array('required'=>'You must provide a %s'));
            $this->form_validation->set_rules('cust_cat','Customer Category','required',array('required'=>'You must provide a %s'));
            if ($this->form_validation->run() == TRUE){

                if($this->input->post('delete_current')){
                    $this->delete_customer_image($id);

                }

                $data['name']=$this->input->post('name',TRUE);
                $data['phone']=$this->input->post('phone',TRUE);
                $data['email']=$this->input->post('email',TRUE);
                $data['website']=$this->input->post('website',TRUE);
                $data['address']=$this->input->post('address',TRUE);
                $data['address_fac']=$this->input->post('address_fac',TRUE);
                $data['cust_type']=$this->input->post('cust_type',TRUE);
                $data['cust_cat']=$this->input->post('cust_cat',TRUE);
                $data['lat']=$this->input->post('lat',TRUE);
                $data['lon']=$this->input->post('lon',TRUE);
                $data['updated_by']=$this->session->userdata('userId');

                $this->MCustomers->update($data,$id);

                if ($_FILES['attachments']['name']){
                    $config['file_name'] = $id;
                    $config['upload_path'] = './public/uploads/customer/';
                    $config['allowed_types'] = '*';
                    $config['overwrite'] = TRUE;
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload("attachments"))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        //die();
                    }
                    else
                    {
                        $filedata = $this->upload->data();
                        $customer_pic=$filedata['file_name'];
                        $this->MCustomers->update_pic($customer_pic,$id);
                    }

                    
                }
                $this->session->set_flashdata('success', '"'.$data['name'].'" Successfully updated');
                redirect('customer-list', 'refresh');
                
            }else{
                
                $this->session->set_flashdata('error', 'Ops! something wents wrong');
                redirect('customer-list', 'refresh');
                
            }

        }else{
           $this->session->set_flashdata('error', 'Ops! something wents wrong');
           redirect('customer-list', 'refresh');
            
        }
    }

    // delete
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
            $this->MCustomers->delete($id);
            $this->session->set_flashdata('success', 'A Customer deleted');
            redirect('customer-list', 'refresh');
        }
    }

    // trash list
    public function trash(){
        $this->load->helper('date');
        $customers=$this->MCustomers->getAllTrash();

        $data["page_title"] = "Customer List (Trash)";
        $data["main_content"] = $this->load->view('customer/list_trash',array('customers'=>$customers),true);

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
            $this->MCustomers->move($id);
            $this->session->set_flashdata('success', 'A Customer successully moved');
            redirect('customer-list', 'refresh');
        }
    }

    // delete_customer_image
    public function delete_customer_image($id){
        $customerData=$this->MCustomers->getInfoById($id);

        $filePath='./public/uploads/customer/'.$customerData->attachments;
        if(file_exists($filePath)){
            if(!unlink($filePath)){
                
            }else{
                $this->MCustomers->update_pic('',$id);
            }
        }
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
            $customer = $this->uri->segment(2);

            $customer_data=$this->MCustomers->getInfoById($customer);

            $data["page_title"] = "Detail about customer: ".$customer_data->name;
            
            $data["main_content"] = $this->load->view('customer/details',['customer_data'=>$customer_data],true);
            
            $data["page_script"]="
                <script>
                    $(document).ready(function() {
                        $('#prof_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', {
                                    extend: 'pdf',
                                    title: 'Profile of ".$customer_data->name."'
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
                                    title: 'Contact List of ".$customer_data->name."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':false,
                            'stripHtml': true,
                            'title':'my title'
                        } );

                        $('#job_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel',{
                                    extend: 'pdf',
                                    title: 'All Jobs of ".$customer_data->name."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':false,
                            'stripHtml': true,
                            'title':'my title'
                        } );

                        $('#follow_up_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel',{
                                    extend: 'pdf',
                                    title: 'Follow up detail of ".$customer_data->name."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : true,
                            'bFilter':true,
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