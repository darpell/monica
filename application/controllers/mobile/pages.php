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
				$this->load->view('mobile/home');
	
			else if ($page == 'checklocation')
				$this->load->view('mobile/current_pos');	
					
			else if ($page == 'casemap')
				$this->load->view('mobile/casemap');
			
			else if ($page == 'riskmap')
				$this->load->view('mobile/riskmap');
			
			else if ($page =='larval_survey')
				$this->load->view('mobile/ls_form');
		}
		
		else 
		{
			redirect(base_url());
		} 
	}
}

/* End of file mobile/pages.php */
/* Location: ./application/controllers/mobile/pages.php */