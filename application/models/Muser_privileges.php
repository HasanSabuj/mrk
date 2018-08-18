<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Muser_privileges extends CI_Model
{
	private $table;
	
	public function __construct()
	{
		parent::__construct();

		$this->table='user_privileges';
	}


	public function get_data_by_user_id($id){
		$this->db->where('user_id', $id);
        $this->db->limit(1);
        $result = $this->db->get($this->table)->row();
		return $result;
	}

	public function update($data){
		$this->db->replace($this->table, $data);
	}

	public function user_info($id){
		$sql="select user_name from users where id=?";
		return $this->db->query($sql,[$id])->row();
	}

}