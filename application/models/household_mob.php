<?php 
class Household_mob extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add()
	{
		$input_data = array(
				'household_name'=>	$this->input->post('hh_name'),
				'household_lat'	=>	$this->input->post('lat'),
				'household_lng'	=>	$this->input->post('lng'),
				'house_no'		=>	$this->input->post('hh_no'),
				'street'		=>	$this->input->post('hh_street'),
				'last_visited'	=>	date("Y-m-d H:i:s")
		);
		$this->db->insert('household_address',$input_data);
	}
}


/* End of household_mob.php */
/* Location: ./application/models/household_mob.php */