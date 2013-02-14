<?php

class Pages extends CI_Controller 
{
	public function view($page = 'home')
	{
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{			
			redirect('mobile');
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