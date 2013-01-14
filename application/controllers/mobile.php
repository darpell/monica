<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		
	}
	/*public function view($url)
	{
		var_dump($url);
		$this->load->view($url);
	}*/
	
	public function login()
	{
		$this->load->view('mobile/login.php');
	}
	public function casemap()
	{
		$this->load->view('mobile/casemap.php');
	}
	public function riskmap()
	{
		$this->load->view('mobile/riskmap.php');
	}
	public function checklocation()
	{
		$this->load->view('mobile/current_pos.php');
	}
	
}

/* End of file mobile.php */
/* Location: ./application/controllers/mobile.php */
