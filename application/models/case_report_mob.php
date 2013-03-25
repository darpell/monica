<?php 
class Case_report_mob extends CI_Model
{
	function get_report_data_barangay($current_year)
	{
		$qString = 'CALL ';
		$qString .= "get_report_data_barangay('"; // name of stored procedure
		$qString .= $current_year . "'" . ")";
		
		$query = $this->db->query($qString);
		return $query->result_array();
		$query->free_result();
	}
	
	function get_case_count($year)
	{
		/*$this->db->select('cr_barangay', 'count(cr_patient_no) as count', 'YEAR(cr_date_onset) as year');
			$this->db->from('case_report_main');
			$this->db->where('YEAR(cr_date_onset)', $year);
			$this->db->group_by('cr_barangay');*/
		
		$query = $this->db->query(
					'SELECT cr_barangay, count(cr_patient_no) as count, YEAR(cr_date_onset) as year'
				.	' FROM case_report_main '
				.	' WHERE YEAR(cr_date_onset) = ' . $this->db->escape($year)
				.	' GROUP BY cr_barangay');
			
			//$query = $this->db->get();
			
			return $query->result_array();
			//$query->free_result();
	}
	
	function get_provinces()
	{
		$this->db->select('cr_province as place');
			$this->db->from('case_report_main');
			$this->db->group_by('cr_province');
		
		return $this->db->get()->result_array();
	}
	
	function get_cities($province)
	{
		$this->db->select('cr_city as place');
			$this->db->from('case_report_main');
			$this->db->where('cr_province', $province);
			$this->db->group_by('cr_city');
		
		return $this->db->get()->result_array();
	}
	
	function get_brgys($province,$city)
	{
		$this->db->select('cr_barangay as place');
		$this->db->from('case_report_main');
		$this->db->where('cr_barangay in (SELECT DISTINCT(barangay)
						FROM barangay AS b RIGHT JOIN map_polygons AS mp ON b.barangay = mp.polygon_name
						WHERE b.city = "Dasmarinas"
						) ');
		$this->db->where('cr_province', $province);
		$this->db->group_by('cr_barangay');
		
		return $this->db->get()->result_array();
	}
	
	function get_places($province,$city,$brgy, $start_date = FALSE, $end_date = FALSE)
	{
		$this->db->select('cr_street as place');
			$this->db->from('case_report_main');
			$this->db->where('cr_province',$province);
			$this->db->where('cr_city',$city);
			$this->db->where('cr_barangay',$brgy);
			
			if ($start_date != FALSE && $end_date != FALSE)
				$this->db->where("cr_date_onset BETWEEN '$start_date' AND '$end_date'");
			
			$this->db->group_by('cr_street');
			
		return $this->db->get()->result_array();
	}
}

/* End of case_report_mob.php */
/* Location: ./application/models/case_report_mob.php */