<?php
class avemap extends CI_Controller
{
	public function index()
	{
		$this->redirectLogin();
		$this->load->model('Remap_model');

		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = '';
		
		if ($this->form_validation->run('') == FALSE)
		{
			$data['datePresB']='2013-01-01';
			$data['datePresE']='2013-06-01';
			$data['datePrev1B']='2012-01-01';
			$data['datePrev1E']='2012-12-01';
			$data['datePrev2B']='2011-01-01';
			$data['datePrev2E']='2011-12-01';
			$this->load->view('pages/aveMap',$this->Remap_model->getRepeatingLarvals($data));
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
}
		