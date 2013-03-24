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
}

/* End of immediate_case_model.php */
/* Location: ./application/models/immediate_case_model.php */