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
		//$this->form_validation->set_rules('place-ddl','cluster','required');
		$this->form_validation->set_rules('date1','starting date','required');
		$this->form_validation->set_rules('date1','ending date','required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/larval_dialog');
		}
		else
		{
			$this->load->view('mobile/larval_dialog');
		}
	}
}

/* End of file mobile/larval.php */
/* Location: ./application/controllers/mobile/larval.php */