<?php
class Pages extends CI_Controller 
{
	public function view($page)
	{
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{			
			//$data['title'] = 'Login';
			if ($page == 'home')
<<<<<<< HEAD
			{
				if ($this->session->userdata('TPusername') != null)
				{
					$data['result'] = '';
					$this->load->view('mobile/home',$data);
				}
				else
					redirect(site_url('mobile/login'));
			}
=======
				$this->load->view('mobile/home');
	
>>>>>>> branch 'master' of https://github.com/darpell/monica.git
			else if ($page == 'checklocation')
				$this->load->view('mobile/current_pos');	
					
			else if ($page == 'casemap')
				$this->load->view('mobile/casemap');
			
			else if ($page == 'riskmap')
				$this->load->view('mobile/riskmap');
			
<<<<<<< HEAD
			else if ($page == 'larval_survey')
			{
				$data['result'] = null;
				$this->load->view('mobile/ls_form', $data);
			}
			else if ($page == 'user')
				$this->load->view('mobile/user');
=======
			else if ($page =='larval_survey')
				$this->load->view('mobile/ls_form');
>>>>>>> branch 'master' of https://github.com/darpell/monica.git
		}
		
		else 
		{
			redirect(base_url());
		} 
	}
}

/* End of file mobile/pages.php */
/* Location: ./application/controllers/mobile/pages.php */
