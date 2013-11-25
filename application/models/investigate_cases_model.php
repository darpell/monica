<?php 
class Investigate_cases_model extends CI_Model
{
	
	function get_uninvestigated_cases($brgy, $patient_no = FALSE)
	{
		$query = $this->db->query("SELECT cr.cr_patient_no, cr.cr_first_name, cr.cr_last_name, cr.cr_sex, cr.cr_age, cr.cr_street
									FROM case_report_main cr
									WHERE DATEDIFF(NOW(), cr.cr_date_onset) <= '30' AND cr.cr_barangay = '" . $brgy . "' AND
										cr.cr_patient_no NOT IN
											(SELECT ic.case_no
											FROM investigated_cases ic)"
							);
		if ($patient_no === FALSE)
		{
			return $query->result_array();
			$query->free_result();
		}
		$query = $this->db->query("SELECT *
									FROM case_report_main cr
									WHERE DATEDIFF(NOW(), cr.cr_date_onset) <= '30' AND cr.cr_patient_no = " . $patient_no . " and cr.cr_patient_no NOT IN
										(SELECT ic.case_no
										FROM investigated_cases ic)"
							);
		return $query->row_array();
		$query->free_result();
		
		
	}
	
	function get_user_brgy($user)
	{	
		$this->db->select('users.user_username, bhw.barangay');
		$this->db->from('users');
		$this->db->join('bhw','users.user_username = bhw.user_username');
		$this->db->where('users.user_username',$user);
		
			$query = $this->db->get();
			if ($query->num_rows() > 0)
				{
					$row = $query->row_array();
					return $row['barangay'];
				}
				return NULL;
		/*
		return $this->db->query(
								'SELECT users.user_username, bhw.barangay
								FROM users JOIN bhw ON users.user_username = bhw.user_username
								WHERE users.user_username = ' . $user
									);
		*/
	}
	
	function plot_case()
	{
		$data = array(
			'case_no'	=>	$this->input->post('patient_no'),
			'lat' 		=>	$this->input->post('lat'),
			'lng' 		=>	$this->input->post('lng'),
			'feedback'	=>	$this->input->post('TPremarks-txt_r')
		);
		
		return $this->db->insert('investigated_cases', $data);
	}
}

/* End of investigate_cases_model.php */
/* Location: ./application/models/investigate_case_model.php */