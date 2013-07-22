<?php

class Suggest extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('suggest_model');
		$this->load->library('table');
	}
	
	public function index()
	{
		$data['title'] = 'Route Information';
		$data['script'] = '';
		
		$user = $this->session->userdata('TPusername');
		$brgy = $this->suggest_model->get_user_brgy($user);
		$data['query'] = $this->suggest_model->get_cases($brgy, '2013-01-01','2013-07-22');
		
		$this->load->view('pages/view_suggested',$data);
		
		/* TODO Pagination
		$this->load->library('pagination');
		
		$config['base_url'] = 'http://localhost/workspace/monica/index.php/suggested';
		$config['total_rows'] = 200;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config);
		
		echo $this->pagination->create_links();
		*/
	}
}

/* End of file suggest.php */
/* Location: ./application/controllers/suggest.php */