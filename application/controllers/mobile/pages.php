<?php
class Pages extends CI_Controller 
{
	public function view($page)
	{
		$this->load->library('mobile_detect');
		/*if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{		*/	
			//$data['title'] = 'Login';
			if ($page == 'home')
			{
				if ($this->session->userdata('TPusername') != null)
				{
					$this->load->model('tasks_model');
					$this->load->model('larval_mapping');
					$data['last_visit'] = $this->larval_mapping->get_last_visit($this->session->userdata('TPusername'));
					$data['task_count'] = $this->tasks_model->get_count_unaccomplished();
					$data['result'] = '';
					$this->load->view('mobile/home',$data);
				}
				else
					redirect(site_url('mobile/login'));
			}
			
			else if ($page == 'checklocation')
				$this->load->view('mobile/current_pos');
			
			else if ($page == 'larval_survey')
				$this->load->view('mobile/ls_form');
			
			else if ($page == 'point_of_interest')
				$this->load->view('mobile/poi_form');
				
			else if ($page == 'deng_info')
				$this->load->view('mobile/deng_info');
		/*}
		
		else 
		{
			redirect(base_url());
		} */
	}
}

/* End of file mobile/pages.php */
/* Location: ./application/controllers/mobile/pages.php */
