<?php 
class Tasks_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_tasks($id = FALSE)
	{
		if ($id === FALSE)
		{

			$query = $this->db->get('tasks');
			return $query->result_array();
			$query->free_result();
		}
		$query = $this->db->get_where('tasks',array('task_no' => $id));
		return $query->result_array();
		$query->free_result();
	}
	
	function get_count()
	{
		// TODO
		return 0;
	}
}


/* End of tasks.php */
/* Location: ./application/models/tasks.php */