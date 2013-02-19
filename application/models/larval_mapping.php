<?php 
class Larval_mapping extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	// returns the all larval points
	function getPoints($date = FALSE, $place = NULL, $value = NULL)
	{
		$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
			$this->db->from('ls_report_main');
			$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
			
		if ($date === FALSE)
		{
			if ($place != NULL)
			{
				if ($place == 'brgy')
				{
					$this->db->where('ls_barangay',$value);
				}
				else if ($place == 'city')
				{
					$this->db->where('ls_city',$value);
				}
				else if ($place == 'street')
				{
					$this->db->where('ls_street',$value);
				}
			}
				
			$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
		}
		else
		{
			if ($place != NULL)
			{
				if ($place == 'brgy')
				{
					$this->db->where('ls_barangay',$value);
				}
				else if ($place == 'city')
				{
					$this->db->where('ls_city',$value);
				}
				else if ($place == 'street')
				{
					$this->db->where('ls_street',$value);
				}
			}
			
			$this->db->where('created_on',$date);
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
		}
	}
}


/* End of larval_mapping.php */
/* Location: ./application/models/larval_mapping.php */