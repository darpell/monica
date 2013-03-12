<?php
class Cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('mapping');
	}

	function index()
	{
		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = 'view_casereport';
				
		$data['table'] = null;
			
			$barangayWithPolygon[] = $this->mapping->getBarangays();
			$allBarangays[] = $this->mapping->getAllBarangays();
			$data['options'] = array_diff($allBarangays[0],$barangayWithPolygon[0]);
						//print_r(array_diff($allBarangays[0],$barangayWithPolygon[0]));
			$data2['date1']		= '2011-01-01';
			$data2['date2']		= '2020-01-01';
			$data['date1']		= '2011-01-01';
			$data['date2']		= '2020-01-01';
			$data['node_type']	= "denguecase";
			$data['nodes']		= $this->mapping->mapByType($data);
			$data['bcount']		= $this->mapping->getBarangayCount($data2);
			$this->load->library('table');
			$this->load->view('mobile/casemap',$data);
	}

	function filterPoints()
	{
		//$this->form_validation->set_rules('place-ddl','cluster','required');
		$this->form_validation->set_rules('begin_date','starting date','required|callback_checkDateInput[' + $this->input->post('end_date') + ']');
		$this->form_validation->set_rules('end_date','ending date','required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/case_dialog');
		}
		else
		{			
			$barangayWithPolygon[] = $this->mapping->getBarangays();
			$allBarangays[] = $this->mapping->getAllBarangays();
			$data['options'] = array_diff($allBarangays[0],$barangayWithPolygon[0]);
			//print_r(array_diff($allBarangays[0],$barangayWithPolygon[0]));
			$data2['date1']		= date('Y-m-d', strtotime($this->input->post('begin_date')));
			$data2['date2']		= date('Y-m-d', strtotime($this->input->post('end_date')));
			$data['date1']		= date('Y-m-d', strtotime($this->input->post('begin_date')));
			$data['date2']		= date('Y-m-d', strtotime($this->input->post('end_date')));
			$data['node_type']	= "denguecase";
			$data['nodes']		= $this->mapping->mapByType($data);
			$data['bcount']		= $this->mapping->getBarangayCount($data2);
			$this->load->library('table');
			$this->load->view('mobile/casemap',$data);
			
		}
	}

	function checkDateInput($begin,$end)
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

/* End of file mobile/case.php */
/* Location: ./application/controllers/mobile/case.php */