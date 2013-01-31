<?php
class Pages extends CI_Controller 
{
	public function mob_view($page = 'home')
	{
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{			
			//$data['title'] = 'Login';			
			$this->load->view('mobile/login.php');
		}
		else 
		{
			redirect(base_url('/home'));
		} 
	}
}

/* End of file mobile/pages.php */
/* Location: ./application/controllers/mobile/pages.php */