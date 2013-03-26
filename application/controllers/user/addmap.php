<?php
class Addmap extends CI_Controller
{
	public function index()
	{		$this->redirectLogin();
		$this->load->model('Mapping');
		$data['title'] = 'Add boundary';
		//scripts if none keep '' 
		$data['script'] = '';
				
		//for table result for search
		$data['table'] = null;
				
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{	
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
			
			$this->load->view('pages/add_map',$data);
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
	function addPolygon()
	{	$this->redirectLogin();
		$this->load->model('Mapping');
		$data['title'] = 'Add boundary';
		$data['script'] = '';
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
			
			$coords= explode (')(', $this->input->post('hide'));
			$coords[0]=substr_replace($coords[0],"",0,1);
			end($coords);
			$last_id=key($coords);
			$coords[$last_id]=substr_replace(end($coords),"",-1,1);
			
			$id=$this->Mapping->getPolygonNumberMax()+1;
			foreach ($coords as $row)
			{
				$row = explode(',',$row);
				$lat = floatval($row[0]);
				$lng = floatval($row[1]);
			
				$lat=number_format($lat, 6, '.', '');
				$lng=number_format($lng, 6, '.', '');
				
				$lat=floatval($lat);
				$lng=floatval($lng);
				
				$this->Mapping->addPolygon($id,$lat,$lng,$this->input->post('NDtypeddl'));
			}
		$this->Mapping->addPolygon($id,$lat,$lng,$this->input->post('NDtypeddl'));
		
		$barangayWithPolygon[]=$this->Mapping->getBarangays();
		$allBarangays[]=$this->Mapping->getAllBarangays();
		$data['options']=array_diff($allBarangays[0],$barangayWithPolygon[0]);
		$data2['date1']='2010-01-01';
		$data2['date2']='2015-01-01';
		$data['date1']='2010-01-01';
		$data['date2']='2015-01-01';
		$data['node_type']="denguecase";
		$data['nodes'] = $this->Mapping->mapByType($data);
		$data['bcount'] = $this->Mapping->getBarangayCount($data2);
		$this->load->library('table');
		
		$this->load->view('pages/add_map',$data);
		//*/
	}
}

/* End of file user/addmap.php */
/* Location: ./application/controllers/user/addmap.php */