<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_list extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('midwife','masterlist');
		$this->load->model('Cho_model','Cho_model');
		$this->load->model('suggest_model');
		$this->load->model('notif');
		$this->load->model('larval_mapping');
		$this->load->model('remap_model');
		$this->load->library('table');
	}
	
	function index()
	{
		$this->redirectLogin();
	}
	
	function redirectLogin()
	{	$this->load->library('mobile_detect');
	if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
	{
		$this->load->view('mobile/index.php');
	}
	elseif ($this->session->userdata('logged_in') != TRUE || $this->session->userdata('TPtype') == 'CHO' ){
		$this->session->sess_destroy();
		redirect(substr(base_url(), 0, -1) . '/index.php/login');
	}
	}
	function formatnotifs()
	{
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
			$link  = "<a href='" . base_url('index.php/master_list/viewnotif/').'/'.$temp[$i]['notif_id']. "'><img src='".base_url('/images/left_nav_arrow.gif')."'>";
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
	{ 	
		$bhw_id =$this->session->userdata('TPusername');
		$id = $this->uri->segment(3, 0);
		$this->notif->view_notif($id);
		$this->view_household_midwife();	
		
	}
	function checkforbounceandred($type)
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
		else if ($type == 'inv')
		{$type = 'bounceinvcase';
		$msg = 'Investigated Case';
		}
		
		$bhw_id =$this->session->userdata('TPusername');
		$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
		//change this to barangay
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$bounce = [];
		$poi  = $this->notif->get_poi($barangay,'source');
		
		$lat_a= 14.275500 * PI()/180;
		$long_a= 120.934998  * PI()/180;
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
				print('new ');
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
								print('newred ');
						
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
						print('newredcho ');
					}
				}				
			}
			
		} 
	
	}
	function test()
	{
		$this->add_case_notif('imcase','asdasdasdasdad' );
		$this->checkforbounceandred('larval');
		print('new');
		$data = $this->notif->getnotifs($this->session->userdata('TPusername'));
		print_r($data);
		
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
		$barangay =  $this->masterlist->get_barangay($bhw_id);
		
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$personid = 1;
		$data2 = array(
				'notif_type' => 1,
				'notification' => $msg,
				'unique_id' => $type.'-'.$personid,
				'notif_viewed' => 'N',
				'notif_createdOn' => Date('Y-m-d'),
				'notif_user' => $midwife,
		);
		$this->notif->addnotif($data2);
	}
	function check_prev_case_notif()
	{
		$bhw_id =$this->session->userdata('TPusername');
		$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
		$data = $this->masterlist->get_cases($barangay);
		if(($data[date('Y')] > $data[date('Y')-1]))
		{
			$id='highcase-'.date('Y-m');
			if ($this->notif->checknotifexist($id,$bhw_id))
			{
				$data2 = array(
						'notif_type' => 2,
						'notification' => 'current number of dengue cases xceeded the previous cases from last year',
						'unique_id' => $id,
						'notif_viewed' => 'N',
						'notif_createdOn' => Date('Y-m-d'),
						'notif_user' => $bhw_id,
				
				);
				$this->notif->addnotif($data2);
			}
		}
	}

	function view_household_bhw()
	{
		$this->redirectLogin();
		$data['title'] = 'Masterlist';
		$data['script'] = 'view_casereport';
		
		$data['selected'] = '0';
		$bhw_id =$this->session->userdata('TPusername');
		
		$this->form_validation->set_rules('TPhousehold-txt', 'Household', 'required');
		$this->form_validation->set_rules('TPhouseno-txt', 'House No', 'required');
		$this->form_validation->set_rules('TPstreet-txt', 'Street', 'required');
		
		$this->form_validation->set_rules('TPname-txt', 'First Name', 'required');
		$this->form_validation->set_rules('TPlname-txt', 'Last Name', 'required');
		$this->form_validation->set_rules('TPbirthdate-txt', 'Birthday', 'required');
		$this->form_validation->set_rules('TPstatus-txt', 'Marital Status', 'required');
		$this->form_validation->set_rules('TPnation-txt', 'Nationality', 'required');
		
		
		if ($this->form_validation->run('') == FALSE)
		{
			$data['households'] = $this->masterlist->get_households($bhw_id);
			$data['masterlist'] = $this->masterlist->get_masterlist($bhw_id);
			
			$this->load->view('pages/view_masterlist_bhw', $data);
		}
		else 
		{
			$household=$this->input->post('TPhousehold-txt');
			$houseno=$this->input->post('TPhouseno-txt');
			$street= $this->input->post('TPstreet-txt');
			$date = $this->input->post('TPbirthdate-txt');
			$date= explode ('/', $date);
			$data2 = array(
					'person_first_name' => $this->input->post('TPname-txt'),
					'person_last_name' => $this->input->post('TPlname-txt') ,
					'person_dob' => $date[2].'-'.$date[0].'-'.$date[1],
					'person_sex' => $this->input->post('TPsex-dd'),
					'person_marital' => $this->input->post('TPstatus-txt'),
					'person_nationality' => $this->input->post('TPnation-txt'),
					'person_blood_type' => $this->input->post('TPblood-dd'),
					
			);
				
			
			$this->add_masterlist_and_household($household,$houseno,$street,$bhw_id,$data2);
			
			redirect('/master_list/view_household_bhw/', 'refresh');
		}
		
		
	}
	function view_patient()
	{	$this->redirectLogin();
	$this->load->model('case_report');
	$data['patientno'] = $this->uri->segment(3,"");
	
	/* css */
	$data['base'] = $this->config->item('base_url');
	$data['css'] = $this->config->item('css');
	$data['title'] = 'Update patient';
	
	
	//scripts if none keep ''
	$data['script'] = 'view_casereport';
	
	//for table result for search
	$data['info'] = $this->case_report->getPatientInfo($data);
	
	/** Validation rules could be seen at application/config/form_validation.php **/
	if ($this->form_validation->run('') == FALSE)
	{
		$this->load->library('table');
		$this->load->view('pages/view_patient',$data);
	}
	}
	
	function view_immediate_case()
	{	$this->redirectLogin();

	$data['person'] = $this->uri->segment(3,"");
	$data['case'] = $this->uri->segment(4,"");
	
	/* css */
	$data['base'] = $this->config->item('base_url');
	$data['css'] = $this->config->item('css');
	$data['title'] = 'Update patient';
	
	
	//scripts if none keep ''
	$data['script'] = 'view_casereport';
	
	//for table result for search
	$data['person'] = $this->masterlist->get_immediate_case($data['person'],$data['case']);
	
	/** Validation rules could be seen at application/config/form_validation.php **/
	if ($this->form_validation->run('') == FALSE)
	{
		$this->load->library('table');
		$this->load->view('pages/view_immediate_case',$data);
	}
	}
	function delete_person()
	{	$this->redirectLogin();
	
	$data['person'] = $this->uri->segment(3,"");
	
	/* css */
	$data['base'] = $this->config->item('base_url');
	$data['css'] = $this->config->item('css');
	$data['title'] = 'Update patient';
	
	
	//scripts if none keep ''
	$data['script'] = 'view_casereport';
	
	//for table result for search
	$data['person'] = $this->masterlist->delete_person($data['person']);
	
	redirect('/master_list/view_household_midwife/', 'refresh');
	}
	function update_immediate_case()
	{	$this->redirectLogin();
	
		
		$imcase_no = $this->input->post('imcase_no');
		$data = array(
				'status'			=> $this->input->post('status'),
				'person_id'			=> $this->input->post('person_id'),
				'has_muscle_pain'	=> $this->input->post('musclepain'),
				'has_joint_pain'	=> $this->input->post('jointpain'),
				'has_headache'		=> $this->input->post('headache'),
				'has_bleeding'		=> $this->input->post('bleeding'),
				'has_rashes'		=> $this->input->post('rashes'),
				'days_fever'		=>$this->input->post('daysoffever'),
				'remarks'			=> $this->input->post('remarks'),
				'last_updated_on'   => date('Y-m-d'),
		);
		
		$this->masterlist->update_immediate_case($data,$imcase_no);

		$data['title'] = 'Masterlist';
		$data['script'] = 'view_casereport';
		$this->load->view('pages/success', $data);
	}
	
	
	
	function view_household_midwife()
	{	
		
		$this->redirectLogin();
		$data['title'] = 'Masterlist';
		$data['script'] = 'view_casereport';
	
		$data['selected'] = '0';
		$bhw_id =$this->session->userdata('TPusername');
	
		$this->form_validation->set_rules('TPhousehold-txt', 'Household', 'required');
		$this->form_validation->set_rules('TPhouseno-txt', 'House No', 'required');
		$this->form_validation->set_rules('TPstreet-txt', 'Street', 'required');
	
		$this->form_validation->set_rules('TPname-txt', 'First Name', 'required');
		$this->form_validation->set_rules('TPlname-txt', 'Last Name', 'required');
		$this->form_validation->set_rules('TPbirthdate-txt', 'Birthday', 'required');
		$this->form_validation->set_rules('TPstatus-txt', 'Marital Status', 'required');
		$this->form_validation->set_rules('TPnation-txt', 'Nationality', 'required');
	
	
		if ($this->form_validation->run('') == FALSE)
		{
	
			$data['households'] = $this->masterlist->get_households(false,$bhw_id);
			$data['masterlist'] = $this->masterlist->get_masterlist(false,$bhw_id);
			$data['cases'] = $this->masterlist->get_immediate_cases($bhw_id);
			$data['bhwdd']= $this->Cho_model->get_bhw();
			$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
			$data['confirmedcases'] = $this->masterlist->get_con_immediate_cases($bhw_id);
			$temp =$data['households'];
			for($i = 0; $i < count($temp); $i++)
			{
				$x = $temp[$i]['bhw_id']; 
				$data['catchment'][$x][] = array(
						'Name' => $temp[$i]['household_name'],
						'House no' => $temp[$i]['house_no'],
						'street' => $temp[$i]['street'],
						'last visited' => $temp[$i]['last_visited'],
						);
				$data['bhw'][$x] = $temp[$i]['user_firstname'] . ' '. $temp[$i]['user_lastname'] ;
			
			}
			$data['uninvest'] = $this->suggest_model->get_cases($barangay, date('Y-m-01'), date('Y-m-d'));
			$data['bhwdd']= $data['bhwdd'][$barangay];
			$mapdata = $this-> remap($barangay);
			$data = array_merge($data,$mapdata);
print($barangay);

			$data['notif'] = $this->formatnotifs();
			$data['cleanup'] = $this->notif->get_cleanup($bhw_id);
			$this->load->view('pages/view_masterlist_midwife', $data);
		}
		else
		{
			$household=$this->input->post('TPhousehold-txt');
			$houseno=$this->input->post('TPhouseno-txt');
			$bhw_id=$this->input->post('TPbhw-dd');
			$street= $this->input->post('TPstreet-txt');
			$date = $this->input->post('TPbirthdate-txt');
			$date= explode ('/', $date);
			$data2 = array(
					'person_first_name' => $this->input->post('TPname-txt'),
					'person_last_name' => $this->input->post('TPlname-txt') ,
					'person_dob' => $date[2].'-'.$date[0].'-'.$date[1],
					'person_sex' => $this->input->post('TPsex-dd'),
					'person_marital' => $this->input->post('TPstatus-txt'),
					'person_nationality' => $this->input->post('TPnation-txt'),
					'person_blood_type' => $this->input->post('TPblood-dd'),
						
			);
	
				
			$this->add_masterlist_and_household($household,$houseno,$street,$bhw_id,$data2);
				
		}
	
	
	}
	function addcleanup()
	{
	
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('conduct', 'Date to be conducted', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
		
		}
		else
		{
			$midwife =$this->session->userdata('TPusername');
			$task  = $this->input->post('description');
			$date  = $this->input->post('conduct');
			$date = explode('/', $date);
			$date = $date[2].'-'.$date[0].'-'.$date[1];
			$this->notif->add_cleanup($midwife,$date,$task);
		}
		$this->view_household_midwife();
	}
	function add_masterlist_and_household($household,$houseno,$street,$bhw_id,$data)
	{
	
		
		
		$houseid = $this->masterlist->add_household($household,$houseno,$street);
		$person_id = $this->masterlist->add_masterlist($data);
		 $this->masterlist->add_catchment_area($houseid,$person_id,$bhw_id);
		
		
	}
	function add_masterlist_bhw()
	{
		$this->redirectLogin();
		$data['title'] = 'Masterlist';
		$data['script'] = 'view_casereport';
		
		$bhw_id =$this->session->userdata('TPusername');

		
		$house_id=$this->input->post('house_id');
		$data['selected'] ='ctr'.$house_id;
		$data['selected'] =$this->input->post($data['selected']);
		
		$this->form_validation->set_rules('TPname-txt'.$house_id, 'First Name', 'required');
		$this->form_validation->set_rules('TPlname-txt'.$house_id, 'Last Name', 'required');
		$this->form_validation->set_rules('TPbirthdate-txt'.$house_id, 'Birthday', 'required');
		$this->form_validation->set_rules('TPstatus-txt'.$house_id, 'Marital Status', 'required');
		$this->form_validation->set_rules('TPnation-txt'.$house_id, 'Nationality', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
	

		}
		
		else
		{
			$date = $this->input->post('TPbirthdate-txt'.$house_id);
			$date= explode ('/', $date);
			$data2 = array(
					'person_first_name' => $this->input->post('TPname-txt'.$house_id),
					'person_last_name' => $this->input->post('TPlname-txt'.$house_id) ,
					'person_dob' => $date[2].'-'.$date[0].'-'.$date[1],
					'person_sex' => $this->input->post('TPsex-dd'.$house_id),
					'person_marital' => $this->input->post('TPstatus-txt'.$house_id),
					'person_nationality' => $this->input->post('TPnation-txt'.$house_id),
					'person_blood_type' => $this->input->post('TPblood-dd'.$house_id),
						
			);
			
			$person_id = $this->masterlist->add_masterlist($data2);
			$this->masterlist->add_catchment_area($house_id,$person_id,$bhw_id);
		}
		$data['households'] = $this->masterlist->get_households($bhw_id);
		$data['masterlist'] = $this->masterlist->get_masterlist($bhw_id);
		$data['bhwdd']= $this->Cho_model->get_bhw();
		$this->load->view('pages/view_masterlist_bhw', $data);
	
	}
	function add_masterlist_midwife()
	{
		$this->redirectLogin();
		$data['title'] = 'Masterlist';
		$data['script'] = 'view_casereport';
	
		$bhw_id =$this->session->userdata('TPusername');
	
	
		$house_id=$this->input->post('house_id');
		$data['selected'] ='ctr'.$house_id;
		$data['selected'] =$this->input->post($data['selected']);
	
		$this->form_validation->set_rules('TPname-txt'.$house_id, 'First Name', 'required');
		$this->form_validation->set_rules('TPlname-txt'.$house_id, 'Last Name', 'required');
		$this->form_validation->set_rules('TPbirthdate-txt'.$house_id, 'Birthday', 'required');
		$this->form_validation->set_rules('TPstatus-txt'.$house_id, 'Marital Status', 'required');
		$this->form_validation->set_rules('TPnation-txt'.$house_id, 'Nationality', 'required');
	
		if ($this->form_validation->run('') == FALSE)
		{
	
	
		}
	
		else
		{
			$date = $this->input->post('TPbirthdate-txt'.$house_id);
			$date= explode ('/', $date);
			$data2 = array(
					'person_first_name' => $this->input->post('TPname-txt'.$house_id),
					'person_last_name' => $this->input->post('TPlname-txt'.$house_id) ,
					'person_dob' => $date[2].'-'.$date[0].'-'.$date[1],
					'person_sex' => $this->input->post('TPsex-dd'.$house_id),
					'person_marital' => $this->input->post('TPstatus-txt'.$house_id),
					'person_nationality' => $this->input->post('TPnation-txt'.$house_id),
					'person_blood_type' => $this->input->post('TPblood-dd'.$house_id),
					'person_contactno' => $this->input->post('TPcontact-txt'.$house_id),
	
			);
				
			$person_id = $this->masterlist->add_masterlist_midwife($house_id,$data2);
			//$this->masterlist->add_catchment_area($house_id,$person_id,$bhw_id);
		}
		$data['households'] = $this->masterlist->get_households(false,$bhw_id);
		$data['masterlist'] = $this->masterlist->get_masterlist(false,$bhw_id);
		$data['bhwdd']= $this->Cho_model->get_bhw();
		$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
		$data['bhwdd']= $data['bhwdd'][$barangay];
		$this->view_household_midwife();
	
	}
	public function remap($barangay)
	{
		//global variables
		$overlays = [];
	
			// setting dates
			$data['begin_date'] = date("Y-m") . '-01';
			//$data['begin_date'] = date("Y") . '-08-01';
			$data['end_date'] = date("Y-m-d");
			$data['b_date'] = date("Y") . ', '.date('m').', 1';
			//$data['b_date'] = date("Y") . ', 8, 1';
			$data['e_date'] = date("Y,m,d");
		
	
	
		//$begin_date = date("Y") . '-01-01';//date("Y-m-d H:i:s");
		//$current_date = date("Y-m-d");
		$dates['date1']=$data['begin_date'];//echo $data['begin_date']." END ";
		$dates['date2']=$data['end_date'];//echo $data['end_date']." END ";
		$temp['dateSel1']=$data['begin_date'];
		$temp['dateSel2']=$data['end_date'];
		$temp['barangay']=$barangay;
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
	
		print_r($bgy);
		// investigated cases
		//$data['investigatedCases'] = ;
	
		$denguetemp = array();
		$denguetemp = $this->remap_model->investigated_cases($temp);
		
		// new code
		$immediatetemp = $this->remap_model->immediate_cases($temp);
		
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
		//new code
		$data['data_exists2']=$immediatetemp['data_exists'];
		if($denguetemp['data_exists']==1)
			$data['dataCases']=$denguetemp['dataCases'];
		if($immediatetemp['data_exists']==1)
			$data['dataImmediateCases']=$immediatetemp['dataCases'];
		
	//	if($denguetemp['data_exists']==1)
	//		$data['dataCases']=$denguetemp['dataCases'];\
	
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
	
	
	function view_person()
	{
		$param = $this->uri->uri_to_assoc(3);
		$household_id = $param['household'];
		$person_id = $param['person'];
		
		$data['household_persons'] = $this->masterlist->get_households($this->session->userdata('TPusername'),$household_id,$person_id);
		$this->load->view('mobile/person_details_view', $data);
	}
}

/* End of file mobile/master_list.php */
/* Location: ./application/controllers/master_list.php */