<?php
class Lsform extends CI_Controller
{
	public function index()
	{	
		$this->redirectLogin();
		$data['title'] = 'Add report';
		$data['script'] = '';
		$data['result'] = null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('mobile/ls_form',$data);
		}
		else
		{
			
		}
	}
	
	function redirectLogin()
	{
		// TODO
		if($this->session->userdata('logged_in') != TRUE )
			redirect(substr(base_url(), 0, -1) . '/index.php/login');
	}
	
	function addls()
	{
		$data['title'] = 'Add larval survey';
		$data['script'] = '';

		$this->form_validation->set_rules('TPcontainer-txt_r', 'container', 'required');
		$this->form_validation->set_rules('TPhousehold-txt_r', 'household', 'required');
		$this->form_validation->set_rules('TPbarangay-txt_r', 'barangay', 'required');
		$this->form_validation->set_rules('TPdate-txt_r', 'date', 'required');
		$this->form_validation->set_rules('TPinspector-txt_r', 'inspector', 'required');
		$this->form_validation->set_rules('TPmunicipality-txt_r', 'municipality', 'required');
		$this->form_validation->set_rules('TPstreet-txt_r', 'street', 'required');
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/ls_form',$data);
		}
		else
		{
			$this->load->model('larval_survey');
			$data = array(
						'TPcreatedby-txt'		=>	$this->session->userdata('TPusername'),
						'TPcreatedon-txt' 		=>	date("Y-m-d H:i:s"),
						'TPlastupdatedby-txt' 	=> 	$this->session->userdata('TPusername'),
						'TPlastupdatedon-txt' 	=> 	date("Y-m-d H:i:s"),			
						'TPcontainer-txt' 		=> 	$this->input->post('TPcontainer-txt_r'),
						'TPhousehold-txt' 		=> 	$this->input->post('TPhousehold-txt_r'),
						'TPresult-rd' 			=>	$this->input->post('TPresult-rd'),
						'TPbarangay-txt' 		=>	$this->input->post('TPbarangay-txt_r'), 
						'TPdate-txt' 			=>	$this->input->post('TPdate-txt_r'), 		// TODO to be continued..
						'TPinspector-txt' 		=>	$this->input->post('TPinspector-txt_r'), 			
						'TPmunicipality-txt' 	=>	$this->input->post('TPmunicipality-txt_r'),
						'TPstreet-txt' 			=>	$this->input->post('TPstreet-txt_r'),
						'lat'					=>	$this->input->post('lat'),
						'lng'					=>	$this->input->post('lng')
					);
			//$this->larval_survey->addLS_report($data);
			$this->larval_survey->add($data);
			
			$return_data['result'] = 'Your entry has been recorded.';
			$this->load->view('mobile/ls_form',$return_data);
		}
	}
}

/* End of file user/lsform.php */
/* Location: ./application/controllers/user/lsform.php */