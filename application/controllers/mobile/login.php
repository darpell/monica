<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Login';
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/login');
		}
		else
		{
			$this->load->view('mobile/home');
		}
	}
	
	function mob_check()
	{
		$data['title'] = 'Login';
		$data['script'] = '';
		
		$this->form_validation->set_rules('mob_username-txt_r', 'username', 'required');
		$this->form_validation->set_rules('mob_password-txt_r', 'password', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/login', $data);
		}
		else
		{
			$this->load->model('mod_login');
			$data = array(
					'TPusername-txt'	=>	$this->input->post('mob_username-txt_r'),
					'TPpassword-txt'	=>	$this->input->post('mob_password-txt_r')
				);
			
			$userinfo = $this->mod_login->check($data);
			if($userinfo != false)
			{
				$this->session->set_userdata('TPusername', $userinfo[0]['TPusername']);
				$this->session->set_userdata('TPtype', $userinfo[0]['TPtype']);
				$this->session->set_userdata('TPfirstname', $userinfo[0]['TPfirstname']);
				$this->session->set_userdata('TPmiddlename', $userinfo[0]['TPmiddlename']);
				$this->session->set_userdata('TPlastname', $userinfo[0]['TPlastname']);
				$this->session->set_userdata('logged_in', true);
				//redirect(substr(base_url(), 0, -1) . '/index.php/');
				$result_data['result'] = 'You have successfully logged in';
				$this->load->view('mobile/home',$result_data);
			}
			else
			{
				$result_data['result'] = 'You are not authorized to use the service';
				$this->load->view('mobile/login',$result_data);
			}
		}
	}
}

/* End of file mobile/login.php */
/* Location: ./application/controllers/mobile/login.php */