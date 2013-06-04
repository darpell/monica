<?php 
class Remap_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_map_nodes($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		//$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
		$this->db->from('map_nodes');
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
		
		$this->db->where("node_addedOn BETWEEN '$begin_date' AND '$end_date'");
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
}

/* End of remap.php */
/* Location: ./application/models/remap.php */