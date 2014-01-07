<?php
class Household extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('household_mob');
	}
	
	public function index()
	{
		$this->load->view('mobile/household_form');
	}
	
	function add()
	{
		$this->form_validation->set_rules('hh_name', 'household name', 'required');
		$this->form_validation->set_rules('hh_no', 'household number', 'required');
		$this->form_validation->set_rules('hh_street', 'household street', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/household_form');
		}
		else
		{
			$this->household_mob->add();
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/poi_success', $data);
		}
	}
	
	function add_mem_index()
	{
		$param = $this->uri->uri_to_assoc(3);
		$household_id = $param['household'];
		
		$data['household_id'] = $household_id;
	
		$this->load->view('mobile/household_member_form',$data);
	}
	
	function add_new_member()
	{
	
	}
	
}

/* End of file mobile/household.php */
/* Location: ./application/controllers/mobile/household.php */