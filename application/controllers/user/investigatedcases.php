<?php
class investigatedcases extends CI_Controller
{
	public function index()
	{
		$this->redirectLogin();
		$this->view_case_investigation();
	}	
	function map()
	{
		$this->redirectLogin();
		$this->load->model('Remap_model');
		
		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = '';
		
		if ($this->form_validation->run('') == FALSE)
		{/*
		$data['dateSel1']=$this->input->post('beginDate');
		$data['dateSel2']=$this->input->post('endDate');
		$data['bName']=$this->input->post('barangay');//*///set to null to display all barangays.
			
		$data['dateSel1']='2000-01-01';
		$data['dateSel2']='2100-01-01';
		$data['barangay']=array(
				'LANGKAAN II',
				'SAMPALOC I'
		);
		//$data['barangay']=null;//set to null to display all barangays.
		$this->load->view('pages/investigatedCases',$this->Remap_model->investigated_cases($data));
		}
		else
		{
			$this->load->view('pages/success');
		}
		
	}
	function redirectLogin()
	{	
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{
			$this->load->view('mobile/index.php');
		}
		elseif ($this->session->userdata('logged_in') != TRUE && $this->session->userdata('TPtype') != 'CHO' )
		{
			redirect(substr(base_url(), 0, -1) . '/index.php/login');
		}
	}
	function view_case_investigation()
	{	$this->redirectLogin();
	$this->load->model('Cho_model');
	$this->load->library('table');
	
	$this->form_validation->set_rules('TPdatefrom-txt', 'Date from', 'required');
	$this->form_validation->set_rules('TPdateto-txt', 'Date to', 'required');
	if ($this->form_validation->run('') == FALSE)
	{
	
		$data['title'] = 'View Pending Tasks';
		$data['script'] = 'view_casereport';
		$data['values_age']= null;
		$data['error']= null;
		$data['barangay_form']  = $this->Cho_model->getAllBarangays();
		array_shift($data['barangay_form']);
		$this->load->view('pages/view_case_investigation.php' , $data);
	}
	}
}