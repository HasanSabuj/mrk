<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MProducts extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}


	// get product list for dropdown
	public function productListDropdown(){
		$sql="select id,name from products where deleted<>? order by name";
		$result=$this->db->query($sql,[1]);
		return $result->result();
	}

	// insert new product
	public function create($data){
		$this->db->insert('products',$data);
		return $this->db->insert_id();
	}

	// get all products for product list data grid
	public function getAllProducts(){
		$sql="select a.id,a.name,a.requirement_form_id, (select name from form_name where id=a.requirement_form_id) as form_name,b.user_name from products a, users b where a.deleted<>1 and b.id=a.created_by order by a.id desc";
		$result=$this->db->query($sql);
		return $result->result();
	}

	public function getInfoById($id){
		$sql="select id,name,requirement_form_id from products where id=?";
		$result=$this->db->query($sql,[$id]);
		return $result->row();
	}

	// info update
	public function update($data,$id){
		$data = array(
			'name' => $data["name"],
			'requirement_form_id' => $data['requirement_form_id'],
			'updated_by' => $data['updated_by'],
			'updated_at' => date('Y-m-d H:i:s', time())
			);

		$this->db->where('id', $id);
		$this->db->update('products', $data);
	}

	// soft delete
	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update products set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}

	// getAllTrash list
	public function getAllTrash(){
		$sql="select a.*,b.user_name,b.user_role from products a, users b where a.deleted_by=b.id and a.deleted=1 order by deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update products set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	public function get_product($name){
		$sqlString="";
		if($name){
			$data=explode(" ", $name);
			foreach($data as $k=>$val){
				$sqlString.=" and name like '%".$val."%'";
			}
		}

		if($sqlString){
			$sqlString=substr($sqlString,5);
			$sql="select id,name,requirement_form_id from products where (".$sqlString.") and deleted<>1 order by name asc limit 20";
			$result=$this->db->query($sql);
			return $result->result();
		}else{
			$sql="select id,name,requirement_form_id from products where deleted<>1 order by name asc limit 20";
			$result=$this->db->query($sql);
			return $result->result();
			
		}
	}

	// get products for principle list
	public function get_product_for_principle(){
		$sql="select id,name from products where deleted=0";
		return $this->db->query($sql)->result_array();
	}
}