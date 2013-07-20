<?php
class avemap extends CI_Controller
{
	public function index()
	{
		$this->redirectLogin();
		$this->load->model('Remap_model');
		$this->load->library('table');

		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = '';
		
		if ($this->form_validation->run('') == FALSE)
		{
			if(date("m")<=4 || date("m")>=11)//Dry Season
			{
				if(date("m")<=4)
				{
					$data['datePresB']=(date("Y")-1).'-11-01';
					$data['datePresE']=date("Y-m-d");
					$data['datePrev1B']=(date("Y")-2).'-11-01';
					$data['datePrev1E']=(date("Y")-1).'-04-30';
					$data['datePrev2B']=(date("Y")-3).'-11-01';
					$data['datePrev2E']=(date("Y")-2).'-04-30';
				}
				else
				{
					$data['datePresB']=date("Y").'-11-01';
					$data['datePresE']=date("Y-m-d");
					$data['datePrev1B']=(date("Y")-1).'-11-01';
					$data['datePrev1E']=date("Y").'-04-30';
					$data['datePrev2B']=(date("Y")-2).'-11-01';
					$data['datePrev2E']=(date("Y")-1).'-04-30';
				}
			}
			else//Wet Season
			{
				$data['datePresB']=date("Y").'-05-01';
				$data['datePresE']=date("Y-m-d");
				$data['datePrev1B']=(date("Y")-1).'-05-01';
				$data['datePrev1E']=(date("Y")-1).'-10-31';
				$data['datePrev2B']=(date("Y")-2).'-05-01';
				$data['datePrev2E']=(date("Y")-2).'-10-31';
			}
			$barangays[]=array(
					'SAN AGUSTIN III',
					'SAMPAOC I'
			);
			$data['barangay']=array(
					'SAN AGUSTIN III',
					'SAMPAOC I'
			);
			//$data['barangay']=null;
			
			/*
			print_r($data['datePresB'].":");
			print_r($data['datePresE']."________");
			print_r($data['datePrev1B'].":");
			print_r($data['datePrev1E']."________");
			print_r($data['datePrev2B'].":");
			print_r($data['datePrev2E']);/*
			$data['datePresB']='2013-01-01';
			$data['datePresE']='2013-06-01';
			$data['datePrev1B']='2012-01-01';
			$data['datePrev1E']='2012-12-01';
			$data['datePrev2B']='2011-01-01';
			$data['datePrev2E']='2011-12-01';//*/
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
		