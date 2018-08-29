<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model {


/*Read the data from DB */
	Public function getEvents()
	{
		$role=$this->session->userdata('userRole');
		if($role==1){
			$sql = "SELECT events.id,events.title,CONCAT(events.description,', by - ',users.user_name) as description,events.e_time,events.color,events.start,events.end,events.allDay,users.user_name FROM events,users WHERE events.start BETWEEN ? AND ?  AND users.id=events.created_by ORDER BY events.start ASC";
			return $this->db->query($sql, array($_GET['start'], $_GET['end']))->result();
		}else{
			
			$sql = "SELECT events.*,users.user_name FROM events,users WHERE events.start BETWEEN ? AND ? AND events.created_by=? AND users.id=events.created_by ORDER BY events.start ASC";
			return $this->db->query($sql, array($_GET['start'], $_GET['end'],$this->session->userdata('userId')))->result();
		}

	}

/*Create new events */

	Public function addEvent()
	{

	$sql = "INSERT INTO events (title,events.start,events.end,description,e_time,color,created_by) VALUES (?,?,?,?,?,?,?)";
	$this->db->query($sql, array($_POST['title'], $_POST['start'],$_POST['end'], $_POST['description'],$_POST['e_time'], $_POST['color'],$this->session->userdata('userId')));
		return ($this->db->affected_rows()!=1)?false:true;
	}

	/*Update  event */

	Public function updateEvent()
	{

	$sql = "UPDATE events SET title = ?, description = ?, e_time=?,color = ? WHERE id = ?";
	$this->db->query($sql, array($_POST['title'],$_POST['description'],$_POST['e_time'],  $_POST['color'], $_POST['id']));
		return ($this->db->affected_rows()!=1)?false:true;
	}


	/*Delete event */

	Public function deleteEvent()
	{

	$sql = "DELETE FROM events WHERE id = ?";
	$this->db->query($sql, array($_GET['id']));
		return ($this->db->affected_rows()!=1)?false:true;
	}

	/*Update  event */

	Public function dragUpdateEvent()
	{
			//$date=date('Y-m-d h:i:s',strtotime($_POST['date']));

			$sql = "UPDATE events SET  events.start = ? ,events.end = ?  WHERE id = ?";
			$this->db->query($sql, array($_POST['start'],$_POST['end'], $_POST['id']));
		return ($this->db->affected_rows()!=1)?false:true;


	}






}