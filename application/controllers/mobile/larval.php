<?php
class Larval extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('larval_mapping');
	}
	
	function index()
	{
		$data['points'] = $this->larval_mapping->getPoints();
		$this->load->view('mobile/riskmap', $data);
	}
	
	function filterPoints()
	{
		$this->load->view('mobile/larval_dialog');
	}
}

/* End of file mobile/larval.php */
/* Location: ./application/controllers/mobile/larval.php */