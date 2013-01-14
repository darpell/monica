<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('mobile_detect');
	}
	public function index()
	{
		//$detect = new Mobile_Detect();
		
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{
			//$this->load->view('mobile/template/header.php');
			//$this->load->view('mobile/checklocation.php');
			$this->load->view('mobile/index.php');
			//$this->load->view('mobile/template/footer.php');
			//echo 'test';
		}
		else 
		{
			//$this->load->view('mobile/riskmap.php');
			//$this->load->view('mobile/index.php');
		} 
		
		/*
		$this->load->library('user_agent');

		if ($this->agent->is_browser())
		{
		    $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		    $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		    $agent = $this->agent->mobile();
		    $this->load->view('mobile/checklocation.php');
		}
		else
		{
		    $agent = 'Unidentified User Agent';
		}
		
		echo $agent;
		
		echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
		*/
	}
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */