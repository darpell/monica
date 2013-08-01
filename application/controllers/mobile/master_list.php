<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_list extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('master_list_model','masterlist');
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
}

/* End of file mobile/master_list.php */
/* Location: ./application/controllers/mobile/master_list.php */