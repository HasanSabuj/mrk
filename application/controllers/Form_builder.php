<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_builder extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        // chekc authentication
        if(!is_logged_in()){
        	redirect('auth');
        }

        $this->load->model('MForm_name');
    }

    public function create(){
    	$data["page_title"] = "Create New Form";
        $data["main_content"] = $this->load->view('forms/create','',true);
        $data["page_script"] = "
        	<script>
        		$(document).ready(function(){
        			$('#add_element').click(function(){
        				var table = $('#result_table tbody');
        				var tr = $('#result_table tbody tr');
        				var tr_length = tr.length+1;
        				var append_value = '<tr><td>\
        				Label Name:<br/><input type=\'text\' name=\'label[]\' class=\'form-control\' value=\'Label '+tr_length+'\' required></td><td>\
        				Required:<br/><select class=\'form-control\' name=\'required[]\'><option value=\'0\'>No</option><option value=\'1\'>Yes</option></select></td></tr>';
        				table.append(append_value);
        			})
        		})

                function remove_last_tr(){
                    var tr = $('#result_table tbody tr:last');
                    $(tr).remove();
                }
        	</script>
        ";
        $this->load->view('master',$data);
    }

    public function insert(){
        if($this->input->post('label')){
        	$data['name'] = $this->input->post('name',TRUE);
        	$id = $this->MForm_name->create_main($data);
        	$label = $this->input->post('label',TRUE);
        	$required = $this->input->post('required',TRUE);

        	$this->MForm_name->insert_form_details($id,$label,$required);

        	$this->session->set_flashdata('success', '"'.$data['name'].'" Successfully Added');
    	    redirect('form-list', 'refresh');
        }else{
           $this->session->set_flashdata('error', 'Without Form Element Form Creation Not Allowed');
           redirect('form-add','refresh');
        }
    }

    public function flist(){
    	$data["page_title"] = "Requirement Form List";
        $forms=$this->MForm_name->get_all_forms();
        $data["main_content"] = $this->load->view('forms/form_list',array('forms'=>$forms),true);
        $data['page_script'] = "
        	<script>
        		$(document).on('shown.bs.tab', 'a[data-toggle=\"tab\"]', function (e) {
        			var id=$(e.currentTarget).attr('data-id');
                    var name=$(e.currentTarget).text();
				    $.post('".base_url('get_form_by_id_ajax')."',{id:id,name:name},function(result){
						$('#tab_result').html(result);
						//console.log(result);
					})
				})

                function delete_form(data){
                    if(confirm('Are you sure')){
                        var url=$(data).attr('data-href');
                        var link = document.createElement('a');
                        link.href = url;
                        document.body.appendChild(link);
                        link.click();
                    }
                }
        	</script>
        ";
        $this->load->view('master',$data);
    }

    public function ajax_preview(){
    	$id=$this->input->post('id',TRUE);
        $name=$this->input->post('name',TRUE);
    	$elements = $this->MForm_name->form_elements_by_id($id);
    	echo '<div class="tab-pane active" id="form_'.$id.'">';
    	echo'<p class="lead">'.$name.'</p>';
    	foreach ($elements as $key => $value) {
    		echo'<div class="form-group">
    			<label class="control-label">'.$value->input_label.' '.($value->required==1?'<span class="required">* </span>':'').':</label>
    			<input type="text" class="form-control">
    		</div>';
    	}
    	echo'</div>';
    }

    // delete a form
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
            $form_id=$this->uri->segment(2);

            $result=$this->MForm_name->delete($form_id);

            if($result==1){
                $this->session->set_flashdata('success', 'Form successfully deleted');
                //redirect('form-list', 'refresh');
            }else{
                $this->session->set_flashdata('info', 'This form is assigned with a product, so it is not deleted');
                
            }

           redirect('form-list', 'refresh'); 
        }
    }
}