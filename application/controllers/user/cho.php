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
	function view_dengue_profile()
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
		$this->load->view('pages/view_dengue_profile.php' , $data);
	}
	else 
	{	
		$dateto= explode ('/', $this->input->post('TPdateto-txt'));
		$datefrom= explode ('/', $this->input->post('TPdatefrom-txt'));
		$data['dateto'] =  $dateto[2].'/'.$dateto[0].'/'.$dateto[1];
		$data['datefrom'] =  $datefrom[2].'/'.$datefrom[0].'/'.$datefrom[1];
		$data['barangay'] = $this->input->post('barangay');

		$data2 = $this->Cho_model->get_dengue_profile($data);
		if($data2 != null){
		$data['total'] = $data2['total'];
		$data['year'] = $data2['year'];
		$data['values'] = $data2['values'];
		
		$data['title'] = 'View Pending Tasks';
		$data['script'] = 'view_casereport';
		$data['barangay_form']  = $this->Cho_model->getAllBarangays();
		array_shift($data['barangay_form']);
		
		$data['values_age'] = '';
		$data['values_total'] = 'Barangay&&';
		$data['values_gender'] = 'Barangay&&';
		$data['barangay_list'] ='';
		$data['year_list'] ='';
		
		foreach ($data2['year'] as $year)
		{
			$data['values_total'] .= $year . '&&';
			$data['values_gender'] .= 'M '.$year . '&&';
			$data['values_gender'] .= 'F '.$year . '&&';
		}
		$data['values_total'] .=  "%%";
		$data['values_gender'] .=  "%%";
		
		foreach ($data2['barangay'] as $barangay)
		{	$data['values_total'] .= $barangay . "&&";
			$data['values_gender'] .= $barangay . "&&";
			$data['values_age'] .= $barangay . "##";
			$data['barangay_list'] .= $barangay . "&&";
			
			
			$data['values_age'] .='Age group'. '&&';
			foreach ($data2['year'] as $year)
			{
				$data['values_age'] .= $year . '&&';
			}
				$data['values_age'] .=  "@@";
			
			
			for($s = 0; $s < 5; $s++)
			{
				if($s <4 )
					{ $data['values_age'] .= ($s * 10)."-".(($s *10)+10).'&&';}
				else{ $data['values_age'] .= '>40'.'&&';}
				
				foreach ($data2['year'] as $year)
				{
					$sum = $data2['values'][$year][$barangay]['M'][$s] + $data2['values'][$year][$barangay]['F'][$s];
					$data['values_age'] .= $sum.'&&';
				}
				$data['values_age'] .=  "@@";
			}
			
			$data['values_age'] .=  "%%";
			
			foreach ($data2['year'] as $year)
			{
				$data['values_total'] .=
				$data2['total'][$year][$barangay] . "&&" ;
				$data['year_list'] .= $year . "&&";
				
				
				$male = $data2['values'][$year][$barangay]['M'][0] +
						$data2['values'][$year][$barangay]['M'][1] +
						$data2['values'][$year][$barangay]['M'][2] +
						$data2['values'][$year][$barangay]['M'][3] +
						$data2['values'][$year][$barangay]['M'][4];
				$data['values_gender'] .= $male . "&&" ;
				
				$female = $data2['values'][$year][$barangay]['F'][0] +
						$data2['values'][$year][$barangay]['F'][1] +
						$data2['values'][$year][$barangay]['F'][2] +
						$data2['values'][$year][$barangay]['F'][3] +
						$data2['values'][$year][$barangay]['F'][4];
				$data['values_gender'] .= $female . "&&" ;
			}
			$data['values_total'] .=  "%%";
			$data['values_gender'] .=  "%%";
		
		}
		$test = explode('%%' , $data['values_age']);
		$test = explode('##' , $test[0]);
		$test = explode('@@' , $test[1]);
		$test = explode('&&' , $test[0]);
		$data['error']= null;
		print_r($test);
		}
		else
		{
			$data['title'] = 'View Pending Tasks';
			$data['script'] = 'view_casereport';
			$data['values_age']= null;
			$data['error']= "There are no dengue cases between " . $this->input->post('TPdatefrom-txt') . ' and ' . $this->input->post('TPdateto-txt') ;
			$data['barangay_form']  = $this->Cho_model->getAllBarangays();
			array_shift($data['barangay_form']);
		}
		$this->load->view('pages/view_dengue_profile.php' , $data);
		
		
	
	}

	}
	function view_pending_tasks()
	{	$this->redirectLogin();
		$this->load->model('Cho_model');
		$this->load->library('table');
		$data['title'] = 'View Pending Tasks';
		$data['script'] = 'view_casereport';
		$data2 = $this->Cho_model->get_pending_tasks();
		$data['table']= $data2['table'];
		$data['tasks']= $data2['task'];
		$data['options']= $this->Cho_model->get_bhw();
		$this->load->view('pages/view_pending_tasks.php' , $data);
	}
	
	function approve_tasks()
	{	$this->redirectLogin();
		$this->load->model('Cho_model');
		
		$taskno= explode ('/', $this->input->post('tasks'));
		for($s = 0 ; $s < count($taskno) - 1 ; $s++ )
		{
				$data = array(
						'task' => $taskno[$s],
						'status' =>  $this->input->post($taskno[$s])
				);
				$this->Cho_model->approve_task($data);
		}
		redirect('/CHO/view_pending_tasks/', 'refresh');
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
		$data['immediate_cases'] = $this->Cho_model->get_immediate_cases();
		
		//map
		
		$this->load->model('Mapping');
		$data['node_type'] = $this->input->post('NDtype-ddl');
		
		if ($this->form_validation->run('') == FALSE)
		{
			{
				if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
				{
					$date1=$this->input->post('YearStart-ddl').'-'.$this->input->post('MonthStart-ddl').'-'.'01';
					$date2=$this->input->post('YearEnd-ddl').'-'.$this->input->post('MonthEnd-ddl').'-'.'01';
					$date2=date('Y-m-t', strtotime($date2));
				}
				else
				{
					$date1=date('Y-m-01');
					$date2=date('Y-m-t');
				}
		
				//*DATE MANIPULATION BEGINS HERE
				//yyyy-mm-dd
				$data['date1']=$date1;
				$data['date2']=$date2;
		
				$dateData1['date1']=$date1;
				$dateData1['date2']=$date2;
		
				if($this->input->post('deflt')==1||strtoupper($_SERVER['REQUEST_METHOD']) != 'POST')
				{
					//*PREVIOUS DATE INTERVAL DATA PREPARATION
					$dateTemp1=explode("-",$date1);
					$dateTemp2=explode("-",$date2);
		
					$dateTemp1[0]=intval($dateTemp1[0]);
					$dateTemp2[0]=intval($dateTemp2[0]);
					if((($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]))==$date2))
					{
						$dateData2['date1']=($dateTemp1[0]-1)."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-1)."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					else
					{
						$dateData2['date1']=($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					//*/
				}
				else
				{
					$dateData2['date1']=$this->input->post('PYearStart-ddl').'-'.$this->input->post('PMonthStart-ddl').'-'.'01';
					$dateData2['date2']=$this->input->post('PYearEnd-ddl').'-'.$this->input->post('PMonthEnd-ddl').'-'.'01';
					$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
				}
		
				//echo $dateData2['date1']." to ".$dateData2['date2']." : ";
				//echo $dateData1['date1']." to ".$dateData1['date2'];
		
				//*CURRENT DATE INTERVAL DATA EXTRACTION
				$data['nodes'] = $this->Mapping->mapByType($data);
				$data['bage'] = $this->Mapping->getBarangayAges2($dateData1);
				$data['binfo'] = $this->Mapping->getBarangayInfo($dateData1);
				$data['bcount'] = $this->Mapping->getBarangayCount($dateData1);
				$data['dist'] = $this->Mapping->calculateDistanceFormula($dateData1);
				//*/
		
				$data['date1']=$dateData2['date1'];
				$data['date2']=$dateData2['date2'];
				$data['cdate1']=$dateData1['date1'];
				$data['cdate2']=$dateData1['date2'];
				$data['pdate1']=$dateData2['date1'];
				$data['pdate2']=$dateData2['date2'];
		
				//*PREVIOUS DATE INTERVAL DATA EXTRACTION
				$data['Pnodes'] = $this->Mapping->mapByType($data);
				$data['Pbage'] = $this->Mapping->getBarangayAges2($dateData2);
				$data['Pbinfo'] = $this->Mapping->getBarangayInfo($dateData2);
				$data['Pbcount'] = $this->Mapping->getBarangayCount($dateData2);
				$data['Pdist'] = $this->Mapping->calculateDistanceFormula($dateData2);
				//*/
				//-------------------*/
		
				$data['interest'] = $this->Mapping->getPointsOfInterest();
				$data['table1'] = $this->Mapping->getBarangayAges($dateData1);
				$data['table2'] = $this->Mapping->getBarangayAges($dateData2);
				//$data['test'] = $this->Mapping->getBarangayAgesS($data);
		
		
			}
		}
		
		
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
	function tweet()
	{	
		$this->load->library('twitteroauth');
		$this->load->model('Cho_model');
		if ($this->input->post('tweettype') == 'epi')
		{
			$month = date('m');
			$m = date("F",mktime(0,0,0,$month,1,2000));
			
			if ($this->input->post('epitype') == 'quartile')
			{
				$status = 'The Epidemic Threshold for the month of '.$m .' is at '. $this->input->post('tquartile') . '%.';
			}
			else if ($this->input->post('epitype') == 'csum')
			{
				$status = 'The Epidemic Threshold for the month of '.$m .' is at '. $this->input->post('tcsum') . '%.';
			}
			else if ($this->input->post('epitype') == 'mean2sd')
			{
				$status = 'The Epidemic Threshold for the month of '.$m .' is at '. $this->input->post('tm2sd2') . '%.';
			}
			else if ($this->input->post('epitype') == 'csum196sd')
			{
				$status = 'The Epidemic Threshold for the month of '.$m .' is at '. $this->input->post('tcsum196sd') . '%.';
			}
			
			$parameters = array(
					'status' => $status
			);
		}
		else if ($this->input->post('tweettype') == 'count')
		{
			$month = date('m');
			$m = date("F",mktime(0,0,0,$month,1,2000));
			$status = 'The current number of cases for the month of '.$m .' are '. $this->input->post('tcases') . ' cases.';
			$parameters = array(
					'status' => $status
			);
		}
		else if ($this->input->post('tweettype') == 'fact')
		{
			$msg = $this->Cho_model->randomfact();
			$parameters = array(
					'status' => $msg
			);
		}
		else if ($this->input->post('tweettype') == 'msg')
		{
			$parameters = array(
					'status' => $this->input->post('customtweet')
			);
		}
		$connection = $this->twitteroauth->create('QPMXQVU9lcpgt1bRUjLWg', 'eIR3yd9j3xxe1Y049xbyjVAm8ZFFn0URms6JvQQbbo', '1295280488-oODNE13B8QIxluzhf8e8RwhJFWsvlLsBGioSyzI', 'jlQOM6Xtmk6voAtuBZts2jUpvsvTUgk8cLOVYqPcQ');
		$content = $connection->get('account/verify_credentials');
		$result = $connection->post('statuses/update', $parameters);
		redirect('/CHO/dashboard/', 'refresh');
	}
	
	
	
	
	
}

/* End of file user/cho.php */
/* Location: ./application/controllers/user/cho.php */
