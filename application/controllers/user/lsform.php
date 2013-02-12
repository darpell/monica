<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsform extends CI_Controller
{
	public function index()
	{	
		$this->redirectLogin();
		$data['title'] = 'Add report';
		$data['script'] = '';
		$data['result'] = null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('mobile/ls_form',$data);
		}
		else
		{
			
		}
	}
	
	function redirectLogin()
	{
		// TODO
		if($this->session->userdata('logged_in') != TRUE )
			redirect(substr(base_url(), 0, -1) . '/index.php/login');
	}
	
	function addls()
	{
		$data['title'] = 'Add larval survey';
		$data['script'] = '';

		$this->form_validation->set_rules('TPcontainer-txt_r', 'container', 'required');
		$this->form_validation->set_rules('TPhousehold-txt_r', 'household', 'required');
		$this->form_validation->set_rules('TPbarangay-txt_r', 'barangay', 'required');
		$this->form_validation->set_rules('TPdate-txt_r', 'date', 'required');
		$this->form_validation->set_rules('TPmunicipality-txt_r', 'municipality', 'required');
		$this->form_validation->set_rules('TPstreet-txt_r', 'street', 'required');
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/ls_form',$data);
		}
		else
		{
			$this->load->model('larval_survey');
			$data = array(
						'TPcreatedby-txt'		=>	$this->session->userdata('TPusername'),
						'TPcreatedon-txt' 		=>	date("Y-m-d H:i:s"),
						'TPlastupdatedby-txt' 	=> 	$this->session->userdata('TPusername'),
						'TPlastupdatedon-txt' 	=> 	date("Y-m-d H:i:s"),			
						'TPcontainer-txt' 		=> 	$this->input->post('TPcontainer-txt_r'),
						'TPhousehold-txt' 		=> 	$this->input->post('TPhousehold-txt_r'),
						'TPresult-rd' 			=>	'negative',
						'TPbarangay-txt' 		=>	$this->input->post('TPbarangay-txt_r'), 
						'TPdate-txt' 			=>	$this->input->post('TPdate-txt_r'), 		// TODO to be continued..
						'TPinspector-txt' 		=>	$this->session->userdata('TPusername'), 			
						'TPmunicipality-txt' 	=>	$this->input->post('TPmunicipality-txt_r'),
						'TPstreet-txt' 			=>	$this->input->post('TPstreet-txt_r'),
						'lat'					=>	$this->input->post('lat'),
						'lng'					=>	$this->input->post('lng')
					);
			//$this->larval_survey->addLS_report($data);
			$this->larval_survey->add($data);
			
			$return_data['result'] = 'Your entry has been recorded.';
			$this->load->view('mobile/home',$return_data);
		}
	}
	function viewLarvalReport()
	{
		$this->redirectLogin();
	
		$data['title'] = 'View larval Cases';
	
		//scripts if none keep ''
		$data['script'] = 'view_casereport';
	
		//for table result keep null here
		$data['table'] = null;
	
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/view_lsform',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function searchLarvalReport()
	{		$this->redirectLogin();
	$this->load->model('larval_survey');
	
	$datefrom = explode ('/', $this->input->post('datefrom'));
	$dateto = explode ('/', $this->input->post('dateto'));
	$data = array(
			'TPtrack-txt' => $this->input->post('TPtrack-txt'),
			'TPdatefrom-txt' => ($datefrom[2]. '-' . $datefrom[0]. '-' .$datefrom[1]),
			'TPdateto-txt' =>  ($dateto[2]. '-' . $dateto[0]. '-' .$dateto[1]),
			'TPsort-dd' => $this->input->post('TPsort-dd')
	);
	
	//scripts if none keep ''
	$data['script'] = 'view_casereport';
	$data['title']= "searchcases";
	//for table result for search
	$data['table'] = $this->larval_survey->searchcase($data);
	
	/** Validation rules could be seen at application/config/form_validation.php **/
	if ($this->form_validation->run('') == FALSE)
	{
		$this->load->library('table');
		$this->load->view('pages/view_lsform',$data);
	}
	else
	{
		$this->load->view('pages/success');
	}
	
	
	}
	
	function update_survey()
	{	$this->redirectLogin();
	$this->load->model('larval_survey');
	/* css */
	$data['base'] = $this->config->item('base_url');
	$data['css'] = $this->config->item('css');
	$data['title'] = 'Update Larval Survey';
	
	
	//scripts if none keep ''
	
	
	//for table result for search
	
	$data = array(
			'track' => $this->input->post('tracking'),
			'result' => $this->input->post('TPresult-rd')
	);
	$this->larval_survey->updateResult($data);
	
	$data['script'] = 'view_casereport';
	$this->load->view('pages/success',$data);
	}
	
	
	function view_survey()
	{	$this->redirectLogin();
	$this->load->model('larval_survey');
	$data['track'] = $this->uri->segment(3,"");
	
	/* css */
	$data['base'] = $this->config->item('base_url');
	$data['css'] = $this->config->item('css');
	$data['title'] = 'Update Larval Survey';
	
	
	//scripts if none keep ''
	$data['script'] = 'view_casereport';
	
	//for table result for search
	$data['info'] = $this->larval_survey->getReportInfo($data);
	
	/** Validation rules could be seen at application/config/form_validation.php **/
	if ($this->form_validation->run('') == FALSE)
	{
		$this->load->library('table');
		$this->load->view('pages/update_ls',$data);
	}
	else
	{
		$this->load->view('pages/success');
	}
	}
}

/* End of file user/lsform.php */
/* Location: ./application/controllers/user/lsform.php */