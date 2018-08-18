<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MJob_event extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MJobs');
	}


	public function insert(){

		$job=$this->input->post('job',TRUE);

		$data["job_id"]=$this->input->post("job",TRUE);
		$data["contact_id"]=$this->input->post("contact_id",TRUE);
		$data["event_title"]=$this->input->post("event_title",TRUE);
		$data["event_details"]=$this->input->post("event_details",TRUE);
		$data["note_date"]=$this->input->post("note_date",TRUE);
		$data["next_date"]=$this->input->post("next_date",TRUE);
		$data["created_by"]=$this->session->userdata('userId');

		$this->db->insert('job_event_register',$data);
		$id=$this->db->insert_id();


		if(!empty($_FILES['attachment']['name'][0])){

			$config = array();
		    $config['upload_path'] = './public/uploads/job/event_attachments';
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

	        $sql="update job_event_register set attachment=? where id=?";
	        $this->db->query($sql,[json_encode($attachment),$id]);
    	}


    	// get all job handler
		$sql="select a.co_handler,a.ma_handler,a.de_handler,
		(select user_email from users where id=a.co_handler) as co_email,
		(select user_role from users where id=a.co_handler) as co_role, 
		(select user_email from users where id=a.ma_handler) as ma_email, 
		(select user_role from users where id=a.ma_handler) as ma_role, 
		(select user_email from users where id=a.de_handler) as de_email, 
		(select user_role from users where id=a.de_handler) as de_role 
		from job_master a where a.id=?";

		$eresult=$this->db->query($sql,[$job])->row();

		$jobdata=$this->MJobs->getInfoById($job)[0];

		$msg["subject"]='Event update notification about JOB: '.($jobdata->type==1?'T':$jobdata->type==2?'CM':'MHD').'-'.$job;
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
			<tr>
				<td><b>Event Created By:</b></td>
				<td>'.$this->session->userdata('userName').'</td>
			</tr>
		</table>';

		if(!empty($eresult->co_handler) and $eresult->co_handler!=$this->session->userdata('userId')){
			$msg["receipient"]=$eresult->co_email;
			$this->db->insert('email_queue',$msg);
		}

		if(!empty($eresult->ma_handler) and $eresult->ma_handler!=$this->session->userdata('userId')){
			$msg["receipient"]=$eresult->ma_email;
			$this->db->insert('email_queue',$msg);
		}

		if(!empty($eresult->de_handler) and $eresult->de_handler!=$this->session->userdata('userId')){
			$msg["receipient"]=$eresult->de_email;
			$this->db->insert('email_queue',$msg);
		}

		//return $jobdata->type;
	}

	public function get_data_by_id($id){
		$sql="select 
			a.*,
			(select name from contacts where id=a.contact_id) as contact_name,
			b.user_name
			from job_event_register a,
			users b
			where a.id=?
			and b.id=a.created_by
		";
		return $this->db->query($sql,[$id])->row();
	}

	// get all events by job id

	public function get_all_event_by_job_id($job){

		$userRole=$this->session->userdata('userRole');
		if($userRole!=3){
			$sql="select 
				a.*,
				(select name from contacts where id=a.contact_id) as contact_name,
				b.user_name
				from job_event_register a,
				users b
				where a.job_id=?
				and b.id=a.created_by order by a.id desc
			";
		}else{
			$user=$this->session->userdata('userId');
			$sql="select 
				a.*,
				(select name from contacts where id=a.contact_id) as contact_name,
				b.user_name
				from job_event_register a,
				users b
				where a.job_id=?
				and b.id=a.created_by and a.created_by={$user} order by a.id desc
			";
		}
		return $this->db->query($sql,[$job])->result();
	}
}