<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class MWork_plan extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_data_by_user_id($user,$date){
		$exists=$this->data_check($user,$date);

		if($exists){
			$details=$this->get_details_data($exists);
		}else{
			$sql="insert into monthly_work_plan (user_id,month_date) values (?,?)";
			$this->db->query($sql,[$user,$date]);
			$id=$this->db->insert_id();
			$details=$this->set_details_data($id,$date);
		}

		return $details;
	}

	public function data_check($user,$date){
		$sql="select id from monthly_work_plan where user_id=? and month_date=?";
		$result=$this->db->query($sql,[$user,$date]);
		if($result->num_rows()>0){
			$data=$result->result();
			return $data[0]->id;
		}else{
			return 0;
		}
		

	}

	public function get_details_data($id){
		$query="select * from work_plan_details where monthly_work_plan_id=?";
		$result=$this->db->query($query,[$id]);
		return $result->result();
	}

	public function insert_details(){

	}

	// set first time data
	public function set_details_data($id,$date){
		$month=date("m",strtotime($date));
		$year=date("Y",strtotime($date));
		$d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		for($i=1;$i<=$d;$i++){
			if($i<=9){
				$j="0".$i;
			}else{
				$j=$i;
			}
			$sql="insert into work_plan_details (monthly_work_plan_id,work_date) values (?,?)";
			$new_date=$year.'-'.$month.'-'.$j;
			$this->db->query($sql,[$id,$new_date]);
		}

		$query="select * from work_plan_details where monthly_work_plan_id=?";
		$result=$this->db->query($query,[$id]);
		return $result->result();
	}

	// work plan event setup insert 
	public function work_plan_details_setup_insert($data){
		$this->db->insert('work_plan_details_setup',$data);
		return $this->db->insert_id();
	}

	public function plan_detail_by_plan_details_id($id){
		$sql="select a.id,
		a.customer_id,
		(select name from customers where id=a.customer_id) as customer_name,
		(select name from principles where id=a.principle_id) as principle_name,
		a.estimated_event,
		a.status,
		a.remark 
		from work_plan_details_setup a where a.working_day_id=? order by id asc";
		$result=$this->db->query($sql,[$id]);
		return $result->result();
	}

	public function remove_event_plan($id){
		$sql="select working_day_id from work_plan_details_setup where id=?";
		$data=$this->db->query($sql,[$id]);

		$sql="delete from work_plan_details_setup where id=?";
		$this->db->query($sql,[$id]);

		return $data->row();
	}

	// get daily work plan by user id
	public function daily_plan($user){
		$return_value_array=array();

		$current_year=date("Y");
		$current_month=date("m");
		$current_date=date("Y-m-d");
		$current_month_first_day=date("Y-m-01");

		$sql="
			select 
				a.*,
				(select name from customers where id=a.customer_id) as customer_name,
				(select name from principles where id=a.principle_id) as principle_name
			from 
			work_plan_details_setup a,
			work_plan_details b,
			monthly_work_plan c

			where c.user_id=?
			and YEAR(c.month_date)=?
			and MONTH(c.month_date)=?
			and b.work_date=?
			and b.monthly_work_plan_id=c.id
			and a.working_day_id=b.id
		";

		$result = $this->db->query($sql,[$user,$current_year,$current_month,$current_date]);
		if($result->num_rows()>0){
			$return_value_array[0]=$result->result();
			$return_value_array[1]=0;
		}else{
			// check monthly_work_plan 
			$sql1="select id from monthly_work_plan where user_id=? and month_date=?";
			$result1=$this->db->query($sql1,[$user,$current_month_first_day]);
			if($result1->num_rows()>0){

				$data1=$result1->row();
				//print_r($data1);

				$monthly_work_plan_id=$data1->id;

				$sql2="select id from work_plan_details where monthly_work_plan_id=? and work_date=?";
				$result2=$this->db->query($sql2,[$monthly_work_plan_id,$current_date]);
				if($result2->num_rows()>0){
					$data2=$result2->row();
					$return_value_array[0]=array();
					$return_value_array[1]=$data2->id;
				}
			}else{
				// new insert
				$sql3="insert into monthly_work_plan (user_id,month_date) values (?,?)";
				$this->db->query($sql3,[$user,$current_month_first_day]);
				$id=$this->db->insert_id();
				$this->set_details_data($id,$current_month_first_day);
				$sql4="select id from work_plan_details where monthly_work_plan_id=? and work_date=?";
				$result4=$this->db->query($sql4,[$id,$current_date]);
				if($result4->num_rows()>0){
					$data4=$result4->row();
					$return_value_array[0]=array();
					$return_value_array[1]=$data4->id;
				}
			}

			//return array();
		}

		return $return_value_array;
	}

	// update_work_plan_status
	public function update_work_plan_status($id,$status){
		$sql="update work_plan_details_setup set status=?,update_time=now() where id=?";
		$this->db->query($sql,[$status,$id]);
	}

	public function update_work_plan_details($id,$remark){
		echo $remark;
		$sql="update work_plan_details_setup set remark=?, update_time=now() where id=?";
		$this->db->query($sql,[$remark,$id]);
	}

	// daily update report 
	public function daily_update_report($date_value=NULL){
		if(!$date_value){
			$date_value=date('Y-m-d',strtotime("-1 days"));
		}
		
		$current_year=date("Y",strtotime($date_value));
		$current_month=date("m",strtotime($date_value));
		$current_date=$date_value;
		$role=$this->session->userdata('userRole');
		if($role==3){
			$user=$this->session->userdata('userId');
			$sql="
				select 
					a.*,
					(select name from customers where id=a.customer_id) as customer_name,
					(select name from principles where id=a.principle_id) as principle_name,
					d.user_name,
					d.profile_pic,
					d.id as user_id
				from 
				work_plan_details_setup a,
				work_plan_details b,
				monthly_work_plan c,
				users d
				where d.id=c.user_id
				and c.user_id={$user}
				and YEAR(c.month_date)=?
				and MONTH(c.month_date)=?
				and b.work_date=?
				and b.monthly_work_plan_id=c.id
				and a.working_day_id=b.id order by d.id
			";
		}elseif($role==2){
			$sql="
				select 
					a.*,
					(select name from customers where id=a.customer_id) as customer_name,
					(select name from principles where id=a.principle_id) as principle_name,
					d.user_name,
					d.profile_pic,
					d.id as user_id
				from 
				work_plan_details_setup a,
				work_plan_details b,
				monthly_work_plan c,
				users d
				where d.id=c.user_id
				and d.user_role<>1
				and YEAR(c.month_date)=?
				and MONTH(c.month_date)=?
				and b.work_date=?
				and b.monthly_work_plan_id=c.id
				and a.working_day_id=b.id order by d.id
			";
		}else{
			$sql="
				select 
					a.*,
					(select name from customers where id=a.customer_id) as customer_name,
					(select name from principles where id=a.principle_id) as principle_name,
					d.user_name,
					d.profile_pic,
					d.id as user_id
				from 
				work_plan_details_setup a,
				work_plan_details b,
				monthly_work_plan c,
				users d
				where d.id=c.user_id
				and YEAR(c.month_date)=?
				and MONTH(c.month_date)=?
				and b.work_date=?
				and b.monthly_work_plan_id=c.id
				and a.working_day_id=b.id order by d.id
			";
		}
		return $this->db->query($sql,[$current_year,$current_month,$current_date])->result_array();
	}

	// for update report

	public function daily_update_report_data($fdate,$tdate){
		$sql="SELECT a.*,
				b.working_day_id,
				b.customer_id,
				(select name from customers where id=b.customer_id) as customer_name,
				(select name from principles where id=b.principle_id) as principle_name,
				b.estimated_event,
				b.status as update_status,
				b.remark,
				b.update_time,
				d.id as user_id,
				d.user_name,
				d.profile_pic
				FROM work_plan_details a,
				work_plan_details_setup b,
				monthly_work_plan c,
				users d
				WHERE b.working_day_id=a.id
				and c.id=a.monthly_work_plan_id
				and d.id=c.user_id";
		if($this->input->post('user',TRUE)){
			$user=$this->input->post('user',TRUE);
			$sql.=" and c.user_id=".$user."";
		}		

		$sql.="	and a.work_date BETWEEN ? and ?
				order by a.work_date";

		return $this->db->query($sql,[$fdate,$tdate])->result_array();		
	}


	// daily update report comment
	public function u_report_comment(){
		$id=$this->input->post('id',true);
		$value=$this->input->post('value',true);
		$sql="update work_plan_details_setup set s_comments=? where id=?";
		$this->db->query($sql,[$value,$id]);
	}
}