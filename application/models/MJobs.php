<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MJobs extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	// create new job
	public function create($data){
		$this->db->insert('job_master',$data);
		return $this->db->insert_id();
	}

	// update job 
	public function update($data,$job_id){
		$sql="update job_master set prime_contact=?,job_details=?,type=?,custome_no=?, updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data["prime_contact"],$data["job_details"],$data["type"],$data["custome_no"],$data["updated_by"],$job_id]);
	}

	// insert job products with requirement details
	public function add_job_product($job_id,$cart_products){
		$data=array();
		foreach($cart_products as $k=>$val){
			$data[]=array(
				'job_id'=>$job_id,
				'product_id'=>$val['product_id'],
				'requirement_details'=>$val['data'],
				'additional_details'=>$val['description'],
				'created_by'=>$this->session->userdata('userId')
			);
		}

		$this->db->insert_batch('job_product', $data);

	}

	// update job products
	public function update_job_product($job_id,$cart_products){

		// check & delete first
		$idarray=array_column($cart_products, 'id');
		$ids=implode(',', $idarray);

		if(count($idarray)>0){

			$sql = "update job_product set deleted=?,deleted_by=?,deleted_at=now() WHERE id NOT IN ({$ids})";
			$this->db->query($sql,[1,$this->session->userdata('userId')]);
		}else{
			$sql = "update job_product set deleted=?,deleted_by=?,deleted_at=now() WHERE job_id=?";
			$this->db->query($sql,[1,$this->session->userdata('userId'),$job_id]);
		}

		foreach($cart_products as $k=>$val){
			if(isset($val["id"])){
				// update
				$sql="update job_product set requirement_details=?,additional_details=?,updated_by=?,updated_at=now() where id=?";
				$this->db->query($sql,[$val["data"],$val["description"],$this->session->userdata('userId'),$val["id"]]);
			}else{
				// insert
				$data=array(
					'job_id'=>$job_id,
					'product_id'=>$val['product_id'],
					'requirement_details'=>$val['data'],
					'additional_details'=>$val['description'],
					'created_by'=>$this->session->userdata('userId')
				);
				$this->db->insert('job_product', $data);
			}
		}
	}

	public function save_attachment($attachments,$job_id){

		$data=array();
		foreach($attachments as $k=>$val){
			$data[]=array(
				'job_id'=>$job_id,
				'attachment_name'=>$val,
				'attach_by'=>$this->session->userdata('userId')
			);
		}

		$this->db->insert_batch('job_attachment', $data);

	}

	public function get_job_list(){

		$userRole=$this->session->userdata('userRole');

		if($userRole!=3){
			$sql="
				select 
				a.id,
				a.customer,
				a.custome_no,
				a.prime_contact,
				a.drowing,
				a.offer,
				a.type,
				a.created_by,
				a.created_at,
				b.name as customer_name,
				b.cust_type,
				e.name as cust_type_name,
				c.name as contact_name,
				c.department,
				c.designation,
				c.phone,
				c.email,
				d.user_name,
				(select user_name from users where id=a.co_handler) as co_handler_name,
				(select user_name from users where id=a.ma_handler) as ma_handler_name,
				(select user_name from users where id=a.de_handler) as de_handler_name,
				(select x.name from designation x,users y where y.id=a.co_handler and x.id=y.designation) as co_desig,
				(select x.name from designation x,users y where y.id=a.ma_handler and x.id=y.designation) as ma_desig,
				(select x.name from designation x,users y where y.id=a.de_handler and x.id=y.designation) as de_desig,
				(select group_concat(product_id) from job_product where job_id=a.id) as products,
				a.offer_by,
				a.drawing_by,
				a.visit_site
				from 
				job_master a,
				customers b,
				contacts c,
				users d,
				customer_type e
				where a.deleted<>1 
				and a.job_status=0
				and b.id=a.customer 
				and c.id=a.prime_contact
				and d.id=a.created_by
				and e.id=b.cust_type
			";
		}else{
			$user=$this->session->userdata('userId');
			$sql="
				select 
				a.id,
				a.customer,
				a.custome_no,
				a.prime_contact,
				a.drowing,
				a.offer,
				a.type,
				a.created_by,
				a.created_at,
				b.name as customer_name,
				b.cust_type,
				e.name as cust_type_name,
				c.name as contact_name,
				c.department,
				c.designation,
				c.phone,
				c.email,
				d.user_name,
				(select user_name from users where id=a.co_handler) as co_handler_name,
				(select user_name from users where id=a.ma_handler) as ma_handler_name,
				(select user_name from users where id=a.de_handler) as de_handler_name,
				(select x.name from designation x,users y where y.id=a.co_handler and x.id=y.designation) as co_desig,
				(select x.name from designation x,users y where y.id=a.ma_handler and x.id=y.designation) as ma_desig,
				(select x.name from designation x,users y where y.id=a.de_handler and x.id=y.designation) as de_desig,
				(select group_concat(product_id) from job_product where job_id=a.id) as products,
				a.offer_by,
				a.drawing_by,
				a.visit_site
				from 
				job_master a,
				customers b,
				contacts c,
				users d,
				customer_type e
				where a.deleted<>1 
				and a.job_status=0
				and b.id=a.customer 
				and c.id=a.prime_contact
				and d.id=a.created_by
				and e.id=b.cust_type
				and (a.created_by={$user} or a.co_handler={$user} or a.ma_handler={$user} or a.de_handler={$user})
			";
		}
		$result=$this->db->query($sql);
		return $result->result();
	}

	public function getInfoById($id){
		$sql="
			select 
			a.id,
			a.customer,
			a.custome_no,
			a.prime_contact,
			a.job_details,
			a.type,
			b.name as customer_name,
			c.name as contact_name,
			c.phone as contact_phone,
			d.user_name,
			a.created_at,
			(select group_concat(product_id) from job_product where job_id=a.id) as products,
			(select user_name from users where id=a.co_handler) as co_handler_name,
			(select user_name from users where id=a.ma_handler) as ma_handler_name,
			(select user_name from users where id=a.de_handler) as de_handler_name,
			(select x.name from designation x,users y where y.id=a.co_handler and x.id=y.designation) as co_desig,
			(select x.name from designation x,users y where y.id=a.ma_handler and x.id=y.designation) as ma_desig,
			(select x.name from designation x,users y where y.id=a.de_handler and x.id=y.designation) as de_desig
			from 
			job_master a,
			customers b,
			contacts c,
			users d
			where 
			b.id=a.customer 
			and c.id=a.prime_contact
			and d.id=a.created_by
			and a.id=?
		";
		$result=$this->db->query($sql,[$id]);
		return $result->result();
	}

	public function get_products_by_job_id($job_id){
		$sql="
			select 
			a.id,
			a.product_id,
			b.name as product_name,
			a.requirement_details as data,
			a.additional_details as description
			from job_product a,
			products b
			where a.job_id=? and b.id=a.product_id and a.deleted<>1
		";
		return $this->db->query($sql,[$job_id])->result_array();

	}

	// delete a job
	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update job_master set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}

	// getAllTrash list
	public function getAllTrash(){
		$sql="select a.id,a.type,a.deleted_at,b.user_name,b.user_role from job_master a, users b where a.deleted_by=b.id and a.deleted=1 order by a.deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update job_master set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	public function get_handler($job){
		$sql="select id,type,co_handler,ma_handler,de_handler from job_master where id=?";
		return $this->db->query($sql,[$job])->row();
	}

	// save job handler
	public function update_handler($data,$job){
		$de='';
		if($this->input->post('de_handler')){
			$de=$this->input->post('de_handler',TRUE);
		}
		$sql="update job_master set co_handler=?,ma_handler=?,de_handler=? where id=?";
		$this->db->query($sql,[$data["co_handler"],$data["ma_handler"],$de,$job]);

		// get job information
		$jobData=$this->getInfoById($job);

		// sender info
		$ssql="select user_name,user_email from users where id=?";
		$sresult=$this->db->query($ssql,[$this->session->userdata('userId')])->row();

		// send notification to co_handler via email
		$csql="select user_email from users where id=?";
		$cresult=$this->db->query($csql,[$data["co_handler"]])->row();

		$msg["subject"]='Corresponding Handler Notification';
		$msg["message"]='Mr. '.$sresult->user_name.' has assigned you as a corresponding handler on Task-'.$job.', created by'.$jobData[0]->user_name;
		$msg["receipient"]=$cresult->user_email;
		$this->db->insert('email_queue',$msg);

		// Marketing Handler 
		$msql="select user_email from users where id=?";
		$mresult=$this->db->query($msql,[$data["ma_handler"]])->row();

		$msg["subject"]='Marketing Handler Notification';
		
		$msg["message"]='Mr. '.$sresult->user_name.' has assigned you as a marketing handler on Task-'.$job.', created by'.$jobData[0]->user_name;
		$msg["receipient"]=$mresult->user_email;
		$this->db->insert('email_queue',$msg);

		if($de){
			// Design Handler 
			$dsql="select user_email from users where id=?";
			$dresult=$this->db->query($dsql,[$de])->row();
			
			$msg["subject"]='Design Handler Notification';
			$msg["message"]='Mr. '.$sresult->user_name.' has assigned you as a design handler on Task-'.$job.', created by'.$jobData[0]->user_name;
			$msg["receipient"]=$dresult->user_email;
			$this->db->insert('email_queue',$msg);
		}


	}


	// update for close status
	public function update_job_for_close($job,$note){
		$updated_by=$this->session->userdata('userId');
		$sql="update job_master set job_status=?,close_note=?,flag=?,updated_by=?,updated_at=now() where id=?";
		$flag=$this->input->post('flag',TRUE);
		$this->db->query($sql,[1,$note,$flag,$updated_by,$job]);
	}

	// job details from job master

	public function job_master_details_by_id($job){
		$sql="select * from job_master where id=?";
		return $this->db->query($sql,[$job])->row();
	}


	// get closed job list
	public function c_job_list(){
		$sql="select a.id,a.type,a.custome_no,a.close_note,a.flag,a.updated_at,b.user_name,b.user_role from job_master a, users b where a.updated_by=b.id and a.job_status=1 order by a.updated_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// get all design required job list
	public function de_job_list(){
		$sql="
				select 
				a.id,
				a.customer,
				a.custome_no,
				a.prime_contact,
				a.drowing,
				a.offer,
				a.type,
				a.created_by,
				a.created_at,
				b.name as customer_name,
				b.cust_type,
				e.name as cust_type_name,
				c.name as contact_name,
				c.department,
				c.designation,
				c.phone,
				c.email,
				d.user_name,
				(select user_name from users where id=a.co_handler) as co_handler_name,
				(select user_name from users where id=a.ma_handler) as ma_handler_name,
				(select user_name from users where id=a.de_handler) as de_handler_name,
				(select x.name from designation x,users y where y.id=a.co_handler and x.id=y.designation) as co_desig,
				(select x.name from designation x,users y where y.id=a.ma_handler and x.id=y.designation) as ma_desig,
				(select x.name from designation x,users y where y.id=a.de_handler and x.id=y.designation) as de_desig,
				(select group_concat(product_id) from job_product where job_id=a.id) as products,
				a.de_ini_rev,
				a.de_job_position,
				a.de_approved_by_cus,
				a.offer_by,
				a.drawing_by,
				a.visit_site,
				a.de_remark
				from 
				job_master a,
				customers b,
				contacts c,
				users d,
				customer_type e
				where a.deleted<>1 
				and a.job_status=0
				and a.de_handler<>0
				and b.id=a.customer 
				and c.id=a.prime_contact
				and d.id=a.created_by
				and e.id=b.cust_type
			";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// closed job move to main list
	public function c_job_move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update job_master set job_status=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	// requirement send to principle
	public function job_requiremt_send_to_principle(){
		$job=$this->input->post('job');
		foreach($this->input->post('principle') as $k=>$val){
			$job_produt_id=$k;
			foreach($val as $principle){
				$principle_id=$principle;
				$sql="select count(id) as row from job_requirement_to_principle where job=? and job_produt=? and priciple=?";
				$result=$this->db->query($sql,[$job,$job_produt_id,$principle_id])->row();
				$offer_received=$this->input->post('offer_receive')[$job_produt_id][$principle_id];
				if($result->row>0){
					// update
					$query="update job_requirement_to_principle set offer_received=?,updated_by=?,updated_at=now() where job=? and job_produt=? and priciple=?";
					$this->db->query($query,[$offer_received,$this->session->userdata('userId'),$job,$job_produt_id,$principle_id]);
					
					$job_id=$this->db->where(['job'=>$job,'job_produt'=>$job_produt_id,'priciple'=>$principle_id])->get("job_requirement_to_principle")->row()->id;

					if(!empty($_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name'][0])){

						$config = array();
					    $config['upload_path'] = './public/uploads/job/principle_requirement';
					    $config['allowed_types'] = '*';
					    $config['max_size'] = '0'; // 0 = no file size limit
					    $config['max_width']  = '0';
					    $config['max_height']  = '0';
					    $config['overwrite'] = TRUE;


	            		$this->load->library('upload');
				        $files = $_FILES;
				        $cpt = count($_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name']);
				        $attachment=array();
				        for($i=0; $i<$cpt; $i++)
				        {   

				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name']= $job_id.'_'.time().'_'.$files['attachments_'.$job_produt_id.'_'.$principle_id]['name'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['type']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['type'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['tmp_name']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['tmp_name'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['error']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['error'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['size']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['size'][$i]; 


				                $this->upload->initialize($config);
				                if ( ! $this->upload->do_upload('attachments_'.$job_produt_id.'_'.$principle_id))
			                    {
			                        $error = array('error' => $this->upload->display_errors());
			                        print_r($error);
			                        //die();
			                    }
				                $filedata = $this->upload->data();
		                        $attachment[]=$filedata['file_name'];

				        }

				        $this->job_principle_offer_attachment($attachment,$job_id);
	            	}

				}else{
					// insert
					$query="insert into job_requirement_to_principle (job,job_produt,priciple,offer_received,created_by) values (?,?,?,?,?)";
					$this->db->query($query,[$job,$job_produt_id,$principle_id,$offer_received,$this->session->userdata('userId')]);
					$job_id=$this->db->insert_id();

					if(!empty($_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name'][0])){

						$config = array();
					    $config['upload_path'] = './public/uploads/job/principle_requirement';
					    $config['allowed_types'] = '*';
					    $config['max_size'] = '0'; // 0 = no file size limit
					    $config['max_width']  = '0';
					    $config['max_height']  = '0';
					    $config['overwrite'] = TRUE;


	            		$this->load->library('upload');
				        $files = $_FILES;
				        $cpt = count($_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name']);
				        $attachment=array();
				        for($i=0; $i<$cpt; $i++)
				        {   

				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['name']= $job_id.'_'.time().'_'.$files['attachments_'.$job_produt_id.'_'.$principle_id]['name'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['type']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['type'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['tmp_name']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['tmp_name'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['error']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['error'][$i];
				                $_FILES['attachments_'.$job_produt_id.'_'.$principle_id]['size']= $files['attachments_'.$job_produt_id.'_'.$principle_id]['size'][$i]; 


				                $this->upload->initialize($config);
				                if ( ! $this->upload->do_upload('attachments_'.$job_produt_id.'_'.$principle_id))
			                    {
			                        $error = array('error' => $this->upload->display_errors());
			                        print_r($error);
			                        //die();
			                    }
				                $filedata = $this->upload->data();
		                        $attachment[]=$filedata['file_name'];

				        }

				        $this->job_principle_offer_attachment($attachment,$job_id);
	            	}


				}
			}
		}
	}

	public function job_principle_offer_attachment($attachments,$job_id){

		$data=array();
		foreach($attachments as $k=>$val){
			$data[]=array(
				'principle_requirement_id'=>$job_id,
				'attachment_name'=>$val,
				'attach_by'=>$this->session->userdata('userId')
			);
		}

		$this->db->insert_batch('job_principle_offer_attachment', $data);

	}

	// delete_job_requirement_to_principle
	public function delete_job_requirement_to_principle($key){
		$sql="select attachment_name from job_principle_offer_attachment where principle_requirement_id=?";
		$result=$this->db->query($sql,[$key])->result();
		$file_path= './public/uploads/job/principle_requirement';
		foreach($result as $data){
			unlink($file_path.'/'.$data->attachment_name);
		}

		$dsql1="delete from job_principle_offer_attachment where principle_requirement_id=?";
		$this->db->query($dsql1,[$key]);

		$dsql2="delete from job_requirement_to_principle where id=?";
		$this->db->query($dsql2,[$key]);
	}

	//
	public function update_desing_work($data){
		//return $data;
		$sql="update job_master set `".$data['column']."`='".$data['value']."' where id=".$data['job']."";
		$this->db->query($sql);
	}

}