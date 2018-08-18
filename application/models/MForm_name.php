<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MForm_name extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function create_main($data){
		$this->db->insert('form_name',$data);
		return $this->db->insert_id();
	}

	public function insert_form_details($id,$label,$required){
		$sql=array();
		foreach ($label as $key => $value) {
			$sql[]=['form_id'=>$id,'input_label'=>$value,'required'=>$required[$key]];
		}

		$this->db->insert_batch('form_element',$sql);
	}

	public function get_all_forms(){
		$sql="select * from form_name";
		$result=$this->db->query($sql);
		return $result->result();
	}

	public function form_elements_by_id($id){
		$sql="select * from form_element where form_id=? order by id asc";
		$result = $this->db->query($sql,[$id]);
		return $result->result();
	}

	// delete
	public function delete($id){
		// check exists first
		$sql="select count(id) as row from products where requirement_form_id=?";
		$result=$this->db->query($sql,[$id])->row();
		if($result->row>0){
			return 0;
		}else{
			$sql="delete from form_name where id=?";
			$this->db->query($sql,[$id]);
			return 1;
		}
	}
}