<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MJobs');
    }

    // job create screen
    public function create()
    {
    	$data["page_title"] = 'Create Job / Requirement';

    	$data["main_content"] = $this->load->view('jobs/create','',TRUE);
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
				  $("#job_product").on("show.bs.modal", function (event) {
				      var modal = $("#job_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					  modal.find(".modal-body #product_requirement_form").empty()
					});	

					// insert modal on hide 
				  $("#job_product").on("hide.bs.modal", function (event) {
					  var modal = $("#job_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					  modal.find(".modal-body #product_requirement_form").empty()
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
							$.post("'.base_url('ajax-customer-search').'",{cust_name:cust_name},function(data){
								$("#customer_search_result ul").html(data);
								//alert(data);
							})
						}else{
							$("#customer_search_result ul").html("");
						}
					});

					// product list clear 
					$("#clear_product_list").click(function(){
						  var modal = $("#job_product")
						  modal.find(".modal-body input#search_product").val("")
						  modal.find(".modal-body input#product_id").val("")
						  modal.find(".modal-body textarea#description").val("")
						  modal.find(".modal-body #product_search_result ul").empty()
						  modal.find(".modal-body #product_requirement_form").empty()
					})

					$("#save_job_product").click(function(e){
						e.preventDefault();
						var product_id=$("#product_id").val();
						var product_name=$("#search_product").val();
						var description=$("#description").val();
						if(product_id && product_name){
							if(validateForm()){
								var data=buildRequestStringData($("#product_requirement_form"));
								$.post("'.base_url('ajax-save-in-session-job-product').'",{product_id:product_id,product_name:product_name,data:data,description:description},function(response){
									$("#selected_product_result").html(response);
									$(".modal").modal("hide");
								})
							}else{
								alert("Fill all required field");
							}
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
					
					// get form 
					$.post("'.base_url('ajax-get-product-form').'",{form:form},function(data){
						$("#product_requirement_form").html(data);
					})
    			}

    			function validateForm() {
				  var valid = true;
				  $("#product_requirement_form .form-field").each(function() {
				    valid &= !!$(this).val();
				  });
				  return valid;
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
					var self_index=$(data).attr("data-selfindex");
					if($(data).attr("data-required")==1 && !val){
						alert("This field is required a value");
						location.reload();
					}else{
						$.post("'.base_url('ajax-job-product-cart-update').'",{cart_index:cart_index,val:val,name:name,self_index:self_index},function(response){
							$.noop();
						})
					}
				}

				function cart_to_remove(data){
					if(confirm("Are you sure?")){
						var index=$(data).attr("data-index");
						$.post("'.base_url('ajax-remove-from-cart').'",{index:index},function(response){
							$("#selected_product_result").html(response);
						})
					}
				}
    		</script>
    	';
    	$this->load->view('master',$data);
    }

	public function job_edit(){

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
            $data["page_title"] = "Edit Job";
            $job=$this->MJobs->getInfoById($id);
            $this->load->model('MContact');
            $customer_id=$job[0]->customer;
            $contacts=$this->MContact->getAllByCustomer($customer_id);

            // products
            $products=$this->MJobs->get_products_by_job_id($id);
            //print_r($products);

            $this->session->unset_userdata('modify_cart_products');
            foreach($products as $product){
            	$this->add_to_modify_cart($product);
            }
            $data["main_content"] = $this->load->view('jobs/edit',array('job'=>$job,'contacts'=>$contacts),true);
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
				  $("#job_product").on("show.bs.modal", function (event) {
				      var modal = $("#job_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					  modal.find(".modal-body #product_requirement_form").empty()
					});	

					// insert modal on hide 
				  $("#job_product").on("hide.bs.modal", function (event) {
					  var modal = $("#job_product")
					  modal.find(".modal-body input#search_product").val("")
					  modal.find(".modal-body input#product_id").val("")
					  modal.find(".modal-body textarea#description").val("")
					  modal.find(".modal-body #product_search_result ul").empty()
					  modal.find(".modal-body #product_requirement_form").empty()
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
						  var modal = $("#job_product")
						  modal.find(".modal-body input#search_product").val("")
						  modal.find(".modal-body input#product_id").val("")
						  modal.find(".modal-body textarea#description").val("")
						  modal.find(".modal-body #product_search_result ul").empty()
						  modal.find(".modal-body #product_requirement_form").empty()
					})

					$("#save_job_product").click(function(e){
						e.preventDefault();
						var product_id=$("#product_id").val();
						var product_name=$("#search_product").val();
						var description=$("#description").val();
						if(product_id && product_name){
							if(validateForm()){
								var data=buildRequestStringData($("#product_requirement_form"));
								$.post("'.base_url('modify-ajax-save-in-session-job-product').'",{product_id:product_id,product_name:product_name,data:data,description:description},function(response){
									$("#selected_product_result").html(response);
									$(".modal").modal("hide");
								})
							}else{
								alert("Fill all required field");
							}
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
					
					// get form 
					$.post("'.base_url('ajax-get-product-form').'",{form:form},function(data){
						$("#product_requirement_form").html(data);
					})
    			}

    			function validateForm() {
				  var valid = true;
				  $("#product_requirement_form .form-field").each(function() {
				    valid &= !!$(this).val();
				  });
				  return valid;
				}

				function this_value_update(data){
					var cart_index=$(data).attr("data-index");
					var val=$(data).val();
					val=val.replace(/^"|"$/g, \'\');
					var name=$(data).attr("name");
					var self_index=$(data).attr("data-selfindex");
					if($(data).attr("data-required")==1 && !val){
						alert("This field is required a value");
						location.reload();
					}else{
						$.post("'.base_url('ajax-job-product-modify-cart-update').'",{cart_index:cart_index,val:val,name:name,self_index:self_index},function(response){
							$.noop();
						})
					}
				}

				function modify_cart_to_remove(data){
					if(confirm("Are you want to delete this product from cart?")){
						var index=$(data).attr("data-index");
						$.post("'.base_url('ajax-remove-from-modify-cart').'",{index:index},function(response){
							$("#selected_product_result").html(response);
						})
					}
				}
    		</script>
    	';
            $this->load->view('master',$data);
        }
	}

    public function pro_search(){
    	$pro=$this->input->post('name',true);
    	$this->load->model('MProducts');
    	$data=$this->MProducts->get_product($pro);
    	$return_string="";
    	foreach($data as $k=>$val){
    		$return_string.="
    			<li data-id='".$val->id."' data-form='".$val->requirement_form_id."' onclick='select_this_product(this)'>".$val->name."</li>
    		";
    	}

    	echo $return_string;
    }

    // product requirement form
    public function get_product_form(){
    	$id=$this->input->post('form',TRUE);
    	$this->load->model('MForm_name');

    	$elements=$this->MForm_name->form_elements_by_id($id);

    	foreach ($elements as $key => $value) {
    		echo'<div class="form-group">
    			<label class="control-label">'.$value->input_label.' '.($value->required==1?'<span class="required">* </span>':'').':</label>
    			<input type="text" class="form-control '.($value->required==1?'form-field':'').'" name="'.$value->input_label.'" '.($value->required==1?'required':'').'  autocomplete="off" data-required="'.($value->required==1?'1':'0').'">
    		</div>';
    	}
    }

    public function job_product_save_in_session(){

    	$data=$this->input->post();
    	$result=$this->add_to_cart($data);
    	$this->display_cart_product($result);
    }
    public function job_product_save_in_session_modify(){

    	$data=$this->input->post();
    	$result=$this->add_to_modify_cart($data);
    	$this->display_cart_product($result);
    }

    public function add_to_cart($data) {

		// Whenever a user adds an item to their cart, pull out any they already have in there

		$cart_products = $this->session->userdata('cart_products');

		// Add the new item

		$cart_products[] = $data;

		// And put it back into the session

		$this->session->set_userdata('cart_products', $cart_products);

		return $this->session->userdata('cart_products');

	}

	public function add_to_modify_cart($data) {

		// Whenever a user adds an item to their cart, pull out any they already have in there

		$cart_products = $this->session->userdata('modify_cart_products');

		// Add the new item

		$cart_products[] = $data;

		// And put it back into the session

		$this->session->set_userdata('modify_cart_products', $cart_products);

		return $this->session->userdata('modify_cart_products');

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
    					$elements=json_decode($val["data"]);
				    	foreach ($elements as $key => $value) {
				    		$form.='
				    			<div class="form-group">
				    			<label class="control-label">'.$value->label.' '.($value->required==1?'<span class="required">* </span>':'').':</label>
    								<input data-selfindex="'.$key.'" data-index="'.$k.'" type="text" class="form-control '.($value->required==1?'form-field':'').'" name="'.$value->label.'" '.($value->required==1?'required':'').'  autocomplete="off" data-required="'.($value->required==1?'1':'0').'" value="'.$value->value.'"  onchange="this_value_update(this)">
    							</div>	
				    		';
				    	}
    					$form.='<div class="form-group"><label>Description:</label><textarea class="form-control" data-index="'.$k.'"  onchange="this_value_update(this)" name="description" data-selfindex="dd">'.$val["description"].'</textarea></div></div>';
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

	

	// insert a job into database
	public function insert()
	{
		$cart_products=$this->session->userdata('cart_products');
		if(count($cart_products)>0){
			if($this->input->post('customer_id')){
				$this->form_validation->set_rules('customer_id', 'Company / Customer', 'trim|required',
                    array(
                    	'required' => 'You must provide a %s.'
                 	)
	            );

	            if ($this->form_validation->run() == TRUE){

	            	$data['customer']=$this->input->post('customer_id',TRUE);
	            	$data['prime_contact']=$this->input->post('prime_contact',TRUE);
	            	$data['job_details']=$this->input->post('job_details',TRUE);
	            	$data['type']=$this->input->post('type',TRUE);
	            	$data['custome_no']=$this->input->post('custome_no',TRUE);
	            	$type=$data['type'];
	            	if($this->input->post('drowing')){
	            		$data['drowing']=1;
	            	}
	            	if($this->input->post('offer')){
	            		$data['offer']=1;
	            	}
	            	$data['created_by']=$this->session->userdata('userId');
	            	$data['job_status']=0;

	            	$job_id=$this->MJobs->create($data);

	            	$this->MJobs->add_job_product($job_id,$cart_products);
	            	if(!empty($_FILES['attachments']['name'][0])){

		            	if(count($_FILES['attachments']['name'])>0){
		            		$this->load->library('upload');
					        //$this->uploadfile($_FILES['userfile']);
					        $files = $_FILES;
					        $cpt = count($_FILES['attachments']['name']);
					        $attachment=array();
					        for($i=0; $i<$cpt; $i++)
					        {   

					                $_FILES['attachments']['name']= $job_id.'_'.time().'_'.$files['attachments']['name'][$i];
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

					        $this->MJobs->save_attachment($attachment,$job_id);
		            	}

					}
	            	$this->session->unset_userdata('cart_products');

	            	$this->session->set_flashdata('success', '"'.($type==1?'T':$type==2?'CM':'MHD').'-'.$job_id.'" successfully created');
					redirect('job-list', 'refresh');

	            }else{
	            	$this->create();
	            }
			}else{
				$this->session->set_flashdata('error', 'Select a company / customer properly');
				$this->create();
			}
		}else{
			$this->session->set_flashdata('error', 'Without product Job / Requirement will not be create');
	        redirect('job-create', 'refresh');
		}
	}

	// update job
	public function update(){
		$cart_products=$this->session->userdata('modify_cart_products');
		//if(count($cart_products)>0){
			if($this->input->post('job')){

				$this->form_validation->set_rules('job', 'Job', 'trim|required',
                    array(
                    	'required' => 'You must provide a %s.'
                 	)
	            );

	            if ($this->form_validation->run() == TRUE){

	            	
	            	$data['prime_contact']=$this->input->post('prime_contact',TRUE);
	            	$data['job_details']=$this->input->post('job_details',TRUE);
	            	$type=$data['type']=$this->input->post('type',TRUE);
	            	$data['custome_no']=$this->input->post('custome_no',TRUE);
	            	if($this->input->post('drowing')){
	            		$data['drowing']=1;
	            	}
	            	if($this->input->post('offer')){
	            		$data['offer']=1;
	            	}
	            	$data['updated_by']=$this->session->userdata('userId');
	            	$job_id=$this->input->post('job');
	            	$this->MJobs->update($data,$job_id);

	            	if(count($cart_products)>0){
	            		$this->MJobs->update_job_product($job_id,$cart_products);
	 				}

	            	if(!empty($_FILES['attachments']['name'][0])){
	            		$this->load->library('upload');
				        //$this->uploadfile($_FILES['userfile']);
				        $files = $_FILES;
				        $cpt = count($_FILES['attachments']['name']);
				        $attachment=array();
				        for($i=0; $i<$cpt; $i++)
				        {   

				                $_FILES['attachments']['name']= $job_id.'_'.time().'_'.$files['attachments']['name'][$i];
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

				        $this->MJobs->save_attachment($attachment,$job_id);
	            	}


	            	$this->session->unset_userdata('modify_cart_products');

	            	$this->session->set_flashdata('success', '"'.($type==1?'T':$type==2?'CM':'MHD').'-'.$job_id.'" successfully updated');
					redirect('job-list', 'refresh');

	            }else{
	            	redirect('job-list', 'refresh');
	            }
			}else{
				$this->session->set_flashdata('error', 'You are trying to update an invalid job');
				redirect('job-list', 'refresh');
			}
		/*}else{
			$this->session->set_flashdata('error', 'Without product Job / Requirement will not be create or update');
	        redirect('job-list', 'refresh');
		}*/
	}

	// cart update

	public function cart_update(){
		
		$cart_products=$this->session->userdata('cart_products');

		$index=$this->input->post('cart_index',TRUE);

		$selected_product=$cart_products[$index];

		$name=$this->input->post('name',TRUE);

		$val=$this->input->post('val',TRUE);
		$self_index=$this->input->post('self_index',TRUE);

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key==$index){
				$data=$value;
				if($name=='description'){
					$data["description"]=$val;
				}else{
					$form_field_data=json_decode($data["data"]);

					$form_field_data[$self_index]->value=$val;
					$data["data"]=json_encode($form_field_data);
				}
				$new_cart[]=$data;
			}else{
				$new_cart[]=$value;
			}
		}
		$this->session->set_userdata('cart_products',$new_cart);
	}

	public function modify_cart_update(){
		
		$cart_products=$this->session->userdata('modify_cart_products');

		$index=$this->input->post('cart_index',TRUE);

		$selected_product=$cart_products[$index];

		$name=$this->input->post('name',TRUE);

		$val=$this->input->post('val',TRUE);
		$self_index=$this->input->post('self_index',TRUE);

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key==$index){
				$data=$value;
				if($name=='description'){
					$data["description"]=$val;
				}else{
					$form_field_data=json_decode($data["data"]);

					$form_field_data[$self_index]->value=$val;
					$data["data"]=json_encode($form_field_data);
				}
				$new_cart[]=$data;
			}else{
				$new_cart[]=$value;
			}
		}
		$this->session->set_userdata('modify_cart_products',$new_cart);
	}

	public function remove_from_cart(){
		$index=$this->input->post('index',TRUE);

		$cart_products=$this->session->userdata('cart_products');

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key!=$index){
				$new_cart[]=$value;
			}
		}
		
		$this->session->set_userdata('cart_products',$new_cart);
		$result=$this->session->userdata('cart_products');
		$this->display_cart_product($result);
	}
	public function remove_from_modify_cart(){
		
		$index=$this->input->post('index',TRUE);

		$cart_products=$this->session->userdata('modify_cart_products');

		$new_cart=array();

		foreach($cart_products as $key=>$value){
			if($key!=$index){
				$new_cart[]=$value;
			}
		}
		
		$this->session->set_userdata('modify_cart_products',$new_cart);
		$result=$this->session->userdata('modify_cart_products');
		$this->display_cart_product($result);
	}


	private function set_upload_options()
	{   
	//  upload an image and document options
	    $config = array();
	    $config['upload_path'] = './public/uploads/job/';
	    $config['allowed_types'] = '*';
	    $config['max_size'] = '0'; // 0 = no file size limit
	    $config['max_width']  = '0';
	    $config['max_height']  = '0';
	    $config['overwrite'] = TRUE;


	    return $config;
	}

	// job list
	public function job_list(){
		$jobs=$this->MJobs->get_job_list();
		$data['page_title']='Job List';
		$data["main_content"] = $this->load->view('jobs/list',array('jobs'=>$jobs),true);
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

	// delete job
	public function job_trash(){
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
            $this->MJobs->delete($id);
            $this->session->set_flashdata('success', 'A Job deleted');
            redirect('job-list', 'refresh');
        }
	}

	public function job_trash_list(){
		$this->load->helper('date');
        $jobs=$this->MJobs->getAllTrash();

        $data["page_title"] = "Job List (Trash)";
        $data["main_content"] = $this->load->view('jobs/list_trash',array('jobs'=>$jobs),true);
        
        $this->load->view('master',$data);
	}

	public function job_trash_to_move(){
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
            $this->MJobs->move($id);
            $this->session->set_flashdata('success', 'A Job successully moved');
            redirect('job-list', 'refresh');
        }
	}

	public function job_handler_setup(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$job = $this->uri->segment(2);
        	// get handler details
        	$handler=$this->MJobs->get_handler($job);
        	$this->load->model('Muser');
        	$users=$this->Muser->get_user_for_list();
        	$data["page_title"] = "Job Handler Setup <small>for the JOB: <u><b>".($handler->type==1?'T':($handler->type==2?'CM':'MHD'))."-".$job."</b></u></small>";
	        $data["main_content"] = $this->load->view('jobs/job_handler',['handler'=>$handler,'users'=>$users],true);
	        
	        $this->load->view('master',$data);

        }
	}

	// save job handler
	public function job_handler_save(){
		$this->form_validation->set_rules('job', 'Job No', 'trim|required',
            array(
            	'required' => 'You must provide a %s.'
         	)
        );
        $this->form_validation->set_rules('co_handler', 'Corresponding Handler', 'trim|required',
            array(
            	'required' => 'You must select a %s.'
         	)
        );
        $this->form_validation->set_rules('ma_handler', 'Marketing Handler', 'trim|required',
            array(
            	'required' => 'You must select a %s.'
         	)
        );

        if ($this->form_validation->run() == TRUE){
        	$data["co_handler"]=$this->input->post('co_handler',TRUE);
        	$data["ma_handler"]=$this->input->post('ma_handler',TRUE);
        	$job=$this->input->post('job',TRUE);

        	$this->MJobs->update_handler($data,$job);

        	$this->session->set_flashdata('success', 'Saved');
            redirect('job-list', 'refresh');
        }else{
        	//$this->session->set_flashdata('success', 'Saved');
            redirect('job-list', 'refresh');
        }
	}

	// job close 
	public function job_close(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$job = $this->uri->segment(2);
        	$job_details=$this->MJobs->job_master_details_by_id($job);
        	$data["page_title"] = "Close Job:  <small><u><b>".($job_details->type==1?'T':($job_details->type==2?'CM':'MHD'))."-".$job."</b></u></small>";
	        $data["main_content"] = $this->load->view('jobs/job_close',['job'=>$job,'job_details'=>$job_details],true);
	        $this->load->view('master',$data);

        }
	}

	public function job_close_update(){
		$this->form_validation->set_rules('close_note', 'Job Close Note', 'trim|required',
            array(
            	'required' => 'You must put a %s.'
         	)
        );
        $this->form_validation->set_rules('job', 'Job Number', 'trim|required',
            array(
            	'required' => 'Please select a %s properly.'
         	)
        );
        if ($this->form_validation->run() == TRUE){
        	$job=$this->input->post('job',TRUE);
        	$note=$this->input->post('close_note',TRUE);
	    	$this->MJobs->update_job_for_close($job,$note);
	    	$this->session->set_flashdata('success', 'A Job closed now');
	        redirect('job-list', 'refresh');
    	}else{
    		redirect('job-list', 'refresh');
    	}
	}
	// closed job list
	public function c_job_list(){
		$jobs=$this->MJobs->c_job_list();
		$data["page_title"] = "Closed Job List";
        $data["main_content"] = $this->load->view('jobs/clist',['jobs'=>$jobs],true);
        
        $this->load->view('master',$data);

	}

	public function c_job_move(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$job = $this->uri->segment(2);
        	
        	$this->MJobs->c_job_move($job);
	    	$this->session->set_flashdata('success', 'Moved');
	        redirect('job-list', 'refresh');
        }
	}

	// requirement send to principle
	public function job_requirement_send_to_principle(){
		if ($this->uri->segment(2) === FALSE)
        {
            if ($this->agent->is_referral())
            {
                echo $this->agent->referrer();
            }
        }
        else
        {
        	$job = $this->uri->segment(2);
        	// products of this job
        	$products=$this->MJobs->get_products_by_job_id($job);
        	$jobData=$this->MJobs->getInfoById($job)[0];

        	$data["page_title"] = "Requirement send to principle for the  JOB: <small><u><b>".($jobData->type==1?'T':($jobData->type==2?'CM':'MHD'))."-".$job."</b></u></small>";
	        $data["main_content"] = $this->load->view('jobs/job_requirement_to_principle',['job'=>$job,'products'=>$products],true);
	        $data["page_script"]='<script>
	        	function update_requirement_to_principle(data){
	        		if(confirm("If you uncheck it then it will be deleted from database with respective attachment data. Are you want to do it?")){
	        			var job=$("input[name=\'job\']").val();
	        			var job_product=$(data).attr("data-product");
	        			var key=$(data).attr("data-key");
	        			var principle=$(data).val();
	        			$.post("'.base_url("job-requirement-remove").'",{job:job,job_product:job_product,principle:principle,key:key},function(response){
	        				$(data).removeAttr("onclick");
	        				console.log(response);
	        			})
	        		}else{
	        			$(data).prop("checked",true);
	        		}
	        	}
	        </script>';
	        $this->load->view('master',$data);
        }
	}


	// principle requirement save
	public function job_requirement_send(){
		
		if($this->input->post('job')){
			$this->MJobs->job_requiremt_send_to_principle();
		}

		$this->session->set_flashdata('success', 'Saved');
	    redirect('job-list', 'refresh');
		
	}


	// delete
	public function job_requirement_delete(){
		$job=$this->input->post('job');
		$job_product=$this->input->post('job_product');
		$principle=$this->input->post('principle');
		$key=$this->input->post('key');
		$this->MJobs->delete_job_requirement_to_principle($key);
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
            $job = $this->uri->segment(2);

            $job_data=$this->MJobs->getInfoById($job);

            $data["page_title"] = "Detail about job: ".($job_data[0]->type==1?'T':($job_data[0]->type==2?'CM':'MHD'))."-".$job_data[0]->id;
            
            $data["main_content"] = $this->load->view('jobs/details',['job_data'=>$job_data],true);
            
            $data["page_script"]="
                <script>
                    $(document).ready(function() {
                        $('#prof_table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', {
                                    extend: 'pdf',
                                    title: 'Job Particulars of ".($job_data[0]->type==1?'T':$job_data[0]->type==2?'CM':'MHD')."-".$job_data[0]->id."'
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
                                    title: 'Sended Requirement Details of ".($job_data[0]->type==1?'T':$job_data[0]->type==2?'CM':'MHD')."-".$job_data[0]->id."'
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
                                    title: 'Event History of ".($job_data[0]->type==1?'T':$job_data[0]->type==2?'CM':'MHD')."-".$job_data[0]->id."'
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

	// active job list for design
	public function de_list(){
		$jobs=$this->MJobs->de_job_list();
		$data["page_title"] = "Design Status";
        $data["main_content"] = $this->load->view('jobs/delist',['jobs'=>$jobs],true);
        $data["page_script"]='<script>
        $(document).ready(function(){
        	$("#datatable-responsive").DataTable( {
	                dom: \'Bfrtip\',
	                buttons: [
	                    \'copy\', \'csv\', \'excel\',\'pdf\', \'print\'
	                ],
	                \'bSort\': false,
	                \'paging\': false,
	                \'bInfo\' : false,
	                \'bFilter\':false,
	                \'stripHtml\': true
	            } );
	        }
		})
        	function update_this_in_job_master(data,job){
        		var job=job;
        		var field=$(data).attr("name");
        		var value=$(data).val();
        		var url=base_url+"update-desing-work";
        		$.post(url,{job:job,field:field,value:value},function(res){
        			$.noop();
        		});
        		
        	}
        </script>';
        $this->load->view('master',$data);
	}

	// update data from design board 
	public function update_design_work(){
		$data["job"]=$this->input->post('job',true);
		$data["column"]=$this->input->post('field',true);
		$data["value"]=$this->input->post('value',true);
		$this->MJobs->update_desing_work($data);
	}

}