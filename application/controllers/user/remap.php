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
		$overlays = [];
		//*check if postback
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
		{
			$beginDate = $this->input->post('beginDate');
			$endDate = $this->input->post('endDate');
			$overlays = $this->input->post('overlays');
			$data['begin_date'] = $beginDate;
			$data['end_date'] = $endDate;
		}//*/
		else
		{
			// setting dates
			$data['begin_date'] = date("Y") . '-01-01';
			$data['end_date'] = date("Y-m-d");
		}
		
		
		//$begin_date = date("Y") . '-01-01';//date("Y-m-d H:i:s");
		//$current_date = date("Y-m-d");
		$dates['date1']=$data['begin_date'];
		$dates['date2']=$data['end_date'];
		$temp['dateSel1']=$data['begin_date'];
		$temp['dateSel2']=$data['end_date'];
		$temp['barangay']=null;
		
		if (sizeOf($overlays) != 0)
		{
			if (in_array('interest_points',$overlays))
			{
				// POI nodes
				$data['pointsOfInterest'] = $this->remap_model->get_map_nodes($data['begin_date'], $data['end_date']);
			}
			else { $data['pointsOfInterest'] = NULL; }
			if (in_array('investigatedCases_points',$overlays))
			{
				//Investigated cases
				//$data['investigatedCases'] = $this->remap_model->investigated_cases($temp);
			}
			if (in_array('larvalPositive_points',$overlays))
			{
				// Positive Larval Surveys
				$data['larvalPositives'] = $this->larval_mapping->get_points($data['begin_date'], $data['end_date']);
			}
			else { $data['larvalPositives'] = NULL; }
		}
		else
		{
			// larval points
			$data['larvalPositives'] = $this->larval_mapping->get_points($data['begin_date'], $data['end_date']);

			// risk nodes
			$data['pointsOfInterest'] = $this->remap_model->get_map_nodes($data['begin_date'], $data['end_date']);
			
			// investigated cases
			//$data['investigatedCases'] = ;
			
			
		}
		
		$denguetemp = array();
		$denguetemp = $this->remap_model->investigated_cases($temp);
		$bouncetemp = $this->remap_model->getICBounce($denguetemp,$data['pointsOfInterest']);
		$i=0;
		$NewArray = array();
		foreach($denguetemp['dataCases'] as $value) {
			$NewArray[] = array_merge($value,array($bouncetemp[$i]));
			$i++;
		}
		$data['data_exists']=$denguetemp['data_exists'];
		$data['dataCases']=$NewArray;
		//print_r($NewArray);
		// polygon nodes
		$data['polygon_nodes'] = $this->remap_model->get_polygon_nodes();
		$data['larval_array'] = $this->remap_model->getLarvalCount($data['begin_date'], $data['end_date']);
		//ages (Returns an array, code found in the function "getBarangayAges")
		$data['ages_array'] = $this->remap_model->getBarangayAges($dates);//print_r($data['ages_array']);
		$data['dengue_array'] = $this->remap_model->getDengueInfo($dates);//print_r($data['dengue_array']);
		//$data['PoI_distance_array'] = $this->larval_mapping->distance_formula_PoI($dates);//print_r($data['PoI_distance_array']);
		$data['brgys'] = $this->remap_model->get_brgy_with_cases($data['begin_date'], $data['end_date']);
		$this->load->view('pages/remap',array_merge($data,$NewArray));
	}
}

/* End of file remap.php */
/* Location: ./application/controllers/remap.php */