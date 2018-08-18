<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MEmail_queue extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_data(){
		$sql="select * from email_queue where status=0 limit 10";
		return $this->db->query($sql)->result();
	}

	public function mark_as_send($id){
		$sql="update email_queue set status=?,send_time=now() where id=?";
		$this->db->query($sql,[1,$id]);
	}
}