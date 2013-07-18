<?php 
class Immediate_case_model extends CI_Model
{
	function add($data)
	{
		$this->db->insert('immediate_case',$data);
	}
	
	function update($id,$data)
	{
		$this->db->where('icase_no',$id);
		$this->db->update('immediate_case',$data);
	}
	
	function get_uninvestigated_cases($patient_no = FALSE)
	{
		$query = $this->db->query('SELECT cr.cr_patient_no, cr.cr_first_name, cr.cr_last_name, cr.cr_sex, cr.cr_age, cr.cr_street
									FROM case_report_main cr
									WHERE cr.cr_patient_no NOT IN
										(SELECT ic.case_no
										FROM investigated_cases ic)'
							);
		if ($patient_no === FALSE)
		{
			return $query->result_array();
			$query->free_result();
		}
		$query = $this->db->query("SELECT *
									FROM case_report_main cr
									WHERE cr.cr_patient_no = " . $patient_no . " and cr.cr_patient_no NOT IN
										(SELECT ic.case_no
										FROM investigated_cases ic)"
							);
		return $query->result_array();
		$query->free_result();
		
		
	}
}

/* End of immediate_case_model.php */
/* Location: ./application/models/immediate_case_model.php */