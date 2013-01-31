<?php
class Login extends CI_Controller
{
	function check()
	{
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/login.php');
			//$this->load->view('mobile/success.php');
		}
		else
		{
			$this->load->model('mod_login');
			$data = array(
					'TPusername-txt' => $this->input->post('mob_username-txt'),
					'TPpassword-txt' => $this->input->post('mob_password-txt')
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
				$this->load->view('mobile/index.php');
			}
			else
			{
				$this->load->view('mobile/index.php');
			}
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/login/', 'refresh');
	}
}

/* End of file mobile/login.php */
/* Location: ./application/controllers/mobile/login.php */