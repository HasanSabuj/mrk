<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MPrinciples extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// insert customer data
	public function create($data){
		$this->db->insert('principles',$data);
	}

	// getPrinciplelist
	public function getPrinciplelist(){
		$sql="select a.id,a.name,a.products,a.email,a.phone, b.user_name from principles a, users b where a.deleted<>1 and b.id=a.created_by order by a.id desc";
		$result=$this->db->query($sql);
		return $result->result();
	}

	// getInfoById
	public function getInfoById($id){
		$sql="select * from principles where id=?";
		$result=$this->db->query($sql,[$id]);
		return $result->row();
	}

	// update principle data
	public function update($data,$id){
		$this->db->where('id', $id);
		$this->db->update('principles', $data);
	}

	// principle
	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update principles set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}

	// getAllTrash list
	public function getAllTrash(){
		$sql="select a.*,b.user_name,b.user_role from principles a, users b where a.deleted_by=b.id and a.deleted=1 order by deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update principles set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	// delete image
	public function delete_image($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update principles set visiting_card=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,['',$updated_by,$id]);
	}

	// get principle by search
	public function get_principle($hint){
		$sqlString="";
		if($hint){
			$data=explode(" ", $hint);
			foreach($data as $k=>$val){
				$sqlString.=" and name like '%".$val."%'";
			}
		}
		
		if($sqlString){
			$sqlString=substr($sqlString,5);
			$sql="select id,name from principles where (".$sqlString.") and deleted=0 order by name asc limit 20";
			$result=$this->db->query($sql);
			return $result->result();
		}else{
			$sql="select id,name from principles where deleted=0 order by name asc limit 20";
			$result=$this->db->query($sql);
			return $result->result();
			
		}
	}
}