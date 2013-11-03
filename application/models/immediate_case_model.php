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
	
	function get_serious_imcases($bhw_id)
	{
		$query = $this->db->query("SELECT MAX(imcase_no) as imcase_no, ic.person_id,
								ic.has_muscle_pain, ic.has_joint_pain, ic.has_headache, ic.has_bleeding, ic.has_rashes,
								ic.days_fever, ic.created_on, ic.last_updated_on, ic.suspected_source, ic.remarks,
								
								ml.person_first_name, ml.person_last_name
								FROM immediate_cases ic
								
								JOIN master_list ml ON ic.person_id = ml.person_id
								JOIN catchment_area ca ON ca.person_id = ml.person_id
								
								WHERE days_fever >= '4' AND ca.bhw_id = '" . $bhw_id . "'
								
								GROUP BY person_id
								ORDER BY days_fever DESC");
		
		return $query->result_array();
		$query->free_result();
	}
	
	function get_suspected_imcases($bhw_id)
	{
		$query = $this->db->query("SELECT MAX(imcase_no) as imcase_no, ic.person_id,
									ic.has_muscle_pain, ic.has_joint_pain, ic.has_headache, ic.has_bleeding, ic.has_rashes,
									ic.days_fever, ic.created_on, ic.last_updated_on, ic.suspected_source, ic.remarks,
									
									ml.person_first_name, ml.person_last_name
									FROM immediate_cases ic
									
									JOIN master_list ml ON ic.person_id = ml.person_id
									JOIN catchment_area ca ON ca.person_id = ml.person_id
									
									WHERE days_fever >= '1' AND days_fever <= '3' AND ca.bhw_id = '" . $bhw_id . "'
									
									GROUP BY person_id
									ORDER BY days_fever DESC");
		
		return $query->result_array();
		$query->free_result();
	}
	
	function get_case_details($imcase_no)
	{
		$query = $this->db->query(
					"SELECT * 

					FROM master_list ml
					JOIN immediate_cases ic
					ON ic.person_id = ml.person_id
					
					JOIN catchment_area ca
					ON ca.person_id = ml.person_id
					
					JOIN household_address ha
					ON ha.household_id = ca.household_id
					WHERE ic.imcase_no = $imcase_no"
				);
		
		return $query->result_array();
		$query->free_result();
	}
}

/* End of immediate_case_model.php */
/* Location: ./application/models/immediate_case_model.php */