<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Investigate_cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('investigate_cases_model','ic');
		$this->load->model('case_report');
		$this->load->model('notif');
		$this->load->model('midwife','masterlist');
	}
	
	function index()
	{
		
		$data['cases'] = $this->ic->get_uninvestigated_cases($this->ic->get_user_brgy($this->session->userdata('TPusername')));
		//$data['test'] = $this->ic->get_user_brgy($this->session->userdata('TPusername'));
		$this->load->view('mobile/uninvestigated_cases',$data);
	}
	
	function plot($slug)
	{
		$data['case_details'] = $this->ic->get_uninvestigated_cases($this->ic->get_user_brgy($this->session->userdata('TPusername')), $slug);
	
		if (empty($data['case_details']))
		{
			show_404();
		}
	
		$data['title'] = $data['case_details']['cr_first_name'] . ' ' . $data['case_details']['cr_last_name'];
		$data['slug'] = $slug;

		$this->load->view('mobile/plot_view', $data);
	}
	
	function add()
	{
		if ($this->ic->plot_case())
		{
			
			$invcase = array(
					'patientno'	=>	$this->input->post('patient_no'),
					'lat' 		=>	$this->input->post('lat'),
					'lng' 		=>	$this->input->post('lng'),
					'feedback'	=>	$this->input->post('TPremarks-txt_r')
			);
			

			$this->add_case_notif('invcase', $invcase['patientno']);
			$this->checkforbounceandred('invcase', $invcase['lat'],$invcase['lng']);
			
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/im_case_success',$data);
		}
		else
			show_404();
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
		$barangay =  $this->masterlist->get_barangay($bhw_id);
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

/* End of file mobile/investigate_cases.php */
/* Location: ./application/controllers/mobile/investigate_cases.php */