<?php 
	
	class notif extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		function addnotif($data)
		{	
			
			$this->db->insert('notifications', $data);
			
		}
		function getnotifs($userid)
		{
			$this->db->from('notifications');
			$this->db->join('users','notifications.notif_user = users.user_username');
			$this->db->where('notif_user', $userid);
			$this->db->where('notif_viewed', 'N');

			$query = $this->db->get();
			$data = $query->result_array();
			for($i = 0 ; $i < count($data); $i++)
			{
				$old_date_timestamp = strtotime($data[$i]['notif_createdOn']);
				$new_date = date('l, F d, Y', $old_date_timestamp);
				$data[$i]['notif_createdOn'] = $new_date;
			}
			
			return $data;
			$query->free_result();
		}
		function checknotifexist($id,$userid)
		{
			$this->db->from('notifications');
			$this->db->join('users','notifications.notif_user = users.user_username');
			$this->db->where('notif_user', $userid);
			$this->db->where('unique_id', $id);
			$q = $this->db->get();
			if($q->num_rows() == 0)
			{
				return true;
			}
			else
			{
				return false;
			}	
		}
		function get_midwife_by_barangay($bgy)
		{
			
			$this->db->from('users');
			$this->db->join('bhw','bhw.user_username = users.user_username');
			$this->db->where('user_type', 'MIDWIFE');
			$this->db->where('barangay', $bgy);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach($q->result() as $row)
				{
					$data = $row->user_username;
				}
				return $data;
			}
			else
			{
				return null;
			}
		}
		function get_poi($bgy,$type)
		{	
			if($type == 'source')
			$type = 0;
			else
			$type = 1;
				
			$begin_date = date('Y-m-1');
			$end_date = date('Y-m-d');
			
			$this->db->from('map_nodes');
			$this->db->where('node_barangay',$bgy);
			$this->db->where('node_type',$type);
			$this->db->where("node_addedOn <= '$begin_date' AND (node_endDate ='0000-00-00' OR node_endDate >= '$end_date')");
			$this->db->or_where("node_addedOn BETWEEN '$begin_date' AND '$end_date' AND node_endDate ='0000-00-00'");
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
			
		}
		function get_case($type,$caseid)
		{
			if ($type =='imcase')
			{
				//masterlist
				$this->db->from('master_list');
				$this->db->where('person_id',$caseid);
				$q = $this->db->get();
				
				if($q->num_rows() > 0)
				{
					foreach($q->result() as $row)
					{
						$data = $row->person_first_name. ' '.$row->person_last_name ;
					}
					return $data;
				}
				
			}
			else if ($type == 'invcase')
			{
				$this->db->from('case_report_main');
				$this->db->where('cr_patient_no',$caseid);
				$q = $this->db->get();
				if($q->num_rows() > 0)
				{
					foreach($q->result() as $row)
					{
						$data = $row->cr_first_name. ' '.$row->cr_last_name ;
					}
					return $data;
				}
				
			}
			else if ($type == 'newcase')
			{
				$this->db->from('case_report_main');
				$this->db->where('cr_patient_no',$caseid);
				$q = $this->db->get();
				if($q->num_rows() > 0)
				{
					foreach($q->result() as $row)
					{
						$data = $row->cr_first_name. ' '.$row->cr_last_name ;
					}
					return $data;
				}
				
			}
				
		}
		function view_notif($id)
		{
			$data = array(
					'notif_viewed' => 'Y'
			);
			$this->db->where('notif_id', $id);
			$this->db->update('notifications', $data);
		}
	
		function add_cleanup($midwife,$date,$task)
		{
			$data2 = array(
					'sent_by' => $midwife,
					'sent_to' => $midwife,
					'date_sent' => $date,
					'date_accomplished' => '0000-00-00',
					'task_header' => 'Barangay Cleanup',
					'task' => $task,
					'status' => 'approved',
			);
			$this->db->insert('tasks', $data2);
			
		}
	function get_cleanup($midwife)
	{
		$dataReturn[]=array(
				//'Tasked By',
				//'Tasked To',
				//'Status',
				'Task Name',
				'Description',
				//'Remarks',
				'Date to be conducted',
				//'Completed On'
				);
		//*
		$this->db->from('tasks');
		$this->db->join('bhw', 'bhw.user_username = tasks.sent_to');
		$this->db->where('tasks.task_header','Barangay Cleanup');
		$this->db->where('tasks.sent_to',$midwife);
		$this->db->where('status','approved');
		$q = $this->db->get();
		//*/
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$dataReturn[]=array(
					//	'sent_by'=> $row->sent_by,
					//	'sent_to'=> $row->sent_to,
					//	'status'=> $row->status,
						'task_header'=> $row->task_header,
						'task'=> $row->task,
						//'remarks'=> $row->remarks,
						'date_sent'=> $row->date_sent,
						//'date_accomplished'=> $row->date_accomplished,
				);
			}
		}

		$q->free_result();
		return $dataReturn;
	}
		
		
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
