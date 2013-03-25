<?php
class Case_report extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		//$this->load->model('mapping');
		$this->load->model('case_report_mob');
	}

	function index()
	{
		//$return_data['data_brgy'] = $this->case_report_mob->get_report_data_barangay(date("Y"));
		$return_data['count_current'] = $this->case_report_mob->get_case_count(date("Y"));
		$return_data['count_past_year'] = $this->case_report_mob->get_case_count(date("Y") - 1);
		$this->load->view('mobile/case_report', $return_data);
	}
	
	function province()
	{
		$return_data['province'] = '';
		$return_data['city'] = '';
		$return_data['brgy'] = '';
		
		$return_data['action'] = 'cities';
		$return_data['places'] = $this->case_report_mob->get_provinces();
		$this->load->view('mobile/case_report_filter', $return_data);
	}
	
	function cities()
	{
		$return_data['province'] = $this->input->post('place');
		$return_data['city'] = '';
		$return_data['brgy'] = '';
		
		$return_data['action'] = 'brgys';
		$return_data['places'] = $this->case_report_mob->get_cities($return_data['province']);
		$this->load->view('mobile/case_report_filter', $return_data);
	}
	
	function brgys()
	{
		$return_data['province'] = $this->input->post('province');
		$return_data['city'] = $this->input->post('place');
		$return_data['brgy'] = '';
		
		//$this->form_validation->set_rules('place-ddl','cluster','required');
		$this->form_validation->set_rules('begin_date','starting date','required');
		$this->form_validation->set_rules('end_date','ending date','required');
		if ($this->form_validation->run() == FALSE)
		{
			if ($this->input->post('city') != '')
				$return_data['city'] = $this->input->post('city');
			
			$return_data['action'] = 'brgys';
			$return_data['places'] = $this->case_report_mob->get_brgys($return_data['province'],$return_data['city']);
			$this->load->view('mobile/case_report_filter', $return_data);
		}
		else
		{
			$begin = date('Y-m-d', strtotime($this->input->post('begin_date')));
			$end = date('Y-m-d', strtotime($this->input->post('end_date')));
			
			$return_data['city'] = $this->input->post('city');
			$return_data['brgy'] = $this->input->post('place');
		
			$return_data['places'] = $this->case_report_mob->get_places($return_data['province'],$return_data['city'],$return_data['brgy'],$begin,$end);
			$this->load->view('mobile/case_report_view', $return_data);
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

/* End of file mobile/case_report.php */
/* Location: ./application/controllers/mobile/case_report.php */