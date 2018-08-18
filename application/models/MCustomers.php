<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MCustomers extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// insert customer data
	public function create($data){
		$this->db->insert('customers',$data);
		return $this->db->insert_id();
	}

	// get all customer list as per creator
	public function getCustomerListByCreator($creator){
		$sql="select a.id,a.name,a.cust_type,a.cust_cat,b.name as customer_type_name, c.user_name
		 from customers a, customer_type b, users c where a.created_by=? and b.id=a.cust_type and a.deleted<>1 and c.id=a.created_by order by a.id desc";
		$result=$this->db->query($sql,[$creator]);
		return $result->result();
	}

	// get all customer list 
	public function getAllCustomers(){
		$sql="select a.id,a.name,a.cust_type,a.cust_cat,b.name as customer_type_name, c.user_name 
		from customers a, customer_type b, users c where b.id=a.cust_type and a.deleted<>1 and c.id=a.created_by order by a.id desc";
		$result=$this->db->query($sql);
		return $result->result();
	}

	// update customer pic info
	public function update_pic($pic,$id){
		$sql="update customers set attachments=? where id=?";
		$this->db->query($sql,[$pic,$id]);
	}

	// getInfoById
	public function getInfoById($id){
		$sql="select * from customers where id=?";
		$result=$this->db->query($sql,[$id]);
		return $result->row();
	}

	// update
	public function update($data,$id){
		$data = array(
			'name' => $data["name"],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'website' => $data['website'],
			'address' => $data['address'],
			'address_fac' => $data['address_fac'],
			'cust_type' => $data['cust_type'],
			'cust_cat' => $data['cust_cat'],
			'lat' => $data['lat'],
			'lon' => $data['lon'],
			'updated_by' => $data['updated_by'],
			'updated_at' => date('Y-m-d H:i:s', time())
			);

		$this->db->where('id', $id);
		$this->db->update('customers', $data);
	}

	// soft delete
	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update customers set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}

	// getAllTrash list
	public function getAllTrash(){
		$sql="select a.id,a.name,a.cust_cat,b.user_name,a.deleted_at,b.user_role,c.name as type from customers a, users b, customer_type c where a.deleted_by=b.id and a.deleted=1 and c.id=a.cust_type order by a.deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update customers set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	// get customer by search
	public function get_customer($user_role,$customer_hint){
		$sqlString="";
		if($customer_hint){
			$data=explode(" ", $customer_hint);
			foreach($data as $k=>$val){
				$sqlString.=" and name like '%".$val."%'";
			}
		}
		if($user_role==3 and !$this->input->post('service',true)){
			$user=$this->session->userdata('userId');
			if($sqlString){
				$sqlString=substr($sqlString,5);
				$sql="select id,name from customers where created_by=".$user." and (".$sqlString.") and deleted=0 order by name asc limit 20";
				$result=$this->db->query($sql);
				return $result->result();
			}else{
				$sql="select id,name from customers where created_by=".$user." and deleted=0 order by name asc limit 20";
				$result=$this->db->query($sql);
				return $result->result();
				
			}
		}else{
			if($sqlString){
				$sqlString=substr($sqlString,5);
				$sql="select id,name from customers where (".$sqlString.") and deleted=0 order by name asc limit 20";
				$result=$this->db->query($sql);
				return $result->result();
			}else{
				$sql="select id,name from customers where deleted=0 order by name asc limit 20";
				$result=$this->db->query($sql);
				return $result->result();
				
			}
		}
	}
}