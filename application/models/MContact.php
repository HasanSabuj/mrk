<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MContact extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	// insert contact data
	public function create($data){
		$this->db->insert('contacts',$data);
		return $this->db->insert_id();
	}
	public function update_pic($pic,$id){
		$sql="update contacts set vcard=? where id=?";
		$this->db->query($sql,[$pic,$id]);
	}
	// getAllByCustomer
	public function getAllByCustomer($customer_id){
		$sql="select id,name,department,designation,email,phone,vcard from contacts where customer_id=? and deleted<>1 order by id desc";
		$result=$this->db->query($sql,[$customer_id]);
		return $result->result();
	}

	// update contact data
	public function update($data){
		$sql="update contacts set name=?,department=?,designation=?,phone=?,email=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data['name'],$data['department'],$data['designation'],$data['phone'],$data['email'],$data['updated_by'],$data['id']]);

	}

	// delete
	public function delete($id){
		$sql="update contacts set deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[1,$this->session->userdata('userId'),$id]);
	}

	// get all trash by customer id
	public function getAllTrashByCustomer($customer_id){
		
		$sql="select a.*,b.user_name,b.user_role from contacts a, users b where a.deleted_by=b.id and a.customer_id=? and a.deleted=? order by a.id desc";
		$result=$this->db->query($sql,[$customer_id,1]);
		return $result->result();
	}

	// move
	public function move($id){
		$sql="update contacts set deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[0,$this->session->userdata('userId'),$id]);
	}

	// get all contacts
	public function get_all_contacts(){
		$sql="select id,name,department,designation,email,phone,customer_id from contacts where deleted=0";
		return $this->db->query($sql)->result_array();
	}
}