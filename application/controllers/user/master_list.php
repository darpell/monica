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
			$data['uninvest'] = $this->suggest_model->get_cases($brgy, '2013-01-01','2013-07-22');
			$data['households'] = $this->masterlist->get_households(false,$bhw_id);
			$data['masterlist'] = $this->masterlist->get_masterlist(false,$bhw_id);
			$data['cases'] = $this->masterlist->get_immediate_cases($bhw_id);
			$data['bhwdd']= $this->Cho_model->get_bhw();
			$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
			$temp =$data['households'];
			for($i = 0; $i < count($temp); $i++)
			{
				$x = $temp[$i]['bhw_id']; 
				$data['catchement'][$x] = array(
						'Name' => $temp[$i]['household_name'],
						'House no' => $temp[$i]['house_no'],
						'street' => $temp[$i]['street'],
						'last visited' => $temp[$i]['last_visited'],
						);
				$data['bhw'][$x] = $temp[$i]['user_firstname'] . ' '. $temp[$i]['user_lastname'] ;
			
			}
			$data['bhwdd']= $data['bhwdd'][$barangay];
			
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
				
			redirect('/master_list/view_household_midwife/', 'refresh');
		}
	
	
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
	
			);
				
			$person_id = $this->masterlist->add_masterlist_midwife($house_id,$data2);
			print_r($person_id);
			//$this->masterlist->add_catchment_area($house_id,$person_id,$bhw_id);
		}
		$data['households'] = $this->masterlist->get_households(false,$bhw_id);
		$data['masterlist'] = $this->masterlist->get_masterlist(false,$bhw_id);
		$data['bhwdd']= $this->Cho_model->get_bhw();
		$barangay =  $this->masterlist->get_barangay_midwife($bhw_id);
		$data['bhwdd']= $data['bhwdd'][$barangay];
		$this->load->view('pages/view_masterlist_midwife', $data);
	
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