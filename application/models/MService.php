<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MService extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// create new service
	public function create($data){
		$this->db->insert('service_master',$data);
		return $this->db->insert_id();
	}

	// insert service products with requirement details
	public function add_job_product($service_id,$cart_products){
		$data=array();
		foreach($cart_products as $k=>$val){
			$data[]=array(
				'service_id'=>$service_id,
				'product_id'=>$val['product_id'],
				'additional_details'=>$val['description'],
				'created_by'=>$this->session->userdata('userId')
			);
		}

		$this->db->insert_batch('service_product', $data);

	}

	// get service list
	public function get_service_list(){
		$sql="
			select 
			a.id,
			a.customer,
			a.contact,
			a.created_by,
			a.created_at,
			b.name as customer_name,
			c.name as contact_name,
			c.department,
			c.designation,
			c.phone,
			c.email,
			d.user_name,
			(select user_name from users where id=a.handler) as handler_name,
			(select x.name from designation x,users y where y.id=a.handler and x.id=y.designation) as handler_desig,
			(select group_concat(product_id) from service_product where service_id=a.id) as products
			from 
			service_master a,
			customers b,
			contacts c,
			users d
			where a.deleted<>1 
			and a.closed<>1
			and b.id=a.customer 
			and c.id=a.contact
			and d.id=a.created_by
		";

		$result=$this->db->query($sql);
		return $result->result();
	}

	public function get_handler($service){
		$sql="select id,handler from service_master where id=?";
		return $this->db->query($sql,[$service])->row();
	}

	// save service handler
	public function update_handler($data,$service){
		
		$sql="update service_master set handler=? where id=?";
		$this->db->query($sql,[$data["handler"],$service]);

		

		// sender info
		$ssql="select user_name,user_email from users where id=?";
		$sresult=$this->db->query($ssql,[$this->session->userdata('userId')])->row();

		// send notification to co_handler via email
		$csql="select user_email from users where id=?";
		$cresult=$this->db->query($csql,[$data["handler"]])->row();

		$msg["subject"]='Service Handler Notification';
		$msg["message"]=$sresult->user_name.' has been assigned to you as a handler on SR-'.$service;
		$msg["receipient"]=$cresult->user_email;
		$this->db->insert('email_queue',$msg);


	}

	public function service_master_details_by_id($service){
		$sql="select * from service_master where id=?";
		return $this->db->query($sql,[$service])->row();
	}

	public function update_service_for_close($service,$note){
		$updated_by=$this->session->userdata('userId');
		$sql="update service_master set closed=?,close_note=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[1,$note,$updated_by,$service]);
	}

	public function c_service_list(){
		$sql="select a.id,a.close_note,a.updated_at,b.user_name,b.user_role from service_master a, users b where a.updated_by=b.id and a.closed=1 order by a.updated_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	public function c_service_move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update service_master set closed=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	public function getInfoById($id){
		$sql="
			select 
			a.id,
			a.customer,
			a.contact,
			a.details,
			b.name as customer_name,
			c.name as contact_name,
			d.user_name,
			a.created_at,
			(select group_concat(product_id) from service_product where service_id=a.id) as products,
			(select user_name from users where id=a.handler) as handler_name,
			(select x.name from designation x,users y where y.id=a.handler and x.id=y.designation) as handler_desig
			from 
			service_master a,
			customers b,
			contacts c,
			users d
			where 
			b.id=a.customer 
			and c.id=a.contact
			and d.id=a.created_by
			and a.id=?
		";
		$result=$this->db->query($sql,[$id]);
		return $result->result();
	}

	public function get_products_by_service_id($service_id){
		$sql="
			select 
			a.id,
			a.product_id,
			b.name as product_name,
			a.additional_details as description
			from service_product a,
			products b
			where a.service_id=? and b.id=a.product_id and a.deleted<>1
		";
		return $this->db->query($sql,[$service_id])->result_array();

	}

	public function update($data,$service_id){
		$sql="update service_master set contact=?,details=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data["contact"],$data["details"],$data["updated_by"],$service_id]);
	}

	public function update_service_product($service_id,$cart_products){

		// check & delete first
		$idarray=array_column($cart_products, 'id');
		$ids=implode(',', $idarray);

		if(count($idarray)>0){

			$sql = "update service_product set deleted=?,deleted_by=?,deleted_at=now() WHERE id NOT IN ({$ids})";
			$this->db->query($sql,[1,$this->session->userdata('userId')]);
		}else{
			$sql = "update service_product set deleted=?,deleted_by=?,deleted_at=now() WHERE service_id=?";
			$this->db->query($sql,[1,$this->session->userdata('userId'),$service_id]);
		}

		foreach($cart_products as $k=>$val){
			if(isset($val["id"])){
				// update
				$sql="update service_product set additional_details=?,updated_by=?,updated_at=now() where id=?";
				$this->db->query($sql,[$val["description"],$this->session->userdata('userId'),$val["id"]]);
			}else{
				// insert
				$data=array(
					'service_id'=>$service_id,
					'product_id'=>$val['product_id'],
					'additional_details'=>$val['description'],
					'created_by'=>$this->session->userdata('userId')
				);
				$this->db->insert('service_product', $data);
			}
		}
	}

	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update service_master set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}
	
	public function getAllTrash(){
		$sql="select a.id,a.deleted_at,b.user_name,b.user_role from service_master a, users b where a.deleted_by=b.id and a.deleted=1 order by a.deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}	

	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update service_master set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}
}