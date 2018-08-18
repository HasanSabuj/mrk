<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MUpcoming_tender extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function tlist(){
		$sql="select * from upc_tender";
		return $this->db->query($sql)->result();
	}

	public function save($data){
		$this->db->insert('upc_tender',$data);
		return $this->db->insert_id();
	}

	public function get_by_id($id){
		$sql="select * from upc_tender where id=?";
		return $this->db->query($sql,[$id])->row();
	}

	public function update($data){
		$sql="update upc_tender set customer=?,product=?,submission_date=?,ernest_money=?,opening_date=?,priority=? where id=?";
		$this->db->query($sql,[$data["customer"],$data["product"],$data["submission_date"],$data["ernest_money"],$data["opening_date"],$data["priority"],$data["id"]]);
	}

	public function remove($id){
		$sql="delete from upc_tender where id=?";
		$this->db->query($sql,[$id]);
		return true;
	}

	public function update_pic($pic,$id){
		$sql="update upc_tender set attachments=? where id=?";
		$this->db->query($sql,[$pic,$id]);
	}
}