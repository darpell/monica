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
}

/* End of file mobile/master_list.php */
/* Location: ./application/controllers/mobile/master_list.php */