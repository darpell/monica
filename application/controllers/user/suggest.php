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
		$this->load->model('midwife');
		$this->load->model('notif');
		$this->load->model('master_list_model','masterlist');
		$this->load->model('investigate_cases_model','ic');
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

		//$Qdata['barangay']=array('SAN AGUSTIN III','SAMPAOC I');
		$Qdata['barangay']=null;
		$data['pendingTasks']=$this->suggest_model->get_tasks("Barangay Cleanup",$brgy);
		$data = array_merge($data,$this->Remap_model->getRepeatingLarvals($Qdata));
		$this->load->view('pages/view_suggested',$data);
	}
	function testimcase()
	{
	
		//$symptoms = $this->input->post('symptoms');
	
		//print_r($symptoms);
		$data['script']='';
		$data['title']='';
		$this->load->view('pages/testpageIM',$data);
	}
	function testsubmitimcase()
	{
		$data['script']='';
		$data['title']='';
		$this->masterlist->add_immediate_cases();
		$this->add_case_notif('imcase', $this->input->post('person_id'));
		$this->checkforbounceandred('imcase',$this->input->post('lat'),$this->input->post('lng'));
		$data['result'] = 'Your entry has been recorded';
		$this->load->view('pages/testpageIM',$data);
	}
	function testinv()
	{
	
		//$symptoms = $this->input->post('symptoms');
	
		//print_r($symptoms);
		$data['script']='';
		$data['title']='';
		$this->load->view('pages/testpageINV',$data);
	}
	function testsubmitinv()
	{
		$data['script']='';
		$data['title']='';
		$invcase = array(
						'patientno'	=>	$this->input->post('patient_no'),
						'lat' 		=>	$this->input->post('lat'),
						'lng' 		=>	$this->input->post('lng'),
						'feedback'	=>	$this->input->post('TPremarks-txt_r')
				);
				
				$this->ic->plot_case();
				$this->add_case_notif('invcase', $invcase['patientno']);
				$this->checkforbounceandred('invcase', $invcase['lat'],$invcase['lng']);
				
				$data['result'] = 'Your entry has been recorded';
				$this->load->view('pages/testpageINV',$data);
	}
	
	
	function testlarval()
	{
		$data['script']='';
		$data['title']='';
		$this->load->view('pages/testpageLARVAL',$data);
	}
	function testsubmitlarval()
	{
		$this->load->model('larval_survey');
		$data['script']='';
		$data['title']='';
			$data = array(
						'TPcreatedby-txt'		=>	$this->session->userdata('TPusername'),
						'TPcreatedon-txt' 		=>	date("Y-m-d H:i:s"),
						'TPlastupdatedby-txt' 	=> 	$this->session->userdata('TPusername'),
						'TPlastupdatedon-txt' 	=> 	date("Y-m-d H:i:s"),			
						'TPcontainer-txt' 		=> 	$this->input->post('TPcontainer-txt_r'),
						'TPhousehold-txt' 		=> 	$this->input->post('TPhousehold-txt_r'),
						'TPresult-rd' 			=>	'positive',
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
			$this->checkforbounceandred('larval', $this->input->post('lat'),$this->input->post('lng'));
			//redirect('mobile');
			$data['script']='';
			$data['title']='';

			$this->load->view('pages/testpageLARVAL',$data);
	}
	
	function add_case_notif($type,$id)
	{
		if ($type == 'imcase')
		{//chance to person_id
			$msg = 'New Immediate Case:';
		}
		else if($type == 'invcase')
		{//change to patient_no'
			$msg = 'Plotted Uninvestigated Case:';
		}
		$bhw_id =$this->session->userdata('TPusername');
		$barangay =  $this->midwife->get_barangay($bhw_id);
	
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$personid = $id;
		$data2 = array(
				'notif_type' => 1,
				'notification' => $msg,
				'unique_id' => $type.'-'.$personid,
				'notif_viewed' => 'N',
				'notif_createdOn' => Date('Y-m-d'),
				'notif_user' => $midwife,
		);
		$this->notif->addnotif($data2);
		if($type == 'invcase')
		{
			$data2 = array(
					'notif_type' => 1,
					'notification' => $msg,
					'unique_id' => $type.'-'.$personid,
					'notif_viewed' => 'N',
					'notif_createdOn' => Date('Y-m-d'),
					'notif_user' => 'CHO',
			);
			$this->notif->addnotif($data2);
		}
	}
	
	
	function checkforbounceandred($type,$lat,$lng)
	{
		//$type = 'invcase';
	
		if ($type =='larval')
		{$type = 'bouncelarval';
		$msg = 'Larval Positive';
		}
		else if ($type == 'imcase')
		{$type = 'bounceimcase';
		$msg = 'Immediate Case';
		}
		else
		{$type = 'bounceinvcase';
		$msg = 'Investigated Case';
		}
	
		$bhw_id =$this->session->userdata('TPusername');
		$barangay =  $this->midwife->get_barangay($bhw_id);
		//change this to barangay
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$bounce = [];
		$poi  = $this->notif->get_poi($barangay,'source');
	
		$lat_a= $lat * PI()/180;
		$long_a= $lng  * PI()/180;
		for($i = 0; $i < count($poi); $i++)
		{
		$lat_b = $poi[$i]['node_lat'] * PI()/180;
		$long_b = $poi[$i]['node_lng'] * PI()/180;
		$distance =
		acos(
		sin($lat_a ) * sin($lat_b) +
		cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
		) * 6371;
		$distance*=1000;
		if ($distance<=200)
		{
		$bounce[]=array(
		'node_name' => $poi[$i]['node_name'],
		'node_no' => $poi[$i]['node_no'],
		'node_lat' => $poi[$i]['node_lat'],
		'node_lng' => $poi[$i]['node_lng'],
				);
	
		}
		}
		if(count($bounce > 0))
		{
		$lat_a= [];
		$long_a= [];
	
		for($i = 0; $i < count($bounce); $i++)
			{	$id = $type.'-'.date('Y-m').'-'.$bounce[$i]['node_no'];
			if($this->notif->checknotifexist($id,$midwife))
			{
			$data2 = array(
					'notif_type' => 2,
					'notification' => $msg.' Found Near source area: '. $bounce[$i]['node_name'],
					'unique_id' => $type.'-'.date('Y-m').'-'.$bounce[$i]['node_no'],
					'notif_viewed' => 'N',
					'notif_createdOn' => Date('Y-m-d'),
													'notif_user' => $midwife,
					);
							$this->notif->addnotif($data2);
			
			}
			}
			$risk  = $this->notif->get_poi($barangay,'risk');
					$redrisk = [];
					for ($s = 0; $s < count($bounce); $s++)
			{
			$lat_a=$bounce[$s]['node_lat']* PI()/180;
			$long_a=$bounce[$s]['node_lng']* PI()/180;
	
			for($i = 0; $i < count($risk); $i++)
			{
			$lat_b = $risk[$i]['node_lat'] * PI()/180;
			$long_b = $risk[$i]['node_lng'] * PI()/180;
			$distance =
			acos(
			sin($lat_a ) * sin($lat_b) +
			cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
			) * 6371;
			$distance*=1000;
			if ($distance<=200)
			{
				$redrisk[]=array(
			'node_name' => $risk[$i]['node_name'],
			'node_no' => $risk[$i]['node_no'],
				'node_lat' => $risk[$i]['node_lat'],
			'node_lng' => $risk[$i]['node_lng'],
			);
			}
			}
			}
			if(count($redrisk) > 0)
			{
			for($i = 0; $i < count($redrisk); $i++)
			{	$id = 'red-'.date('Y-m').'-'.$redrisk[$i]['node_no'];
			if($this->notif->checknotifexist($id,$midwife))
			{
			$data2 = array(
					'notif_type' => 3,
					'notification' => 'Possible Source Area Found Near Risk Area: '. $redrisk[$i]['node_name'],
							'unique_id' => 'red-'.date('Y-m').'-'.$redrisk[$i]['node_no'],
							'notif_viewed' => 'N',
							'notif_createdOn' => Date('Y-m-d'),
							'notif_user' => $midwife,
									);
									$this->notif->addnotif($data2);
				
	
	}
	$id = 'redcho-'.date('Y-m').'-'.$redrisk[$i]['node_no'].'-'.$barangay;
	if($this->notif->checknotifexist($id,'CHO'))
	{
	$data2 = array(
	'notif_type' => 3,
	'notification' => $barangay.': Possible Source Area Found Near Risk Area: '. $redrisk[$i]['node_name'],
	'unique_id' => 'redcho-'.date('Y-m').'-'.$redrisk[$i]['node_no'].'-'.$barangay,
	'notif_viewed' => 'N',
									'notif_createdOn' => Date('Y-m-d'),
										'notif_user' => 'CHO',
							);
							$this->notif->addnotif($data2);

	}
	}
	}
		
			}
	
	}
}

/* End of file suggest.php */
/* Location: ./application/controllers/suggest.php */