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
	$this->load->model('Remap_model');
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
		$data['error']='';
		$dateto= explode ('/', $this->input->post('TPdateto-txt'));
		$datefrom= explode ('/', $this->input->post('TPdatefrom-txt'));
		$data['dateto'] =  $dateto[2].'/'.$dateto[0].'/'.$dateto[1];
		$data['datefrom'] =  $datefrom[2].'/'.$datefrom[0].'/'.$datefrom[1];
		$data['barangay'] = $this->input->post('barangay');
		print_r($data['barangay']);
		
		
		
		$data['dateSel1']=$data['datefrom'];
		$data['dateSel2']=$data['dateto'];
		$data['mapvalues'] = $this->Remap_model->investigated_casesArray($data);
		$data['tablecases'][]=array(
				'ic_fname'=> 'Name',
				'ic_age'=> 'Age',
				'ic_sex'=> 'Gender',
				'ic_outcome'=> 'Outcome',
				'ic_street'=> 'Street',
				'ic_barangay'=> 'Barangay',
				'ic_dateOnset'=> 'Date Onset',
				'ic_feedback'=> 'Feedback',
		);
		if(array_key_exists('dataCases', $data['mapvalues']))
		{
		for($i = 0; $i< count($data['mapvalues']['dataCases']); $i++)
		{
			
			$data['tablecases'][]=array(
					'ic_fname'=>  $data['mapvalues']['dataCases'][$i]['ic_lname'] . ', '. $data['mapvalues']['dataCases'][$i]['ic_fname'],
					'ic_age'=> $data['mapvalues']['dataCases'][$i]['ic_age'],
					'ic_sex'=> $data['mapvalues']['dataCases'][$i]['ic_sex'],
					'ic_outcome'=> $data['mapvalues']['dataCases'][$i]['ic_outcome'],
					'ic_street'=> $data['mapvalues']['dataCases'][$i]['ic_street'],
					'ic_barangay'=> $data['mapvalues']['dataCases'][$i]['ic_barangay'],
					'ic_dateOnset'=> $data['mapvalues']['dataCases'][$i]['ic_dateOnset'],
					'ic_feedback'=> $data['mapvalues']['dataCases'][$i]['ic_feedback'],
			);
		}
		}
		$data['total_text'] = 0;
		$data['date_to_text'] = $this->input->post('TPdateto-txt');
		$data['date_from_text'] = $this->input->post('TPdatefrom-txt');
		$data['f_text'] = 0;
		$data['m_text'] = 0;
		$data['agegroup_text'][0] = 0;
		$data['agegroup_text'][1] = 0;
		$data['agegroup_text'][2] = 0;
		$data['agegroup_text'][3] = 0;
		$data['agegroup_text'][4] = 0;
		$data['yeartotal_text'] = array();
		$data['bartotal_text'] = array();
		
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
			$data['yeartotal_text'][$year]=0;
		}
		$data['values_total'] .=  "%%";
		$data['values_gender'] .=  "%%";
		
		foreach ($data2['barangay'] as $barangay)
		{	$data['values_total'] .= $barangay . "&&";
			$data['values_gender'] .= $barangay . "&&";
			$data['values_age'] .= $barangay . "##";
			$data['barangay_list'] .= $barangay . "&&";
			$data['bartotal_text'][$barangay] = 0;
			
			
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
					$data['f_text'] +=   $data2['values'][$year][$barangay]['F'][$s];
					$data['m_text'] +=   $data2['values'][$year][$barangay]['M'][$s];
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
				
				$data['total_text'] += $data2['total'][$year][$barangay];
				
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
				

				$data['agegroup_text'][0] += $data2['values'][$year][$barangay]['M'][0] +  $data2['values'][$year][$barangay]['F'][0];
				$data['agegroup_text'][1] += $data2['values'][$year][$barangay]['M'][1] + $data2['values'][$year][$barangay]['F'][1];
				$data['agegroup_text'][2] += $data2['values'][$year][$barangay]['M'][2] + $data2['values'][$year][$barangay]['F'][2];
				$data['agegroup_text'][3] += $data2['values'][$year][$barangay]['M'][3] + $data2['values'][$year][$barangay]['F'][3];
				$data['agegroup_text'][4] += $data2['values'][$year][$barangay]['M'][4] + $data2['values'][$year][$barangay]['F'][4];
				
				$data['yeartotal_text'][$year] += $male + $female ;
				
				$data['bartotal_text'][$barangay] += $male + $female ;
			
			
			}
			$data['values_total'] .=  "%%";
			$data['values_gender'] .=  "%%";
		
		}
		
		$data['agegroup_text2']= array_keys($data['agegroup_text'], max($data['agegroup_text']));
		
		$data['yeartotal_text2'] = array_keys($data['yeartotal_text'], max($data['yeartotal_text']));
		
		$data['bartotal_text2'] = array_keys($data['bartotal_text'], max($data['bartotal_text']));
		
		$temp = $data['values_total'];
		$temp = explode('%%',$data['values_total']);
		array_pop($temp);
		
		
		$temp2 = Array();
		for ( $i = 0; $i < count($temp); $i++)
		{
		$temp2[$i] =  explode('&&',$temp[$i]);
		array_pop($temp2[$i]);
		}
		
		$outbreak = null;
		for ( $i = 1; $i < count($temp2); $i++)
		{
			if(count($temp2[$i])>2)
			{
				for($s = 1; $s < count($temp2[$i])-1; $s++)
				{	$d = $s;
					if( $s != count($temp2[$i]))
					{
						$d++;
					}
					if($temp2[$i][$s] < $temp2[$i][$d] )
					{
						$outbreak[] = $temp2[$i][0];
					}
					
				}	
			}
		}
		//print_r($outbreak);
		$this->load->model('notif');
		$data2 = array(
				'notif_type' => 2,
				'notification' => 'current number of dengue cases exceeded the previous cases from last year',
				'unique_id' => '1',
				'notif_viewed' => 'N',
				'notif_createdOn' => Date('Y-m-d'),
				'notif_user' => 'CHO',
					
		);
			
		$this->notif->addnotif($data2);
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
		$this->load->model('larval_mapping');
		$this->load->model('Remap_model');
		$this->load->model('midwife','masterlist');
		$this->load->model('notif');
		
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
		
		$data['larval']='';
		
		$data['immediate_cases'] = $this->Cho_model->get_immediate_cases();
		
		$data['dateSel1']=date('Y-m').'-01';
		$data['dateSel2']=date('Y-m-d');
		//$data['dateSel2']='2013-08-31';
		$data['barangay'] = null;
		$data['mapvalues'] = $this->Remap_model->investigated_cases($data);
		//print_r($data['mapvalues']);
		$data['tablecases'][]=array(
				'ic_fname'=> 'Name',
				'ic_age'=> 'Age',
				'ic_sex'=> 'Gender',
				'ic_outcome'=> 'Outcome',
				'ic_street'=> 'Street',
				'ic_barangay'=> 'Barangay',
				'ic_dateOnset'=> 'Date Onset',
				'ic_feedback'=> 'Feedback',
		);
		if(array_key_exists('dataCases', $data['mapvalues']))
		{
		for($i = 0; $i< count($data['mapvalues']['dataCases']); $i++)
		{
		
		$data['tablecases'][]=array(
				'ic_fname'=>  $data['mapvalues']['dataCases'][$i]['ic_lname'] . ', '. $data['mapvalues']['dataCases'][$i]['ic_fname'],
					'ic_age'=> $data['mapvalues']['dataCases'][$i]['ic_age'],
					'ic_sex'=> $data['mapvalues']['dataCases'][$i]['ic_sex'],
					'ic_outcome'=> $data['mapvalues']['dataCases'][$i]['ic_outcome'],
					'ic_street'=> $data['mapvalues']['dataCases'][$i]['ic_street'],
					'ic_barangay'=> $data['mapvalues']['dataCases'][$i]['ic_barangay'],
					'ic_dateOnset'=> $data['mapvalues']['dataCases'][$i]['ic_dateOnset'],
					'ic_feedback'=> $data['mapvalues']['dataCases'][$i]['ic_feedback'],
			);
		}
		}
		$this->load->library('table');
		$data['notif'] = $this->formatnotifs();
		
		
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
		$date = date("n");
		$x= ($data['arranged'][5][$date] / $epidemic['quartile'][$date])*100;
		$data['percent_text']=round($x, 2);
		$data['diff_text']= ($data['arranged'][5][$date] - $epidemic['quartile'][$date]);
		$data['bar_text']=$data['parameter'];
		$data['barangay'] = $this->Cho_model->getAllBarangays();
		
		
		
		//alerts
		$data['alerts'] = null;
		for ($i = 1; $i < count($data['arranged'])-1;$i++)
		{
			for ($s = 1; $s < count($data['arranged'][$i])-1;$s++)
			{
				//echo $data['arranged'][$i][$s].'VS' . $data['arranged'][5][$s] . '<br />';
				if($data['arranged'][$i][$s] <= $data['arranged'][5][$s])
				{ $data['alerts'][$data['arranged'][$i]['epidemic']][] = 'Epidemic Threshold('.$data['arranged'][$i]['epidemic'] .') Exceeded During The Month Of <b>'
					.$data['arranged'][0][$s].' (' . ($data['arranged'][5][$s] - $data['arranged'][$i][$s]) . ' Cases)</b><br />';
				
				}
			}
			
		}
		
		//print_r($data['alerts']);
		
		
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
	
	function tweet_info()
	{
		$this->redirectLogin();
		$this->load->model('Cho_model');
		$data['script'] = '';
		$count = $this->Cho_model->get_immediate_cases();
		$count = explode("%%", $count);
		$count = count($count);
		$data['fact'] = $this->Cho_model->randomfact();
		$data['total']='The current number of cases for the month of '. date('F') .' are '. $count . ' cases.';
		$this->load->view('pages/tweet.php' , $data);
		
	}
	public function remap($barangay = null)
	{
		//global variables
	
		$overlays = [];
	
		// setting dates
		//$data['begin_date'] = date("Y-m") . '-01';
		$data['begin_date'] = date("Y-m") . '-01';
		$data['end_date'] = date("Y-m-d");
		//$data['b_date'] = date("Y") . ', '.date('m').', 1';
		$data['b_date'] = date("Y") . ', '.date('m').', 1';
		$data['e_date'] = date("Y,m,d");
	
	
	
		//$begin_date = date("Y") . '-01-01';//date("Y-m-d H:i:s");
		//$current_date = date("Y-m-d");
		$dates['date1']=$data['begin_date'];//echo $data['begin_date']." END ";
		$dates['date2']=$data['end_date'];//echo $data['end_date']." END ";
		$temp['dateSel1']=$data['begin_date'];
		$temp['dateSel2']=$data['end_date'];
		$loc=null;
		$bgy=null;
		//
		$bgy=$barangay;/*
		if($this->input->post('barangay')!=null)//*/
		{
			$loc='brgy';
			//$bgy=$this->input->post('barangay');
		}
		$temp['barangay']=$bgy;
	
		// larval points
		$data['larvalPositives'] = $this->larval_mapping->get_points($data['begin_date'], $data['end_date'],$loc,$bgy);
	
		// risk nodes
		$data['pointsOfInterest'] = $this->remap_model->get_map_nodes($data['begin_date'], $data['end_date'],$loc,$bgy);
	
		//print_r($data['pointsOfInterest']);
		// investigated cases
		//$data['investigatedCases'] = ;
	
		$denguetemp = array();
		$denguetemp = $this->remap_model->investigated_cases($temp);
		$bouncetemp = $this->remap_model->getCaseDistancePoI($denguetemp,$data['pointsOfInterest'],$data['larvalPositives']);
		//print_r($data['larvalPositives']);
		//print_r($bouncetemp);
		$i=0;
		$NewArray = array();
		foreach($data['pointsOfInterest'] as $value) {
			$NewArray[] = array_merge($value,$bouncetemp['bounceInfo'][$i]);
			$i++;
		}//print_r($bouncetemp['countInfo']);
		//print_r($NewArray);
		$data['data_exists']=$denguetemp['data_exists'];
		if($denguetemp['data_exists']==1)
			$data['dataCases']=$denguetemp['dataCases'];
		$data['pointsOfInterest']=$NewArray;//print_r($data['pointsOfInterest']);
		$sourceTable[]=array(
				0=>"Name",
				1=>"Notes",
				2=>"Barangay",
				3=>"Larvae<br/>within<br/>200m",
				4=>"Dengue Cases<br/>within<br/>200m"
		);
		$riskTable[]=array(
				0=>"Name",
				1=>"Notes",
				2=>"Barangay",
				3=>"Larvae<br/>within<br/>200m",
				4=>"Sources<br/>in alert<br/>within<br/>200m"
		);
		foreach($data['pointsOfInterest'] as $key => $value)
		{
			if($bgy ==$value['node_barangay'] &&($bouncetemp['countInfo'][$key]['0'] > 0) || $bouncetemp['countInfo'][$key]['1'] >0 )
			{
				if($value['node_type']==0)
				{
					$sourceTable[]=array(
							0=>$value['node_name'],
							1=>$value['node_notes'],
							2=>$value['node_barangay'],
							3=>$bouncetemp['countInfo'][$key]['0'],
							4=>$bouncetemp['countInfo'][$key]['1']
					);
				}
				else
				{
					$riskTable[]=array(
							0=>$value['node_name'],
							1=>$value['node_notes'],
							2=>$value['node_barangay'],
							3=>$bouncetemp['countInfo'][$key]['0'],
							4=>$bouncetemp['countInfo'][$key]['1']
					);
				}
			}
		}
		$data['sourceTable']=$sourceTable;
		$data['riskTable']=$riskTable;
		//polygon nodes
		$data['polygon_nodes'] = $this->remap_model->get_polygon_nodes($bgy);
		$data['larval_array'] = $this->remap_model->getLarvalCount($data['begin_date'], $data['end_date'],$loc,$bgy);
		//ages (Returns an array, code found in the function "getBarangayAges")
		$data['ages_array'] = $this->remap_model->getBarangayAges($dates);//print_r($data['ages_array']);
		$data['dengue_array'] = $this->remap_model->getDengueInfo($dates);//print_r($data['dengue_array']);
		//$data['PoI_distance_array'] = $this->larval_mapping->distance_formula_PoI($dates);//print_r($data['PoI_distance_array']);
		$data['brgys'] = $this->remap_model->get_brgy_with_cases($data['begin_date'], $data['end_date']);
		$this->load->library('table');
		array_merge($data);
		return $data;
	}
	function formatnotifs()
	{		$this->load->model('notif');
		$temp = $this->notif->getnotifs($this->session->userdata('TPusername'));
		$data = [];
		
		for($i  = 0; $i < count($temp);$i++)
		{	
			if ($temp[$i]['notif_type'] == 1)
			$img = "<img src='".base_url('/images/notice.png')."'>";
			else if ($temp[$i]['notif_type'] == 2)
			$img = "<img src='".base_url('/images/mosquito.png')."'>";
			else if ($temp[$i]['notif_type'] == 3)
			$img = "<img src='".base_url('/images/group-2.png')."'>";
			
			$temptype = explode('-',$temp[$i]['unique_id']);
			if($temptype[0] == 'invcase' ||$temptype[0]  =='imcase' ||$temptype[0]  =='newcase')
			$name = $this->notif->get_case($temptype[0],$temptype[1]);
			else 
			$name = '';
			$link  = "<a href='" . base_url('index.php/CHO/viewnotif/').'/'.$temp[$i]['notif_id']. "'><img src='".base_url('/images/left_nav_arrow.gif')."'>";
			$data[]= array(
					'type' => $img,
					'notif' => $temp[$i]['notification'] .' '. $name,
					'date' => $temp[$i]['notif_createdOn'],
					'view' => $link,
					);
			$img = null;
		}
		return $data;
	}
	function viewnotif()
	{ 	$this->load->model('notif');
		$id = $this->uri->segment(3, 0);
		$this->notif->view_notif($id);
		$this->dashboard();	
	}
	
	
	
}

/* End of file user/cho.php */
/* Location: ./application/controllers/user/cho.php */
