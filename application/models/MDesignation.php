<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MDesignation extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// insert designation data
	public function create($data){
		$this->db->insert('designation',$data);
	}


	// get all designation list for data grid
	public function getAllDesignations(){
		$sql="select id,name from designation where 1=1 and deleted<>1 order by id desc";
		$result=$this->db->query($sql);
		return $result->result();
	}

	// getDataById
	public function getDataById($id){
		$sql="select id,name from designation where id=? and deleted<>1";
		$result=$this->db->query($sql,[$id]);

		return $result->row();
	}

	// update designation
	public function update($data,$id){
		$sql="update designation set name=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data['name'],$data['updated_by'],$id]);
	}

	// soft delete
	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update designation set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$deleted_by,$id]);
	}

	// getAllTrash list
	public function getAllTrash(){
		$sql="select a.id,a.name,a.deleted_at,b.user_name,b.user_role from designation a, users b where a.deleted_by=b.id and a.deleted=1 order by deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update designation set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	// get data for select list
	public function getSelectList(){
		$sql="select id,name from designation where deleted<>1 order by name";
		$result=$this->db->query($sql);
		return $result->result();
	}
}