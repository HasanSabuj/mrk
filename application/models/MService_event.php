<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MService_event extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function insert(){

		$service=$this->input->post('service',TRUE);

		$data["service_id"]=$this->input->post("service",TRUE);
		$data["contact_id"]=$this->input->post("contact_id",TRUE);
		$data["event_title"]=$this->input->post("event_title",TRUE);
		$data["event_details"]=$this->input->post("event_details",TRUE);
		$data["note_date"]=$this->input->post("note_date",TRUE);
		$data["next_date"]=$this->input->post("next_date",TRUE);
		$data["created_by"]=$this->session->userdata('userId');

		$this->db->insert('service_event_register',$data);
		$id=$this->db->insert_id();



		if(!empty($_FILES['attachment']['name'][0])){

			$config = array();
		    $config['upload_path'] = './public/uploads/service/event_attachments';
		    $config['allowed_types'] = '*';
		    $config['max_size'] = '0'; // 0 = no file size limit
		    $config['max_width']  = '0';
		    $config['max_height']  = '0';
		    $config['overwrite'] = TRUE;


    		$this->load->library('upload');
	        $files = $_FILES;
	        $cpt = count($_FILES['attachment']['name']);
	        $attachment=array();
	        for($i=0; $i<$cpt; $i++)
	        {   

	                $_FILES['attachment']['name']= $id.'_'.time().'_'.$files['attachment']['name'][$i];
	                $_FILES['attachment']['type']= $files['attachment']['type'][$i];
	                $_FILES['attachment']['tmp_name']= $files['attachment']['tmp_name'][$i];
	                $_FILES['attachment']['error']= $files['attachment']['error'][$i];
	                $_FILES['attachment']['size']= $files['attachment']['size'][$i]; 


	                $this->upload->initialize($config);
	                if ( ! $this->upload->do_upload('attachment'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        //die();
                    }
	                $filedata = $this->upload->data();
                    $attachment[]=$filedata['file_name'];

	        }

	        $sql="update service_event_register set attachment=? where id=?";
	        $this->db->query($sql,[json_encode($attachment),$id]);
    	}


    	// get all service handler
		$sql="select a.handler,a.created_by,
		(select user_email from users where id=a.handler) as email,
		(select user_email from users where id=a.created_by) as c_email
		from service_master a where a.id=?";
		$eresult=$this->db->query($sql,[$service])->row();


		$msg["subject"]='Event update notification about SR-'.$service;
		$msg["message"]='<table>
			<tr>
				<td><b>Event Title:</b></td>
				<td>'.$this->input->post("event_title",TRUE).'</td>
			</tr>
			<tr>
				<td><b>Event Details:</b></td>
				<td>'.$this->input->post("event_details",TRUE).'</td>
			</tr>
			<tr>
				<td><b>Event Date:</b></td>
				<td>'.$this->input->post("note_date",TRUE).'</td>
			</tr>
			<tr>
				<td><b>Next Event Date:</b></td>
				<td>'.$this->input->post("next_date",TRUE).'</td>
			</tr>
		</table>';

		if(!empty($eresult->handler) and $eresult->handler!=$this->session->userdata('userId')){
			$msg["receipient"]=$eresult->email;
			$this->db->insert('email_queue',$msg);
		}

		if(!empty($eresult->created_by) and $eresult->created_by!=$this->session->userdata('userId')){
			$msg["receipient"]=$eresult->c_email;
			$this->db->insert('email_queue',$msg);
		}


		return $this->get_data_by_id($id);
	}

	public function get_data_by_id($id){
		$sql="select 
			a.*,
			(select name from contacts where id=a.contact_id) as contact_name,
			b.user_name
			from service_event_register a,
			users b
			where a.id=?
			and b.id=a.created_by
		";
		return $this->db->query($sql,[$id])->row();
	}

	// get all events by service id

	public function get_all_event_by_service_id($service){
		$sql="select 
			a.*,
			(select name from contacts where id=a.contact_id) as contact_name,
			b.user_name
			from service_event_register a,
			users b
			where a.service_id=?
			and b.id=a.created_by order by a.id desc
		";
		return $this->db->query($sql,[$service])->result();
	}
}