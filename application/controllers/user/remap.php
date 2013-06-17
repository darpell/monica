<?php

class Remap extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('larval_mapping');
		$this->load->model('remap_model');
	}
	public function index()
	{
		//global variables
		$data['title'] = 'Map';
		$data['script'] = '';
		$data['test'] = 'fail';
		
		//*check if postback
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
		{
			$beginDate = $this->input->post('beginDate');
			$endDate = $this->input->post('endDate');
			print_r($beginDate);
			print_r($endDate);
			$data['begin_date'] = $beginDate;
			$data['end_date'] = $endDate;
		}//*/
		else
		{
			// setting dates
			$data['begin_date'] = date("Y") . '-01-01';
			$data['end_date'] = date("Y-m-d");
		}
		
		
		$begin_date = date("Y") . '-01-01';//date("Y-m-d H:i:s");
		$current_date = date("Y-m-d");
		
		// larval points
		$data['points'] = $this->larval_mapping->get_points($begin_date, $current_date);
		
		// risk nodes
		$data['map_nodes'] = $this->remap_model->get_map_nodes();//($begin_date, $current_date);
		
		// polygon nodes
		$data['polygon_nodes'] = $this->remap_model->get_polygon_nodes();
		
		$this->load->view('pages/remap',$data);
	}
}

/* End of file remap.php */
/* Location: ./application/controllers/remap.php */