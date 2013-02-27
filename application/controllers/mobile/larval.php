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
		$this->form_validation->set_rules('begin_date','starting date','required');
		$this->form_validation->set_rules('end_date','ending date','required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['brgys'] = $this->larval_mapping->getBrgys();
			$data['streets'] = $this->larval_mapping->getStreets();
			$data['cities'] = $this->larval_mapping->getCities();
			$this->load->view('mobile/larval_dialog',$data);
		}
		else
		{
			$begin = date('Y-m-d', strtotime($this->input->post('begin_date')));
			$end = date('Y-m-d', strtotime($this->input->post('end_date')));
			$place = $this->input->post('place-ddl');
			$value = ($this->input->post('place-ddl') == NULL) ? NULL : '';
			$data['points'] = $this->larval_mapping->getPoints($begin,$end,$place,$value);

			$this->load->view('mobile/larval_dialog',$data);
		}
	}
}

/* End of file mobile/larval.php */
/* Location: ./application/controllers/mobile/larval.php */