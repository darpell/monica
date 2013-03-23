<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Immediate_case extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('tasks_model','tasks');
	}
	
	function index()
	{
		$this->load->view('mobile/immediate_case_form');
	}
	
	function add()
	{
		$this->form_validation->set_rules('TPdate-txt_r', 'date', 'required');
		$this->form_validation->set_rules('TPfname-txt_r', 'first name', 'required');
		$this->form_validation->set_rules('TPlname-txt_r', 'last name', 'required');
		$this->form_validation->set_rules('TPage-txt_r', 'age', 'required');
		$this->form_validation->set_rules('TPsex-txt_r', 'gender', 'required');
		$this->form_validation->set_rules('TPdob-txt_r', 'date of birth', 'required');
		$this->form_validation->set_rules('TPaddress-txt_r', 'address', 'required');
		$this->form_validation->set_rules('TPremarks-txt_r', 'remarks', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/immediate_case_form');
		}
		else
		{
			
		}
	}
}

/* End of file mobile/immediate_case.php */
/* Location: ./application/controllers/mobile/immediate_case.php */