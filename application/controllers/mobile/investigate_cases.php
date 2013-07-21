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
		//$data['test'] = $this->ic->get_user_brgy($this->session->userdata('TPusername'));
		$this->load->view('mobile/uninvestigated_cases',$data);
	}
	
	function plot($slug)
	{
		$data['case_details'] = $this->ic->get_uninvestigated_cases($this->ic->get_user_brgy($this->session->userdata('TPusername')), $slug);
	
		if (empty($data['case_details']))
		{
			show_404();
		}
	
		$data['title'] = $data['case_details']['cr_first_name'] . ' ' . $data['case_details']['cr_last_name'];
		$data['slug'] = $slug;

		$this->load->view('mobile/plot_view', $data);
	}
	
	function add()
	{
		if ($this->ic->plot_case())
		{
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/im_case_success',$data);
		}
		else
			show_404();
	}
}

/* End of file mobile/investigate_cases.php */
/* Location: ./application/controllers/mobile/investigate_cases.php */