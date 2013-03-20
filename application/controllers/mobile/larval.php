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
		$data['distance_formula_200'] = $this->larval_mapping->distance_formula('200');
		$data['distance_formula_50'] = $this->larval_mapping->distance_formula('50');
		$data['points'] = $this->larval_mapping->get_points();
		$this->load->view('mobile/riskmap', $data);
	}
	
	function options()
	{
		$this->load->view('mobile/riskmap_options');
	}
	
	function filter_points()
	{
		//$this->form_validation->set_rules('place-ddl','cluster','required');
		$this->form_validation->set_rules('begin_date','starting date','required|callback_check_date_input[' + $this->input->post('end_date') + ']');
		$this->form_validation->set_rules('end_date','ending date','required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['brgys'] = $this->larval_mapping->get_brgys();
			$data['streets'] = $this->larval_mapping->get_streets();
			$data['cities'] = $this->larval_mapping->get_cities();
			$this->load->view('mobile/larval_dialog',$data);
		}
		else
		{
			$begin = date('Y-m-d', strtotime($this->input->post('begin_date')));
			$end = date('Y-m-d', strtotime($this->input->post('end_date')));
			$place = $this->input->post('place-ddl');
				if ($place == 'brgy')
					$value = $this->input->post('brgy_op');
				else if ($place == 'street')
					$value = $this->input->post('street_op');
				else if ($place == 'city')
					$value = $this->input->post('city_op');
				else
					$value = NULL;
				
			$data['distance_formula_200'] = $this->larval_mapping->distance_formula('200',$begin,$end);
			$data['distance_formula_50'] = $this->larval_mapping->distance_formula('50',$begin,$end);
			$data['points'] = $this->larval_mapping->get_points($begin,$end,$place,$value);

			$this->load->view('mobile/riskmap',$data);
		}
	}
	
	function check_date_input($begin,$end)
	{
		$begin = date('Y-m-d', strtotime($begin));
		$end = date('Y-m-d', strtotime($end));
		if ($begin > $end)
		{
			$this->form_validation->set_message('check_date_input','Invalid date range');
			return FALSE;
		}
		else
			return TRUE;
	}
}

/* End of file mobile/larval.php */
/* Location: ./application/controllers/mobile/larval.php */