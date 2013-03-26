<?php
class Deletemap extends CI_Controller
{
	public function index()
	{		$this->redirectLogin();
		$this->load->model('Mapping');
		$data['title'] = 'Delete boundary';
		//scripts if none keep '' 
		$data['script'] = '';
				
		//for table result for search
		$data['table'] = null;
				
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$barangayWithPolygon[]=$this->Mapping->getBarangays();
			$allBarangays[]=$this->Mapping->getAllBarangays();
			$data['options']=$barangayWithPolygon[0];
			$data2['date1']='2010-01-01';
			$data2['date2']='2015-01-01';
			$data['date1']='2010-01-01';
			$data['date2']='2015-01-01';
			$data['node_type']="denguecase";
			$data['nodes'] = $this->Mapping->mapByType($data);
			$data['bcount'] = $this->Mapping->getBarangayCount($data2);
			$this->load->library('table');
			
			$this->load->view('pages/delete_map',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function redirectLogin()
	{	$this->load->library('mobile_detect');
	if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
	{
		$this->load->view('mobile/index.php');
	}
	elseif ($this->session->userdata('logged_in') != TRUE && $this->session->userdata('TPtype') != 'CHO' ){
		redirect(substr(base_url(), 0, -1) . '/index.php/login');
	}
	}
	function delPolygon()
	{$this->redirectLogin();
		$this->load->model('Mapping');
		$data['title'] = 'Delete boundary';
		$data['script'] = '';
		//print_r($this->input->post('NDtypeddl'));
		$this->Mapping->delPolygon($this->input->post('NDtypeddl'));
		$barangayWithPolygon[]=$this->Mapping->getBarangays();
		$data['options']=$barangayWithPolygon[0];
		$data2['date1']='2010-01-01';
		$data2['date2']='2015-01-01';
		$data['date1']='2010-01-01';
		$data['date2']='2015-01-01';
		$data['node_type']="denguecase";
		$data['nodes'] = $this->Mapping->mapByType($data);
		$data['bcount'] = $this->Mapping->getBarangayCount($data2);
		$this->load->library('table');
		
		$this->load->view('pages/delete_map',$data);
	}
}

/* End of file user/addmap.php */
/* Location: ./application/controllers/user/addmap.php */