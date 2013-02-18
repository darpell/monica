<?php 
class Larval_mapping extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	// returns the all larval points
	function getPoints($date = FALSE)
	{
		if ($date === FALSE)
		{
			$this->db->select('ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
			$query = $this->db->get('ls_report_main');
			return $query->result_array();
			$query->free_result();
		}
		
		$this->db->select('ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
		$query = $this->db->get_where('ls_report_main', array('created_on' => $date));
		return $query->result_array();
		$query->free_result();
	}
}


/* End of larval_mapping.php */
/* Location: ./application/models/larval_mapping.php */