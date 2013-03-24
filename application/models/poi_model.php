<?php 
class Poi_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add($data)
	{
		$this->db->insert('map_nodes',$data);
	}
}

/* End of poi_model.php */
/* Location: ./application/models/poi_model.php */