<?php
class Login extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Login';
		$this->form_validation->set_rules('mob_username-txt_r', 'Username', 'required');
		$this->form_validation->set_rules('mob_password-txt_r', 'Password', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/login');
		}
		else
		{
			$this->load->view('mobile/home');
		}
	}
	
	function check()
	{
		$this->form_validation->set_rules('mob_username-txt_r', 'Username', 'required');
		$this->form_validation->set_rules('mob_password-txt_r', 'Password', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/login');
			//$this->load->view('mobile/success.php');
		}
		else
		{
			$this->load->model('mod_login');
			$data = array(
					'TPusername-txt' => $this->input->post('mob_username-txt_r'),
					'TPpassword-txt' => $this->input->post('mob_password-txt_r')
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
				//redirect(substr(base_url(), 0, -1) . '/index.php/');
				$this->load->view('mobile/home');
			}
			else
			{
				$this->load->view('mobile/login');
			}
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/mobile/login/', 'refresh');
	}
}

/* End of file mobile/login.php */
/* Location: ./application/controllers/mobile/login.php */