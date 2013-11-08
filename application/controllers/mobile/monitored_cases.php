<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitored_cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('immediate_case_model','ic');
	}
	
	function serious_cases()
	{
		//echo 'Hello World!';
		
		
		$data['cases'] = $this->ic->get_serious_imcases($this->session->userdata('TPusername'));
		$this->load->view('mobile/serious_cases', $data);
		
		/*
		 * $data['result'] = '';
		 * $data['tasks'] = $this->tasks->get_tasks($this->session->userdata('TPusername'));
		 * $this->load->view('mobile/tasks.php', $data);
		 */
	}
	
	function view_serious_case_details($imcase_no)
	{
		$data['cases'] = $this->ic->get_case_details($imcase_no);
		$this->load->view('mobile/imcase_details', $data);
	}
	
	function suspected_cases()
	{
		//echo 'Hello World!';
	
	
		$data['cases'] = $this->ic->get_suspected_imcases($this->session->userdata('TPusername'));
		$this->load->view('mobile/suspected_cases', $data);
	
		/*
		 * $data['result'] = '';
		* $data['tasks'] = $this->tasks->get_tasks($this->session->userdata('TPusername'));
		* $this->load->view('mobile/tasks.php', $data);
		*/
	}
	
	function view_suspected_case_details($imcase_no)
	{
		$data['cases'] = $this->ic->get_case_details($imcase_no);
		$this->load->view('mobile/imcase_details', $data);
	}
	
	function hospitalized_cases()
	{
		//echo 'Hello World!';
	
	
		$data['cases'] = $this->ic->get_hospitalized_imcases($this->session->userdata('TPusername'));
		$this->load->view('mobile/hospitalized_cases', $data);
	
		/*
		 * $data['result'] = '';
		* $data['tasks'] = $this->tasks->get_tasks($this->session->userdata('TPusername'));
		* $this->load->view('mobile/tasks.php', $data);
		*/
	}
	
	function view_hospitalized_case_details($imcase_no)
	{
		$data['cases'] = $this->ic->get_case_details($imcase_no);
		$this->load->view('mobile/imcase_details', $data);
	}
}

/* End of file mobile/monitored_cases.php */
/* Location: ./application/controllers/mobile/monitored_cases.php */