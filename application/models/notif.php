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
		
		
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
