<?php 
class Tasks_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_tasks($username, $id = FALSE)
	{
		if ($id === FALSE)
		{

			$query = $this->db->get_where('tasks', array('date_accomplished' => 0, 'sent_to' => $username));
			return $query->result_array();
			$query->free_result();
		}
		$query = $this->db->get_where('tasks',array('task_no' => $id, 'date_accomplished' => 0, 'sent_to' => $username));
		return $query->result_array();
		$query->free_result();
	}
	
	function get_count_unaccomplished($username)
	{
		$this->db->select('count(task_no) as task_count');
			$this->db->from('tasks');
			$this->db->where('date_accomplished', 0);
			$this->db->where('sent_to', $username);
			
		$query = $this->db->get();
		return $query->row_array();
			$query->free_result();
	}
	
	function task_done($task_no,$remark)
	{
		$data = array (
						'remarks'			=> $remark,
						'date_accomplished'	=> date("Y-m-d H:i:s")
					);
		$this->db->where('task_no',$task_no);
		$this->db->update('tasks',$data);
	}
}


/* End of tasks.php */
/* Location: ./application/models/tasks.php */