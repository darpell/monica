<?php

class Pages extends CI_Controller 
{
	public function view($page = 'home')
	{
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{			
			$this->form_validation->set_rules('TPusername-txt', 'username', 'required');
			$this->form_validation->set_rules('TPpassword-txt', 'password', 'required');
			
			if ($this->form_validation->run('') == FALSE)
			{
				$this->load->view('mobile/index.php');
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
			//redirect(substr(base_url(), 0, -1) . '/index.php/');
			$this->load->view('mobile/index.php');
			}
			else
			{
				$this->load->view('mobile/index.php');
			}
			}
		}
		else 
		{
			if ( ! file_exists('application/views/pages/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			
			$data['title'] = ucfirst($page); // Capitalize the first letter
			
			//scripts if none keep '' 
			$data['script'] = '';
	
			
			//$this->load->view('templates/header');
			$this->load->view('pages/'.$page, $data);
			//$this->load->view('templates/footer');
		} 
	}
}

/* End of file user/pages.php */
/* Location: ./application/controllers/user/pages.php */