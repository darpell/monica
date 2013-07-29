<?php 
class Suggest_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	// returns the all larval points
	function get_points($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		//$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
			$this->db->from('ls_report_main');
			$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
			if ($place != NULL && $place != 'NULL')
			{
				$this->db->where($this->check_place($place),$value);
			}
			
		if ($begin_date === FALSE && $end_date === FALSE)
		{
			$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
		}
		// http://stackoverflow.com/questions/4875668/codeigniter-getting-data-posted-in-between-two-dates
		// http://stackoverflow.com/questions/7215834/how-to-write-this-query-with-codeigniter
		$this->db->where("created_on BETWEEN '$begin_date' AND '$end_date'");
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
	}
	
	function get_user_brgy($user)
	{	
		$this->db->select('users.user_username, bhw.barangay');
		$this->db->from('users');
		$this->db->join('bhw','users.user_username = bhw.user_username');
		$this->db->where('users.user_username',$user);
		
			$query = $this->db->get();
			if ($query->num_rows() > 0)
				{
					$row = $query->row_array();
					return $row['barangay'];
				}
				return NULL;
		/*
		return $this->db->query(
								'SELECT users.user_username, bhw.barangay
								FROM users JOIN bhw ON users.user_username = bhw.user_username
								WHERE users.user_username = ' . $user
									);
		*/
	}
	
	function get_cases($brgy, $begin_date = FALSE, $end_date = FALSE)
	{
		/*
		$this->db->select('cr_first_name, 
							cr_last_name, 
							cr_sex, cr_age,
							cr_date_admitted,
							cr_date_onset,
							cr_street,
							cr_barangay,
							cr_city, 
							cr_province
						');
		$this->db->from('case_report_main');
		$this->db->where('cr_barangay',$brgy);
		
		if ($begin_date === FALSE && $end_date === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
		}
		
		$this->db->where("cr_date_onset BETWEEN '$begin_date' AND '$end_date'");
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
		*/
		/*if ($begin_date === FALSE && $end_date === FALSE)
		{
			return $this->db->query(
					"SELECT cr_first_name, cr_last_name, cr_sex, cr_age, cr_date_admitted, cr_date_onset, cr_street, cr_barangay, cr_city, cr_province
					FROM case_report_main
					WHERE cr_barangay = '" . $brgy . "'"
			);
		}*/
		
		$query = $this->db->query("SELECT cr.cr_first_name, cr.cr_last_name, cr.cr_sex, cr.cr_age, cr.cr_street, cr.cr_barangay
									FROM case_report_main cr
									WHERE cr.cr_barangay = '" . $brgy . "' AND 
									cr_date_onset BETWEEN '" . $begin_date . "' AND '" . $end_date . "'
									AND
										cr.cr_patient_no NOT IN
											(SELECT ic.case_no
											FROM investigated_cases ic)
									LIMIT 10"
							
		);

			return $query->result_array();
			$query->free_result();
		
		
	}
	function get_tasks($status)
	{
		$dataReturn[]=array(
				'Tasked By',
				'Tasked To',
				'Status',
				'Task Name',
				'Description',
				'Remarks',
				'Sent On',
				'Completed On');
		//*
		$this->db->from('tasks');
		$this->db->where('status',$status);
		if($status=="complete")
		{
			$this->db->limit(10);
		}
	
		$q = $this->db->get();
		//*/
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$dataReturn[]=array(
						'sent_by'=> $row->sent_by,
						'sent_to'=> $row->sent_to,
						'status'=> $row->status,
						'task_header'=> $row->task_header,
						'task'=> $row->task,
						'remarks'=> $row->remarks,
						'date_sent'=> $row->date_sent,
						'date_accomplished'=> $row->date_accomplished,
				);
			}
		}

		$q->free_result();
		return $dataReturn;
	}
	
	/*
	function get_last_visit($user)
	{
		$this->db->select('ls_date, ls_barangay');
			$this->db->from('ls_report_header');
			$this->db->where('ls_inspector', $user);
			$this->db->order_by('ls_date','desc');
			$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row;
		}
		return NULL;
	}
	
	function get_oldest_date()
	{
		$this->db->select('created_on');
			$this->db->from('ls_report_main');
			$this->db->order_by('created_on','asc');
			$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row['created_on'];
		}
		return NULL;
	}
	*/
}


/* End of suggest_model.php */
/* Location: ./application/models/suggest_model.php */