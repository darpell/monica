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
					$data['result'] = '';
					$this->load->view('mobile/home',$data);
				}
				else
					redirect(site_url('mobile/login'));
			}
			
			else if ($page == 'checklocation')
				$this->load->view('mobile/current_pos');	
			/*	
			else if ($page == 'casemap')
			{
			$this->load->model('Mapping');
				$data['title'] = 'View map';
				//scripts if none keep ''
				$data['script'] = 'view_casereport';
				
				$data['table'] = null;
				
				/** Validation rules could be seen at application/config/form_validation.php
				//*
				if ($this->form_validation->run('') == FALSE)
				{
						/*
						//$date1= explode ('/', $this->input->post('date1'));
						//$date2= explode ('/', $this->input->post('date2'));
						//$this->input->post('date1')."CFYVGBHJK";
						//$this->input->post('date2')."CFYVGBHJK<br/>";
						
						$data2['date1']='2010-01-01';
						$data2['date2']='2015-01-01';
						$data['date1']='2010-01-01';
						$data['date2']='2015-01-01';
						
						//$data2['date1']=$date1[2].'-'.$date1[0].'-'.$date1[1];
						//$data2['date2']=$date2[2].'-'.$date2[0].'-'.$date2[1];
						//$data['date1']=$date1[2].'-'.$date1[0].'-'.$date1[1];
						//$data['date2']=$date2[2].'-'.$date2[0].'-'.$date2[1];
						
						$data['node_type']="denguecase";
						
						$data['nodes'] = $this->Mapping->mapByType($data);
						$data['bcount'] = $this->Mapping->getBarangayCount($data2);
						$this->load->library('table');
						//**-------------
						
						$barangayWithPolygon[]=$this->Mapping->getBarangays();
						$allBarangays[]=$this->Mapping->getAllBarangays();
						$data['options']=array_diff($allBarangays[0],$barangayWithPolygon[0]);
						//print_r(array_diff($allBarangays[0],$barangayWithPolygon[0]));
						$data2['date1']='2010-01-01';
						$data2['date2']='2015-01-01';
						$data['date1']='2010-01-01';
						$data['date2']='2015-01-01';
						$data['node_type']="denguecase";
						$data['nodes'] = $this->Mapping->mapByType($data);
						$data['bcount'] = $this->Mapping->getBarangayCount($data2);
						$this->load->library('table');
						$this->load->view('mobile/casemap',$data);
				}
				else
				{
					$this->load->view('pages/success');
				}
			}
			*/
			else if ($page == 'user')
				$this->load->view('mobile/user');
			
			else if ($page =='larval_survey')
				$this->load->view('mobile/ls_form');
		/*}
		
		else 
		{
			redirect(base_url());
		} */
	}
}

/* End of file mobile/pages.php */
/* Location: ./application/controllers/mobile/pages.php */
