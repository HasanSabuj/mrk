<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MService');
    }

    public function create(){
    	$data["page_title"]='Create New Service';
    	$data["main_content"]=$this->load->view('service/create','',TRUE);
    	$data['page_css'] = '
			<style>
				#customer_search_result{position:relative;}
				#customer_search_result ul{
					margin: 0px;
					padding: 0px;
					position: absolute;
					z-index: 999;
					list-style: none;
					background: #fff;
					display: block;
					width: 100%;
					max-height: 250px;
					overflow: auto;}
				#customer_search_result ul li{cursor:pointer;}
				#customer_search_result ul li:hover{background:#edededed}

				#product_search_result{position:relative;}
				#product_search_result ul{
					margin: 0px;
					padding: 0px;
					position: absolute;
					z-index: 999;
					list-style: none;
					background: #fff;
					display: block;
					width: 100%;
					max-height: 250px;
					overflow: auto;}
				#product_search_result ul li{cursor:pointer;}
				#product_search_result ul li:hover{background:#edededed}
			</style>
		';
    	$data["page_script"] = '
    		<script>
    			$(document).ready(function(){

    				// insert modal on show 
				  $("#service_product").on("show.bs.modal", function (event) {
				      var modal = $("#service_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					});	

					// insert modal on hide 
				  $("#service_product").on("hide.bs.modal", function (event) {
					  var modal = $("#service_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					});

    				$("#search_product").keyup(function(){
						//alert("adsfadf");
						var name=$(this).val();
						if(name){
							$.post("'.base_url('ajax-product-search').'",{name:name},function(data){
								$("#product_search_result ul").html(data);
							})
						}else{
							$("#product_search_result ul").html("");
						}

					});

					$("#search_customer").keyup(function(){
						//alert("adsfadf");
						var cust_name=$(this).val();
						if(cust_name){
							$.post("'.base_url('ajax-customer-search').'",{cust_name:cust_name,service:true},function(data){
								$("#customer_search_result ul").html(data);
								//alert(data);
							})
						}else{
							$("#customer_search_result ul").html("");
						}
					});

					// product list clear 
					$("#clear_product_list").click(function(){
						  var modal = $("#service_product")
						  modal.find(".modal-body input#search_product").val("")
						  modal.find(".modal-body input#product_id").val("")
						  modal.find(".modal-body textarea#description").val("")
						  modal.find(".modal-body #product_search_result ul").empty()
					})

					$("#save_service_product").click(function(e){
						e.preventDefault();
						var product_id=$("#product_id").val();
						var product_name=$("#search_product").val();
						var description=$("#description").val();
						if(product_id && product_name){
							$.post("'.base_url('ajax-save-in-session-service-product').'",{product_id:product_id,product_name:product_name,description:description},function(response){
								$("#selected_product_result").html(response);
								$(".modal").modal("hide");
							})
						}else{
							alert("Select a Product");
						}
					})

    			})// end doc ready function

    			function select_this_product(data){
    				var product_id = $(data).attr("data-id");
    				var form = $(data).attr("data-form");
					var name = $(data).text();
					$("#product_id").val(product_id);
					$("#search_product").val(name);
					$("#product_search_result ul").empty();
					
    			}

				
				function select_this_customer(data){
					var text=$(data).text();
					var id=$(data).attr("data-id");
					$("#search_customer").val(text);
					$("#customer_id").val(id);
					$("#customer_search_result ul").empty();
					$.post("'.base_url('ajax-get-cust-contact').'",{id:id},function(data){
						$("#prime_contact").html(data);
					})
				}

				function this_value_update(data){
					var cart_index=$(data).attr("data-index");
					var val=$(data).val();
					val=val.replace(/^"|"$/g, \'\');
					var name=$(data).attr("name");
					if($(data).attr("data-required")==1 && !val){
						alert("This field is required a value");
						location.reload();
					}else{
						$.post("'.base_url('ajax-service-product-cart-update').'",{cart_index:cart_index,val:val,name:name},function(response){
							$.noop();
						})
					}
				}

				function cart_to_remove(data){
					if(confirm("Are you sure?")){
						var index=$(data).attr("data-index");
						$.post("'.base_url('ajax-remove-from-service-cart').'",{index:index},function(response){
							$("#selected_product_result").html(response);
						})
					}
				}
    		</script>
    	';
    	$this->load->view('master',$data);
    }// end create

    public function service_product_save_in_session(){
    	$data=$this->input->post();
    	$result=$this->add_to_cart($data);
    	$this->display_cart_product($result);
    }

    public function add_to_cart($data) {

		// Whenever a user adds an item to their cart, pull out any they already have in there

		$cart_products = $this->session->userdata('service_cart_products');

		// Add the new item

		$cart_products[] = $data;

		// And put it back into the session

		$this->session->set_userdata('service_cart_products', $cart_products);

		return $this->session->userdata('service_cart_products');

	}

	public function display_cart_product($data){
		echo'<div class="x_panel">
	          <div class="x_content">

	            <div class="col-xs-3">
	              <!-- required for floating -->
	              <!-- Nav tabs -->
	              <ul class="nav nav-tabs tabs-left">';
	              	$form='';
              		foreach($data as $k=>$val){
              			echo'<li><a href="#form_'.$k.'" data-toggle="tab" data-id="'.$k.'"><span style="cursor:pointer;" class="btn btn-danger" onclick="modify_cart_to_remove(this)" data-index="'.$k.'"><i class="fa fa-close"></i></span> '.$val["product_name"].'</a></li>';
              			$form.='
              				<div class="tab-pane" id="form_'.$k.'">';
    					$form.='<p class="lead">'.$val["product_name"].'</p>';
    					$form.='<div class="form-group"><label>Details:</label><textarea class="form-control" data-index="'.$k.'"  onchange="this_value_update(this)" name="description" data-selfindex="dd">'.$val["description"].'</textarea></div></div>';
              		}
	              
	        echo'</ul>
	            </div>

	            <div class="col-xs-9">
	              <!-- Tab panes -->
	              <div class="tab-content" id="tab_result">
	                '.$form.'
	              </div>
	            </div>

	            <div class="clearfix"></div>

	          </div>
	        </div>';
	}

	public function remove_from_cart(){
		$index=$this->input->post('index',TRUE);

		$cart_products=$this->session->userdata('service_cart_products');

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key!=$index){
				$new_cart[]=$value;
			}
		}
		
		$this->session->set_userdata('service_cart_products',$new_cart);
		$result=$this->session->userdata('service_cart_products');
		$this->display_cart_product($result);
	}

	public function cart_update(){
		
		$cart_products=$this->session->userdata('service_cart_products');

		$index=$this->input->post('cart_index',TRUE);

		$selected_product=$cart_products[$index];

		$name=$this->input->post('name',TRUE);

		$val=$this->input->post('val',TRUE);
		

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key==$index){
				$data=$value;
				if($name=='description'){
					$data["description"]=$val;
				}
				$new_cart[]=$data;
			}else{
				$new_cart[]=$value;
			}
		}
		$this->session->set_userdata('service_cart_products',$new_cart);
	}

	// insert a service into database
	public function insert()
	{
		$cart_products=$this->session->userdata('service_cart_products');
		if(count($cart_products)>0){
			if($this->input->post('customer_id')){
				$this->form_validation->set_rules('customer_id', 'Company / Customer', 'trim|required',
                    array(
                    	'required' => 'You must provide a %s.'
                 	)
	            );

	            if ($this->form_validation->run() == TRUE){

	            	$data['customer']=$this->input->post('customer_id',TRUE);
	            	$data['contact']=$this->input->post('prime_contact',TRUE);
	            	$data['details']=$this->input->post('service_details',TRUE);
	            	
	            	$data['created_by']=$this->session->userdata('userId');

	            	$service_id=$this->MService->create($data);

	            	$this->MService->add_job_product($service_id,$cart_products);
	            	



	            	$this->session->unset_userdata('service_cart_products');

	            	$this->session->set_flashdata('success', '"SR-'.$service_id.'" successfully created');
					redirect('service-list', 'refresh');

	            }else{
	            	$this->create();
	            }
			}else{
				$this->session->set_flashdata('error', 'Select a company / customer properly');
				$this->create();
			}
		}else{
			$this->session->set_flashdata('error', 'Without product Service will not be create');
	        redirect('service-create', 'refresh');
		}
	}

	// service list
	public function service_list(){
		$services=$this->MService->get_service_list();
		$data['page_title']='Service List';
		$data["main_content"] = $this->load->view('service/list',array('services'=>$services),true);
		$data["page_script"] = '
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

	public function service_handler_setup(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$service = $this->uri->segment(2);
        	// get handler details
        	$handler=$this->MService->get_handler($service);
        	$this->load->model('Muser');
        	$users=$this->Muser->get_user_for_list();
        	$data["page_title"] = "Service Handler Setup <small>for the <u><b>SR-".$service."</b></u></small>";
	        $data["main_content"] = $this->load->view('service/handler',['handler'=>$handler,'users'=>$users],true);
	        
	        $this->load->view('master',$data);

        }
	}

	// save service handler
	public function service_handler_save(){
		$this->form_validation->set_rules('service', 'SR No', 'trim|required',
            array(
            	'required' => 'You must provide a %s.'
         	)
        );
        $this->form_validation->set_rules('handler', 'Handler', 'trim|required',
            array(
            	'required' => 'You must select a %s.'
         	)
        );

        if ($this->form_validation->run() == TRUE){
        	$data["handler"]=$this->input->post('handler',TRUE);
        	$service=$this->input->post('service',TRUE);

        	$this->MService->update_handler($data,$service);

        	$this->session->set_flashdata('success', 'Saved');
            redirect('service-list', 'refresh');
        }else{
        	//$this->session->set_flashdata('success', 'Saved');
            redirect('service-list', 'refresh');
        }
	}

	// service close 
	public function service_close(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$service = $this->uri->segment(2);
        	$service_details=$this->MService->service_master_details_by_id($service);
        	$data["page_title"] = "Close Service:  <small><u><b>SR-".$service."</b></u></small>";
	        $data["main_content"] = $this->load->view('service/service_close',['service'=>$service,'service_details'=>$service_details],true);
	        $this->load->view('master',$data);

        }
	}

	public function service_close_update(){
		$this->form_validation->set_rules('close_note', 'Service Close Note', 'trim|required',
            array(
            	'required' => 'You must put a %s.'
         	)
        );
        $this->form_validation->set_rules('service', 'Service Number', 'trim|required',
            array(
            	'required' => 'Please select a %s properly.'
         	)
        );
        if ($this->form_validation->run() == TRUE){
        	$service=$this->input->post('service',TRUE);
        	$note=$this->input->post('close_note',TRUE);
	    	$this->MService->update_service_for_close($service,$note);
	    	$this->session->set_flashdata('success', '"SR-'.$service.'" closed now');
	        redirect('service-list', 'refresh');
    	}else{
    		redirect('service-list', 'refresh');
    	}
	}

	public function c_service_list(){
		$services=$this->MService->c_service_list();
		$data["page_title"] = "Closed Service List";
        $data["main_content"] = $this->load->view('service/clist',['services'=>$services],true);
        
        $this->load->view('master',$data);

	}

	public function c_service_move(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$service = $this->uri->segment(2);
        	
        	$this->MService->c_service_move($service);
	    	$this->session->set_flashdata('success', '"SR-'.$service.'" moved to main service list');
	        redirect('service-list', 'refresh');
        }
	}

	public function service_edit(){

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
            $data["page_title"] = "Edit Service";
            $service=$this->MService->getInfoById($id);
            $this->load->model('MContact');
            $customer_id=$service[0]->customer;
            $contacts=$this->MContact->getAllByCustomer($customer_id);

            // products
            $products=$this->MService->get_products_by_service_id($id);
            $this->session->unset_userdata('modify_service_cart_products');
            foreach($products as $product){
            	$this->add_to_modify_cart($product);
            }
            $data["main_content"] = $this->load->view('service/edit',array('service'=>$service,'contacts'=>$contacts),true);
            $data['page_css'] = '
			<style>
				#customer_search_result{position:relative;}
				#customer_search_result ul{
					margin: 0px;
					padding: 0px;
					position: absolute;
					z-index: 999;
					list-style: none;
					background: #fff;
					display: block;
					width: 100%;
					max-height: 250px;
					overflow: auto;}
				#customer_search_result ul li{cursor:pointer;}
				#customer_search_result ul li:hover{background:#edededed}

				#product_search_result{position:relative;}
				#product_search_result ul{
					margin: 0px;
					padding: 0px;
					position: absolute;
					z-index: 999;
					list-style: none;
					background: #fff;
					display: block;
					width: 100%;
					max-height: 250px;
					overflow: auto;}
				#product_search_result ul li{cursor:pointer;}
				#product_search_result ul li:hover{background:#edededed}
			</style>
		';
    	$data["page_script"] = '
    		<script>
    			$(document).ready(function(){

    				// insert modal on show 
				  $("#service_product").on("show.bs.modal", function (event) {
				      var modal = $("#service_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					});	

					// insert modal on hide 
				  $("#service_product").on("hide.bs.modal", function (event) {
					  var modal = $("#service_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					});

    				$("#search_product").keyup(function(){
						//alert("adsfadf");
						var name=$(this).val();
						$.post("'.base_url('ajax-product-search').'",{name:name},function(data){
							$("#product_search_result ul").html(data);
						})
					});

					// product list clear 
					$("#clear_product_list").click(function(){
						  var modal = $("#service_product")
						  modal.find(".modal-body input#search_product").val("")
						  modal.find(".modal-body input#product_id").val("")
						  modal.find(".modal-body textarea#description").val("")
						  modal.find(".modal-body #product_search_result ul").empty()
					})

					$("#save_service_product").click(function(e){
						e.preventDefault();
						var product_id=$("#product_id").val();
						var product_name=$("#search_product").val();
						var description=$("#description").val();
						if(product_id && product_name){
							$.post("'.base_url('modify-ajax-save-in-session-service-product').'",{product_id:product_id,product_name:product_name,description:description},function(response){
									$("#selected_product_result").html(response);
									$(".modal").modal("hide");
								})
						}else{
							alert("Select a Product");
						}
					})

    			})// end doc ready function

    			function select_this_product(data){
    				var product_id = $(data).attr("data-id");
					var name = $(data).text();
					$("#product_id").val(product_id);
					$("#search_product").val(name);
					$("#product_search_result ul").empty();
					
    			}


				function this_value_update(data){
					var cart_index=$(data).attr("data-index");
					var val=$(data).val();
					val=val.replace(/^"|"$/g, \'\');
					var name=$(data).attr("name");
					$.post("'.base_url('ajax-service-product-modify-cart-update').'",{cart_index:cart_index,val:val,name:name},function(response){
							$.noop();
						})
				}

				function modify_cart_to_remove(data){
					if(confirm("Are you sure?")){
						var index=$(data).attr("data-index");
						$.post("'.base_url('ajax-remove-from-modify-service-cart').'",{index:index},function(response){
							$("#selected_product_result").html(response);
						})
					}
				}
    		</script>
    	';
            $this->load->view('master',$data);
        }
	}

	public function add_to_modify_cart($data) {

		// Whenever a user adds an item to their cart, pull out any they already have in there

		$cart_products = $this->session->userdata('modify_service_cart_products');

		// Add the new item

		$cart_products[] = $data;

		// And put it back into the session

		$this->session->set_userdata('modify_service_cart_products', $cart_products);

		return $this->session->userdata('modify_service_cart_products');

	}

	public function service_product_save_in_session_modify(){

    	$data=$this->input->post();
    	$result=$this->add_to_modify_cart($data);
    	$this->display_cart_product($result);
    }

    public function modify_cart_update(){
		
		$cart_products=$this->session->userdata('modify_service_cart_products');

		$index=$this->input->post('cart_index',TRUE);

		$selected_product=$cart_products[$index];

		$name=$this->input->post('name',TRUE);

		$val=$this->input->post('val',TRUE);

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key==$index){
				$data=$value;
				if($name=='description'){
					$data["description"]=$val;
				}
				$new_cart[]=$data;
			}else{
				$new_cart[]=$value;
			}
		}
		$this->session->set_userdata('modify_service_cart_products',$new_cart);
	}

	public function remove_from_modify_cart(){
		$index=$this->input->post('index',TRUE);

		$cart_products=$this->session->userdata('modify_service_cart_products');

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key!=$index){
				$new_cart[]=$value;
			}
		}
		
		$this->session->set_userdata('modify_service_cart_products',$new_cart);
		$result=$this->session->userdata('modify_service_cart_products');
		$this->display_cart_product($result);
	}

	public function update(){
		$cart_products=$this->session->userdata('modify_service_cart_products');
		if(count($cart_products)>0){
			if($this->input->post('service')){
				$this->form_validation->set_rules('service', 'Service No', 'trim|required',
                    array(
                    	'required' => 'You must provide a %s.'
                 	)
	            );

	            if ($this->form_validation->run() == TRUE){

	            	
	            	$data['contact']=$this->input->post('contact',TRUE);
	            	$data['details']=$this->input->post('details',TRUE);
	            	$data['updated_by']=$this->session->userdata('userId');
	            	$service_id=$this->input->post('service');
	            	$this->MService->update($data,$service_id);

	            	$this->MService->update_service_product($service_id,$cart_products);
	 
	            	


	            	$this->session->unset_userdata('modify_service_cart_products');

	            	$this->session->set_flashdata('success', '"SR-'.$service_id.'" successfully updated');
					redirect('service-list', 'refresh');

	            }else{
	            	redirect('service-list', 'refresh');
	            }
			}else{
				$this->session->set_flashdata('error', 'You are trying to update an invalid service');
				redirect('service-list', 'refresh');
			}
		}else{
			$this->session->set_flashdata('error', 'Without product service will not be create or update');
	        redirect('service-list', 'refresh');
		}
	}

	public function service_trash(){
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
            $this->MService->delete($id);
            $this->session->set_flashdata('success', 'A Service deleted');
            redirect('service-list', 'refresh');
        }
	}

	public function service_trash_list(){
		$this->load->helper('date');
        $services=$this->MService->getAllTrash();

        $data["page_title"] = "Service List (Trash)";
        $data["main_content"] = $this->load->view('service/list_trash',array('services'=>$services),true);
        
        $this->load->view('master',$data);
	}

	public function service_trash_to_move(){
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
            $this->MService->move($id);
            $this->session->set_flashdata('success', 'A Service successully moved');
            redirect('service-list', 'refresh');
        }
	}

	// details
	public function details(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }else{
            $service = $this->uri->segment(2);

            $service_data=$this->MService->getInfoById($service);

            $data["page_title"] = "Detail about service: SR-".$service_data[0]->id;
            
            $data["main_content"] = $this->load->view('service/details',['service_data'=>$service_data],true);
            
            $data["page_script"]="
                <script>
                    $(document).ready(function() {
                        $('#prof_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', {
                                    extend: 'pdf',
                                    title: 'Service Particulars of SR-".$service_data[0]->id."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':false,
                            'stripHtml': true
                        } );
                        
                        $('#event_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel',{
                                    extend: 'pdf',
                                    title: 'Event History of SR-".$service_data[0]->id."'
                                }, 'print'
                            ],
                            'bSort': false,
                            'paging': false,
                            'bInfo' : false,
                            'bFilter':true,
                            'stripHtml': true
                        } );
                    } );

                </script>
            ";
            $this->load->view('master',$data);
        
        }
    
	}

}