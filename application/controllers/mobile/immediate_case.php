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
		//$this->form_validation->set_rules('mob_username-txt_r', 'username', 'required');
		//$this->form_validation->set_rules('mob_password-txt_r', 'password', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('immediate_case_form');
		}
		
	}
}

/* End of file mobile/immediate_case.php */
/* Location: ./application/controllers/mobile/immediate_case.php */