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
			$pieces1=explode("-",$this->input->post('beginDate'));
			$pieces2=explode("-",$this->input->post('endDate'));
			$data['b_date'] = $pieces1[0].", ".$pieces1[1].", ".$pieces1[2];
			$data['e_date'] = $pieces2[0].", ".$pieces2[1].", ".$pieces2[2];
		}//*/
		else
		{
			// setting dates
			$data['begin_date'] = date("Y") . '-01-01';
			$data['end_date'] = date("Y-m-d");
			$data['b_date'] = date("Y") . ', 1, 1';
			$data['e_date'] = date("Y,m,d");
		}
		
		
		//$begin_date = date("Y") . '-01-01';//date("Y-m-d H:i:s");
		//$current_date = date("Y-m-d");
		$dates['date1']=$data['begin_date'];//echo $data['begin_date']." END ";
		$dates['date2']=$data['end_date'];//echo $data['end_date']." END ";
		$temp['dateSel1']=$data['begin_date'];
		$temp['dateSel2']=$data['end_date'];
		$loc=null;
		$bgy=null;
		//
		//$bgy="SAMPALOC I";/*
		if($this->input->post('barangay')!=null)//*/
		{
			$loc='brgy';
			//$bgy=$this->input->post('barangay');
		}
			$temp['barangay']=$bgy;
		
		// larval points
		$data['larvalPositives'] = $this->larval_mapping->get_points($data['begin_date'], $data['end_date'],$loc,$bgy);

		// risk nodes
		$data['pointsOfInterest'] = $this->remap_model->get_map_nodes($data['begin_date'], $data['end_date'],$loc,$bgy);

		//print_r("TEMP: ".$temp['barangay']);
		// investigated cases
		//$data['investigatedCases'] = ;
		
		$denguetemp = array();
		$denguetemp = $this->remap_model->investigated_cases($temp);
		$bouncetemp = $this->remap_model->getCaseDistancePoI($denguetemp,$data['pointsOfInterest'],$data['larvalPositives']);
		//print_r($data['larvalPositives']);
		//print_r($bouncetemp);
		$i=0;
		$NewArray = array();
		foreach($data['pointsOfInterest'] as $value) {
			$NewArray[] = array_merge($value,$bouncetemp['bounceInfo'][$i]);
			$i++;
		}//print_r($bouncetemp['countInfo']);
		//print_r($NewArray);
		$data['data_exists']=$denguetemp['data_exists'];
		if($denguetemp['data_exists']==1)
		$data['dataCases']=$denguetemp['dataCases'];
		$data['pointsOfInterest']=$NewArray;//print_r($data['pointsOfInterest']);
		$sourceTable[]=array(
				0=>"Name",
				1=>"Notes",
				2=>"Barangay",
				3=>"Larvae<br/>within<br/>200m",
				4=>"Dengue Cases<br/>within<br/>200m"
		);
		$riskTable[]=array(
				0=>"Name",
				1=>"Notes",
				2=>"Barangay",
				3=>"Larvae<br/>within<br/>200m",
				4=>"Sources<br/>in alert<br/>within<br/>200m"
		);
		foreach($data['pointsOfInterest'] as $key => $value)
		{
			if($value['node_type']==0)
			{
				$sourceTable[]=array(
					0=>$value['node_name'],
					1=>$value['node_notes'],
					2=>$value['node_barangay'],
					3=>$bouncetemp['countInfo'][$key]['0'],
					4=>$bouncetemp['countInfo'][$key]['1']
					);
			}
			else
			{
				$riskTable[]=array(
					0=>$value['node_name'],
					1=>$value['node_notes'],
					2=>$value['node_barangay'],
					3=>$bouncetemp['countInfo'][$key]['0'],
					4=>$bouncetemp['countInfo'][$key]['1']
				);
			}
		}
		$data['sourceTable']=$sourceTable;
		$data['riskTable']=$riskTable;
		//polygon nodes
		$data['polygon_nodes'] = $this->remap_model->get_polygon_nodes($bgy);
		$data['larval_array'] = $this->remap_model->getLarvalCount($data['begin_date'], $data['end_date'],$loc,$bgy);
		//ages (Returns an array, code found in the function "getBarangayAges")
		$data['ages_array'] = $this->remap_model->getBarangayAges($dates);//print_r($data['ages_array']);
		$data['dengue_array'] = $this->remap_model->getDengueInfo($dates);//print_r($data['dengue_array']);
		//$data['PoI_distance_array'] = $this->larval_mapping->distance_formula_PoI($dates);//print_r($data['PoI_distance_array']);
		$data['brgys'] = $this->remap_model->get_brgy_with_cases($data['begin_date'], $data['end_date']);
		$this->load->library('table');
		$this->load->view('pages/remap',array_merge($data));
	}
}

/* End of file remap.php */
/* Location: ./application/controllers/remap.php */