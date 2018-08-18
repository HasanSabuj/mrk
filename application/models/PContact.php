<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class PContact extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// insert contact data
	public function create($data){
		$this->db->insert('principle_contacts',$data);
		return $this->db->insert_id();
	}

	// getAllByPrinciple
	public function getAllByPrinciple($principle_id){
		$sql="select id,principle_id,name,designation,job_field,email,phone,visiting_card from principle_contacts where principle_id=? and deleted<>1 order by id desc";
		$result=$this->db->query($sql,[$principle_id]);
		return $result->result();
	}

	// update contact data
	public function update($data){

		if($data["visiting_card"]){
			$sql="update principle_contacts set visiting_card=? where id=? ";
			$this->db->query($sql,[$data["visiting_card"],$data['id']]);
		}

		$sql="update principle_contacts set name=?,job_field=?,designation=?,phone=?,email=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data['name'],$data['job_field'],$data['designation'],$data['phone'],$data['email'],$data['updated_by'],$data['id']]);

	}

	// getAllTrashByPrinciple
	public function getAllTrashByPrinciple($priciple_id){
		$sql="select a.id,a.name,a.deleted_at,b.user_name,b.user_role from principle_contacts a, users b where a.deleted_by=b.id and a.deleted=1 order by deleted_at desc";
		$result=$this->db->query($sql,[$priciple_id]);
		return $result->result();
	}

	// delete
	public function delete($id){
		$sql="update principle_contacts set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$this->session->userdata('userId'),$id]);
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update principle_contacts set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$updated_by,$id]);
	}

	public function get_all_contacts(){
		$sql="select id,principle_id,name,designation,job_field,phone,email from principle_contacts where deleted=0";
		return $this->db->query($sql)->result_array();
	}
}