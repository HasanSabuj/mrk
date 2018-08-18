<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Muser extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}


	// get user data by email
	public function get_user_data($email){
		$sql="select * from users where user_email=? and status=?";
		$result=$this->db->query($sql,[$email,1]);
		return $result->row();
	}

	// update user profile
	public function profile_update($id,$name,$profile_pic,$phone,$pre_add,$per_add){
		
		$sql="update users set user_name=?,phone=?,pre_add=?,per_add=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$name,$phone,$pre_add,$per_add,$id,$id]);

		if($profile_pic){
			$this->update_pic($profile_pic,$id);
			$this->session->set_userdata('userPic', $profile_pic);
		}

		if($this->input->post('password')){

			$pass=password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$sql="update users set password=? where id=?";
			$this->db->query($sql,[$pass,$id]);
		}
		if($this->input->post('pw_2')){
			$pass=$this->input->post('pw_2',TRUE);
			$sql="update users set pw_2=? where id=?";
			$this->db->query($sql,[$pass,$id]);
		}
	}

	// get user data by id
	public function getInfoById($id){
		$sql="select * from users where id=?";
		$result=$this->db->query($sql,[$id]);
		return $result->row();
	}

	// profile pic update
	public function update_pic($pic,$id){
		$sql="update users set profile_pic=? where id=?";
		$this->db->query($sql,[$pic,$id]);	
	}

	// create new user
	public function create($data){
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

	// user list
	public function getAllUsers(){
		$sql="select a.id,a.user_name,a.user_email,a.phone,a.department,a.designation,a.profile_pic,a.user_role,a.status,b.name as dep_name,c.name as des_name 
		 from users a,department b,designation c where b.id=a.department and c.id=a.designation and a.deleted<>1 order by a.id desc";
		$result=$this->db->query($sql);
		return $result->result();
	}

	// user info update
	public function update($data){
		$sql="update users set user_name=?,phone=?,pre_add=?,per_add=?,department=?,designation=?,user_role=?,status=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[$data["user_name"],$data["phone"],$data["pre_add"],$data["per_add"],$data["department"],$data["designation"],$data["user_role"],$data["status"],$data["updated_by"],$data["id"]]);

		if($this->input->post('password')){

			$pass=password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$sql="update users set password=? where id=?";
			$this->db->query($sql,[$pass,$data["id"]]);
		}
	}

	public function delete($id){
		$deleted_by=$this->session->userdata('userId');
		$sql="update users set status=?, deleted=?,deleted_by=?,deleted_at=now() where id=?";
		$this->db->query($sql,[2,1,$deleted_by,$id]);
	}

	// get all trashed user
	public function getAllTrash(){
		$sql="select a.id,a.user_name,a.deleted_at,b.user_name as duser_name,b.user_role from users a, users b where a.deleted_by=b.id and a.deleted=1 order by deleted_at desc";
		$result=$this->db->query($sql);

		return $result->result();
	}

	// move 
	public function move($id){
		$updated_by=$this->session->userdata('userId');
		$sql="update users set status=?, deleted=?,updated_by=?,updated_at=now() where id=?";
		$this->db->query($sql,[1,0,$updated_by,$id]);
	} 


	public function privilege($user){
		$sql="insert into user_privileges (user_id) values (?)";
		$this->db->query($sql,[$user]);
	}
	// get user for list option
	public function get_user_for_list(){
		$sql="select a.id,a.user_name,a.department,a.designation,b.name as dep_name,c.name as des_name 
		 from users a,department b,designation c where b.id=a.department and c.id=a.designation and a.deleted<>1 order by a.user_name";
		 return $this->db->query($sql)->result_array();
	}

	public function check_valid_user_by_email($email){
		$sql="select id from users where user_email=? and deleted=0 and status=1";
		return $this->db->query($sql,[$email])->row();
	}

	// reset password
	public function reset_password($pass,$id){
		
		$sql="update users set password=? where id=?";
		$this->db->query($sql,[$pass,$id]);
	}

	public function store_email($msg){
		$this->db->insert('email_queue',$msg);
		return true;
	}
}