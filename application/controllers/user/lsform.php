<?php
class Lsform extends CI_Controller
{
	public function index()
	{	
		$this->redirectLogin();
		$data['title'] = 'Add report';
		$data['script'] = '';
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/ls_form',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	
	function redirectLogin()
	{
		if($this->session->userdata('logged_in') != TRUE )
		redirect(substr(base_url(), 0, -1) . '/index.php/login');
		
	}
	
	function addls()
	{
		$data['title'] = 'Add larval survey';
		$data['script'] = '';
		
		$this->form_validation->set_rules('TPcreatedby-txt', 'created by', 'required');
		$this->form_validation->set_rules('TPcreatedon-txt', 'created on', 'required');
		$this->form_validation->set_rules('TPlastupdatedby-txt', 'last updated by', 'required');
		$this->form_validation->set_rules('TPlastupdatedon-txt', 'last updated on', 'required');
		$this->form_validation->set_rules('TPcontainer-txt', 'container', 'required');
		$this->form_validation->set_rules('TPhousehold-txt', 'household', 'required');
		$this->form_validation->set_rules('TPbarangay-txt', 'barangay', 'required');
		$this->form_validation->set_rules('TPdate-txt', 'date', 'required');
		$this->form_validation->set_rules('TPinspector-txt', 'inspector', 'required');
		$this->form_validation->set_rules('TPmunicipality-txt', 'municipality', 'required');
		$this->form_validation->set_rules('TPstreet-txt', 'street', 'required');
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/ls_form.php',$data);
		}
		else
		{
			$this->load->view('mobile/home.php');
			$this->load->model('larval_survey');
			$data = array(
			'TPcreatedby-txt' => $this->input->post('TPcreatedby-txt'),
			'TPcreatedon-txt' => $this->input->post('TPcreatedon-txt'),
			'TPlastupdatedby-txt' => $this->input->post('TPlastupdatedby-txt'),
			'TPlastupdatedon-txt' => $this->input->post('TPlastupdatedon-txt'),			
			'TPcontainer-txt' => $this->input->post('TPcontainer-txt'),
			'TPhousehold-txt' => $this->input->post('TPhousehold-txt'),
			'TPresult-rd' => $this->input->post('TPresult-rd'),
			'TPbarangay-txt' => $this->input->post('TPbarangay-txt'), 
			'TPdate-txt' => $this->input->post('TPdate-txt'), 
			'TPinspector-txt' => $this->input->post('TPinspector-txt'), 			
			'TPmunicipality-txt' => $this->input->post('TPmunicipality-txt'),
			'TPstreet-txt' => $this->input->post('TPstreet-txt')
		);
		
		$this->larval_survey->addLS_report($data); 
		}
	}
}

/* End of file user/lsform.php */
/* Location: ./application/controllers/user/lsform.php */