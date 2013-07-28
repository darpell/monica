<?php

class Suggest extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('suggest_model');
		$this->load->model('Remap_model');
		$this->load->library('table');
	}
	
	public function index()
	{
		$data['title'] = 'Route Information';
		$data['script'] = '';
		
		$user = $this->session->userdata('TPusername');
		$brgy = $this->suggest_model->get_user_brgy($user);
		$data['query'] = $this->suggest_model->get_cases($brgy, '2013-01-01','2013-07-22');
		
		
		/* TODO Pagination
		$this->load->library('pagination');
		
		$config['base_url'] = 'http://localhost/workspace/monica/index.php/suggested';
		$config['total_rows'] = 200;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config);
		
		echo $this->pagination->create_links();
		*/
		if(date("m")<=4 || date("m")>=11)//Dry Season
		{
			if(date("m")<=4)
			{
				$Qdata['datePresB']=(date("Y")-1).'-11-01';
				$Qdata['datePresE']=date("Y-m-d");
				$Qdata['datePrev1B']=(date("Y")-2).'-11-01';
				$Qdata['datePrev1E']=(date("Y")-1).'-04-30';
				$Qdata['datePrev2B']=(date("Y")-3).'-11-01';
				$Qdata['datePrev2E']=(date("Y")-2).'-04-30';
			}
			else
			{
				$Qdata['datePresB']=date("Y").'-11-01';
				$Qdata['datePresE']=date("Y-m-d");
				$Qdata['datePrev1B']=(date("Y")-1).'-11-01';
				$Qdata['datePrev1E']=date("Y").'-04-30';
				$Qdata['datePrev2B']=(date("Y")-2).'-11-01';
				$Qdata['datePrev2E']=(date("Y")-1).'-04-30';
			}
		}
		else//Wet Season
		{
			$Qdata['datePresB']=date("Y").'-05-01';
			$Qdata['datePresE']=date("Y-m-d");
			$Qdata['datePrev1B']=(date("Y")-1).'-05-01';
			$Qdata['datePrev1E']=(date("Y")-1).'-10-31';
			$Qdata['datePrev2B']=(date("Y")-2).'-05-01';
			$Qdata['datePrev2E']=(date("Y")-2).'-10-31';
		}
			
		$Qdata['barangay']=array(
				'SAN AGUSTIN III',
				'SAMPAOC I'
		);
		$data = array_merge($data,$this->Remap_model->getRepeatingLarvals($Qdata));
		$this->load->view('pages/view_suggested',$data);
	}
}

/* End of file suggest.php */
/* Location: ./application/controllers/suggest.php */