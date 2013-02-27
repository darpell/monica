<?php 
class Larval_mapping extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	// returns the all larval points
	function getPoints($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
			$this->db->from('ls_report_main');
			$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
			if ($place != NULL)
			{
				$this->db->where(checkplace($place),$value);
			}
			
		if ($begin_date === FALSE || $end_date === FALSE)
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
	
	function checkPlace($place)
	{
		if ($place == 'brgy')
		{
			return 'ls_barangay';
		}
		else if ($place == 'city')
		{
			return 'ls_city';
		}
		else if ($place == 'street')
		{
			return 'ls_street';
		}
	}
	
	function getBrgys()
	{
		$this->db->select('ls_barangay');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_barangay');
		
		return $this->db->get()->result_array();
	}
	
	function getCities()
	{
		$this->db->select('ls_municipality');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_municipality');
		
		return $this->db->get()->result_array();
	}
	
	function getStreets()
	{
		$this->db->select('ls_street');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_street');
		
		return $this->db->get()->result_array();
	}
}


/* End of larval_mapping.php */
/* Location: ./application/models/larval_mapping.php */