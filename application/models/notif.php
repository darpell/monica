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
			return $query->result_array();
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
	
		function add_cleanup($midwife)
		{
			$this->db->from('tasks');
			$this->db->where('sent_to', $midwife);
			$this->db->where('sent_by', $midwife);
			$this->db->where('date_sent', '0000-00-00');
			$this->db->where('task_header', 'Barangay Cleanup');

			$q = $this->db->get();
			if($q->num_rows() == 0)
			{
			$data2 = array(
					'sent_by' => $midwife,
					'sent_to' => $midwife,
					'date_sent' => '0000-00-00',
					'date_accomplished' => '0000-00-00',
					'task_header' => 'Barangay Cleanup',
					'task' => '',
					'status' => 'pending',
			);
			$this->db->insert('tasks', $data2);
			}
			
		}
		
		
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
