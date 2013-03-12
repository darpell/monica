<?php
class Login extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Login';
		$data['script'] = '';
		$data['result'] =  null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/view_login',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	
	function check()
	{
		$data['title'] = 'Login';
		$data['script'] = '';
		
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
			$data['title'] = 'Login';
			$data['script'] = '';
			$data['result'] = 'failed';
			$this->load->view('pages/view_login',$data);
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
				$data['title'] = 'Login';
				$data['script'] = '';
				$data['result'] = 'failed';
				$this->load->view('pages/view_login',$data);
			}
		}
	}
	
	function add_user()
	{
		$data['title'] = 'Registration Page';
		$data['script'] = '';
		$data['result'] =  null;
		$this->load->model('mod_login');
		$users = $this->mod_login->get_users();
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required|matches[TPpassword2-txt]');
		$this->form_validation->set_rules('TPpassword2-txt', 'repeat password', 'required');
		$this->form_validation->set_rules('TPfirstname-txt', 'first name', 'required');
		$this->form_validation->set_rules('TPmiddlename-txt', 'middle name', 'required');
		$this->form_validation->set_rules('TPlastname-txt', 'last name', 'required');
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/view_register',$data);
		}
		else
		{
				$data = array(
				'TPusername-txt' => $this->input->post('TPusername-txt'),
				'TPpassword-txt' => $this->input->post('TPpassword-txt'),
				'TPfirstname-txt' => $this->input->post('TPfirstname-txt'),
				'TPmiddlename-txt' => $this->input->post('TPmiddlename-txt'),
				'TPlastname-txt' => $this->input->post('TPlastname-txt'),
				'TPtype-dd' => $this->input->post('TPtype-dd')
			);
		
			if (array_search($data['TPusername-txt'],$users)  == null){
			$this->mod_login->add_user($data);
			$data['script'] = '';
			$this->load->view('pages/success' , $data);
			}
			else
			{
				$data['title'] = 'Login';
				$data['script'] = '';
				$data['result'] = 'failed';
				$this->load->view('pages/view_register',$data);
				
			}
		}
	}
	function unapproved_users()
	{
		$this->load->model('mod_login');
		
		/* css */
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Approve Users';
		
		
		//scripts if none keep ''
		$data['script'] = '';
		
		//for table result for search
		$data['table'] = $this->mod_login->get_unapproved_users($data);
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->library('table');
			$this->load->view('pages/user_pending',$data);
		}
		else
		{
			
		}
	
	}
	
	function view_user()
	{
		$this->load->model('mod_login');
		$data['username'] = $this->uri->segment(3,"");
		
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'view_user';
		
		
		//scripts if none keep ''
		$data['script'] = '';
		$data['result'] = '';
		
		
		//for table result for search
		$data['info'] = $this->mod_login->view_user($data);
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->library('table');
			$this->load->view('pages/view_approve_user',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function approve_user()
	{	
	
		$data['title'] = 'Registration Page';
		$data['script'] = '';
		$data['result'] =  null;
		$this->load->model('mod_login');
		$users = $this->mod_login->get_users();
		$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
		$this->form_validation->set_rules('TPpassword-txt', 'password', 'required|matches[TPpassword2-txt]');
		$this->form_validation->set_rules('TPpassword2-txt', 'repeat password', 'required');
		$this->form_validation->set_rules('TPfirstname-txt', 'first name', 'required');
		$this->form_validation->set_rules('TPmiddlename-txt', 'middle name', 'required');
		$this->form_validation->set_rules('TPlastname-txt', 'last name', 'required');
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/view_register',$data);
		}
		else
		{
				$data = array(
				'TPusername-txt' => $this->input->post('TPusername-txt'),
				'TPpassword-txt' => $this->input->post('TPpassword-txt'),
				'TPfirstname-txt' => $this->input->post('TPfirstname-txt'),
				'TPmiddlename-txt' => $this->input->post('TPmiddlename-txt'),
				'TPlastname-txt' => $this->input->post('TPlastname-txt'),
				'TPtype-dd' => $this->input->post('TPtype-dd')
			);
		
			$this->mod_login->update_user($data);
			$data['script'] = '';
			$this->load->view('pages/success' , $data);
			}
			
		}
	
	function logout()
	{
		$this->session->sess_destroy();
		//redirect('/login/', 'refresh');
		redirect(base_url());
	}
	function admin_functions()
	{
		$data['script'] = '';
		$this->load->view('pages/admin' , $data);
	}
	
}

/* End of file user/login.php */
/* Location: ./application/controllers/user/login.php */