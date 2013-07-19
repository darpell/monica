<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Investigate_cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('investigate_cases_model','ic');
	}
	
	function index()
	{
		
		$data['cases'] = $this->ic->get_uninvestigated_cases($this->ic->get_user_brgy($this->session->userdata('TPusername')));
		$this->load->view('mobile/uninvestigated_cases',$data);
	}
	
	function plot_case()
	{
			
	}
}

/* End of file mobile/investigate_cases.php */
/* Location: ./application/controllers/mobile/investigate_cases.php */