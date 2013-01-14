<?php 
class Larval_survey extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	
	function addLS_report($data){
			
		$qString = 'CALL '; 
		$qString .= "add_ls_report ('"; // name of stored procedure
		$qString .= 
		//variables needed by the stored procedure
		$data['TPcreatedby-txt'] . "','" . 
		$data['TPcreatedon-txt'] . "','" . 
		$data['TPlastupdatedby-txt'] ."','".
		$data['TPlastupdatedon-txt']. "','".
		$data['TPcontainer-txt'] . "','". 
		$data['TPhousehold-txt'] . "','" . 1234412 . "', '" . 
		$data['TPresult-rd'] . "','" .
		$data['TPbarangay-txt'] . "','" . 
		$data['TPdate-txt'] . "','".
		$data['TPinspector-txt'] . "','". 
		$data['TPmunicipality-txt'] . "','" .
		1234412 . "', '" .
		$data['TPstreet-txt'] . "'". ")";
			
			
		$query = $this->db->query($qString);
	}
}

/* End of larval_survey.php */
/* Location: ./application/models/larval_survey.php */