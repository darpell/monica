<?php
class Login extends CI_Controller
{
	public function index()
	{
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Login';
		$data['script'] = '';
		$data['result'] =  null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('templates/header',$data);
			$this->load->view('pages/view_login');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function check()
	{
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Login';
		$data['script'] = '';
		
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('templates/header',$data);
			$this->load->view('pages/view_login');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->model('mod_login');
			$data = array(
				'TPusername-txt' => $this->input->post('TPusername-txt'),
				'TPpassword-txt' => $this->input->post('TPpassword-txt')
			);
		
		
		$userinfo  = $this->mod_login->check($data);
		if($userinfo != false)
		{
		
		$this->session->set_userdata('TPusername', $userinfo[0]['TPusername']);
		$this->session->set_userdata('TPtype', $userinfo[0]['TPtype']);
		$this->session->set_userdata('TPfirstname', $userinfo[0]['TPfirstname']);
		$this->session->set_userdata('TPmiddlename', $userinfo[0]['TPmiddlename'] );
		$this->session->set_userdata('TPlastname', $userinfo[0]['TPlastname'] );
		$this->session->set_userdata('logged_in', true);
		redirect(substr(base_url(), 0, -1) . '/index.php/');
		}
		else
		{
			$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');
		
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Login';
		$data['script'] = '';
		$data['result'] = 'failed';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/view_login');
			$this->load->view('templates/footer');
	

		}
		
		
		}
	}
	
	function add_user()
	{			
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Registration Page';
		$data['script'] = '';
		
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required|matches[TPpassword2-txt]');
		$this->form_validation->set_rules('TPpassword2-txt', 'repeat password', 'required');
		$this->form_validation->set_rules('TPfirstname-txt', 'first name', 'required');
		$this->form_validation->set_rules('TPmiddlename-txt', 'middle name', 'required');
		$this->form_validation->set_rules('TPlastname-txt', 'last name', 'required');
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('templates/header',$data);
			$this->load->view('pages/view_register');
			$this->load->view('templates/footer');
		}
		else
		{
				$this->load->view('pages/view_register');
				$this->load->model('mod_login');
				$data = array(
				'TPusername-txt' => $this->input->post('TPusername-txt'),
				'TPpassword-txt' => $this->input->post('TPpassword-txt'),
				'TPfirstname-txt' => $this->input->post('TPfirstname-txt'),
				'TPmiddlename-txt' => $this->input->post('TPmiddlename-txt'),
				'TPlastname-txt' => $this->input->post('TPlastname-txt'),
				'TPtype-dd' => $this->input->post('TPtype-dd')
			);
			
			$this->mod_login->add_user($data);
			$this->load->view('pages/success');
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/login/', 'refresh');
	}
}

/* End of file user/login.php */
/* Location: ./application/controllers/user/login.php */