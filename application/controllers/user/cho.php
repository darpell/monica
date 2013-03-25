<?php
class Cho extends CI_Controller
{
	public function index()
	{	
		$this->redirectLogin();
		$this->view_tasks();
		
	}
	function redirectLogin()
	{	$this->load->library('mobile_detect');
	if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
	{
		$this->load->view('mobile/index.php');
	}
	elseif ($this->session->userdata('logged_in') != TRUE && $this->session->userdata('TPtype') != 'CHO' ){
		redirect(substr(base_url(), 0, -1) . '/index.php/login');
	}
	}
	function view_tasks()
	{	$this->redirectLogin();
		$this->load->model('Cho_model');
		
		
		$this->form_validation->set_rules('TPtask-txt', 'Task', 'required');
		$this->form_validation->set_rules('TPtaskhead-txt', 'Task Header', 'required');
		if ($this->form_validation->run('') == FALSE)
		{
		$data['title'] = 'View Tasks';
		$data['script'] = 'view_casereport';
		$data['table_data']= $this->Cho_model->get_tasks();
		$data['options']= $this->Cho_model->get_bhw();
		$this->load->view('pages/view_tasks.php' , $data);
		}
		else
		{
			$date= explode ('/', $this->input->post('TPtaskdate-txt'));
			$data = array(
					'task' => $this->input->post('TPtask-txt'),
					'date_sent' => $date[2].'/'.$date[0].'/'.$date[1],
					'sent_to' => $this->input->post('name'),
					'sent_by' => $this->session->userdata('TPusername'),
					'task_header' =>  $this->input->post('TPtaskhead-txt')
			);
			$this->Cho_model->add_task($data);
			$data['title'] = 'View Tasks';
			$data['script'] = 'view_casereport';
			$data['table_data']= $this->Cho_model->get_tasks();
			$data['options']= $this->Cho_model->get_bhw();
			$this->load->view('pages/view_tasks.php' , $data);
		}

	}
	function dashboard()
	{	$this->redirectLogin();
		$this->load->model('Cho_model');
		$data['title'] = 'View Tasks';
		$data['script'] = 'view_casereport';
		$data['table_data']= $this->Cho_model->get_tasks();
		$data['options']= $this->Cho_model->get_bhw();
		$data['barangay_count']= $this->Cho_model->get_barangay_count();
		$data['age_count']= $this->Cho_model->get_age_count();
		$epidemic = $this->Cho_model->epidemic_threshold();
		$data['quartile'] = '';
		for($s = 1 ; $s < count($epidemic['quartile']) ; $s++ )
		{	
			$data['quartile'] .= $epidemic['quartile'][$s] .'&&';
		}
		$data['csum'] = '';
		for($s = 1 ; $s < count($epidemic['csum']) ; $s++ )
		{
			$data['csum'] .= $epidemic['csum'][$s] .'&&';
		}
		$data['m2sd'] = '';
		for($s = 1 ; $s < count($epidemic['m2sd']) ; $s++ )
		{
			$data['m2sd'] .= $epidemic['m2sd'][$s] .'&&';
		}
		$data['csum196sd'] = '';
		for($s = 1 ; $s < count($epidemic['csum196sd']) ; $s++ )
		{
			$data['csum196sd'] .= $epidemic['csum196sd'][$s] .'&&';
		}
		$data['cases'] = '';
		for($s = 1 ; $s < count($epidemic['data'][1]) ; $s++ )
		{
			$data['cases'] .= $epidemic['data'][1][$s] .'&&';
		}
		if ($this->input->post('barangay') == null OR $this->input->post('barangay') == 'All' )
		{$data['parameter'] = 'All';
		$data['table'] = $this->Cho_model->epidemic_threshold();
		}
		else
		{
			$data['parameter'] = $this->input->post('barangay');
			$data['table'] = $this->Cho_model->epidemic_threshold( $this->input->post('barangay'));
		}

		$data['barangay'] = $this->Cho_model->getAllBarangays();
		$data['larval'] = $this->Cho_model->getPositiveSurveys();
		$this->load->view('pages/dashboard.php' , $data);
	}
	function epidemic_threshold()
	{	
		$this->load->model('Cho_model');
		if ($this->input->post('barangay') == null OR $this->input->post('barangay') == 'All' )
		{$data['parameter'] = 'All';
		$data['table'] = $this->Cho_model->epidemic_threshold();
		}
		else 
		{
		$data['parameter'] = $this->input->post('barangay');
		$data['table'] = $this->Cho_model->epidemic_threshold( $this->input->post('barangay'));
		}
		$epidemic = $data['table'];
		$data['title'] = 'View Tasks';
		$data['script'] = '';
		$data['arranged'] = array();
		$data['arranged'][]=array(
				'epidemic'=>'Epidemic Threshold',
				'1'=> 'Jan.',
				'2'=> 'Feb.',
				'3'=> 'Mar.',
				'4'=> 'Apr.',
				'5'=> 'May',
				'6'=> 'Jun.',
				'7'=> 'Jul.',
				'8'=> 'Aug.',
				'9'=> 'Sept',
				'10'=> 'Oct.',
				'11'=> 'Nov.',
				'12'=> 'Dec.',
		);
		$data['arranged'][]=array(
				'epidemic'=>'3rd Quartile',
				'1'=> $data['table']['quartile'][1],
				'2'=> $data['table']['quartile'][2],
				'3'=> $data['table']['quartile'][3],
				'4'=> $data['table']['quartile'][4],
				'5'=> $data['table']['quartile'][5],
				'6'=> $data['table']['quartile'][6],
				'7'=> $data['table']['quartile'][7],
				'8'=> $data['table']['quartile'][8],
				'9'=> $data['table']['quartile'][9],
				'10'=>$data['table']['quartile'][10],
				'11'=> $data['table']['quartile'][11],
				'12'=> $data['table']['quartile'][12],
				);
		$data['arranged'][]=array(
				'epidemic'=>'C-SUM',
				'1'=> $data['table']['csum'][1],
				'2'=> $data['table']['csum'][2],
				'3'=> $data['table']['csum'][3],
				'4'=> $data['table']['csum'][4],
				'5'=> $data['table']['csum'][5],
				'6'=> $data['table']['csum'][6],
				'7'=> $data['table']['csum'][7],
				'8'=> $data['table']['csum'][8],
				'9'=> $data['table']['csum'][9],
				'10'=>$data['table']['csum'][10],
				'11'=> $data['table']['csum'][11],
				'12'=> $data['table']['csum'][12],
		);
		$data['arranged'][]=array(
				'epidemic'=>'mean+2SD',
				'1'=> $data['table']['m2sd'][1],
				'2'=> $data['table']['m2sd'][2],
				'3'=> $data['table']['m2sd'][3],
				'4'=> $data['table']['m2sd'][4],
				'5'=> $data['table']['m2sd'][5],
				'6'=> $data['table']['m2sd'][6],
				'7'=> $data['table']['m2sd'][7],
				'8'=> $data['table']['m2sd'][8],
				'9'=> $data['table']['m2sd'][9],
				'10'=>$data['table']['m2sd'][10],
				'11'=> $data['table']['m2sd'][11],
				'12'=> $data['table']['m2sd'][12],
		);
		$data['arranged'][]=array(
				'epidemic'=>'C-SUM+1.96SD',
				'1'=> $data['table']['csum196sd'][1],
				'2'=> $data['table']['csum196sd'][2],
				'3'=> $data['table']['csum196sd'][3],
				'4'=> $data['table']['csum196sd'][4],
				'5'=> $data['table']['csum196sd'][5],
				'6'=> $data['table']['csum196sd'][6],
				'7'=> $data['table']['csum196sd'][7],
				'8'=> $data['table']['csum196sd'][8],
				'9'=> $data['table']['csum196sd'][9],
				'10'=>$data['table']['csum196sd'][10],
				'11'=> $data['table']['csum196sd'][11],
				'12'=> $data['table']['csum196sd'][12],
		);
		$data['arranged'][]=$data['table']['data'][1];
		$data['chart_data'] =  'Jan.&&Feb.&&Mar.&&Apr.&&May.&&Jun.&&Jul.&&Aug.&&Sept.&&Oct.&&Nov.&&Dec.%%';

		for($s = 1; $s < count($data['arranged']); $s++)
		{
			for($i = 1; $i<count($data['arranged'][$s]); $i++)
			{
				if($i == count($data['arranged'][$s])-1)
					$data['chart_data'] .= $data['arranged'][$s][$i].'%%';
				else 
					$data['chart_data'] .= $data['arranged'][$s][$i].'&&';
			}
		}
		
		$data['quartile'] = '';
		for($s = 1 ; $s < count($epidemic['quartile']) ; $s++ )
		{
			$data['quartile'] .= $epidemic['quartile'][$s] .'&&';
		}
		$data['csum'] = '';
		for($s = 1 ; $s < count($epidemic['csum']) ; $s++ )
		{
			$data['csum'] .= $epidemic['csum'][$s] .'&&';
		}
		$data['m2sd'] = '';
		for($s = 1 ; $s < count($epidemic['m2sd']) ; $s++ )
		{
			$data['m2sd'] .= $epidemic['m2sd'][$s] .'&&';
		}
		$data['csum196sd'] = '';
		for($s = 1 ; $s < count($epidemic['csum196sd']) ; $s++ )
		{
			$data['csum196sd'] .= $epidemic['csum196sd'][$s] .'&&';
		}
		$data['cases'] = '';
		for($s = 1 ; $s < count($epidemic['data'][1]) ; $s++ )
		{
			$data['cases'] .= $epidemic['data'][1][$s] .'&&';
		}
		$data['barangay'] = $this->Cho_model->getAllBarangays();
		$this->load->library('table');
		$this->load->view('pages/view_epidemic_threshold.php' , $data);
		
	
	}
	
	
	
	
}

/* End of file user/cho.php */
/* Location: ./application/controllers/user/cho.php */
