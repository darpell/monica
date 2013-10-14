<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_list extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('master_list_model','masterlist');
		$this->load->model('midwife');
		$this->load->model('notif');
	}
	
	function index()
	{
		//$data['result'] = '';
		//$data['tasks'] = $this->tasks->get_tasks($this->session->userdata('TPusername'));
		//$this->load->view('mobile/tasks.php', $data);
		
		//$data['subjects'] = $this->masterlist->get_list($this->session->userdata('TPusername'));
		$data['subjects'] = $this->masterlist->get_households($this->session->userdata('TPusername'));
		$this->load->view('mobile/master_list', $data);
	}

	function view_household($household_id)
	{
		$data['household_persons'] = $this->masterlist->get_households($this->session->userdata('TPusername'),$household_id);
		$this->load->view('mobile/master_list_view', $data);
	}
	
	function view_person()
	{
		$param = $this->uri->uri_to_assoc(3);
		$household_id = $param['household'];
		$person_id = $param['person'];
		
		$data['household_persons'] = $this->masterlist->get_households($this->session->userdata('TPusername'),$household_id,$person_id);
		$this->load->view('mobile/person_details_view', $data);
	}
	
	function add_immediate_case()
	{			
		$this->form_validation->set_rules('duration', 'Dengue Fever Duration', 'callback_check_range|required');
		
		//$symptoms = $this->input->post('symptoms');
		
		//print_r($symptoms);
				
		if ($this->form_validation->run() === FALSE)
		{
			//redirect(uri_string(),'refresh');
			//var_dump($_POST['household_id']);
			$this->view_person();
			//$this->view_person();//$this->load->view('mobile/view/household/' . $this->input->post('household_id') . '/person/' . $this->input->post('person_id'), $data);
		}
		else
		{
			$this->masterlist->add_immediate_cases();

			$this->add_case_notif('imcase', $this->input->post('person_id'));
			$this->checkforbounceandred('imcase',$this->input->post('lat'),$this->input->post('lng'));
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/im_case_success',$data);
		}
	}
	
	public function check_range($num)
	{
		if ($num <= 0)
		{
			$this->form_validation->set_message('check_range', 'The %s field could not be less than nor equal to 0');
			return FALSE;
		}
		else if ($num > 20)
		{
			$this->form_validation->set_message('check_range', 'The %s field could not more than 20');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
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
	}
	
	function add_fever_day($person_id)
	{
		$this->masterlist->add_fever_day($person_id);//$household_persons[$ctr]['person_id']);
		
		$data['result'] = 'Your entry has been recorded';
		$this->load->view('mobile/im_case_success',$data);
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

/* End of file mobile/master_list.php */
/* Location: ./application/controllers/mobile/master_list.php */