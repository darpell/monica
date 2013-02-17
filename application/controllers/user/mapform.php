<?php
class Mapform extends CI_Controller
{
	public function index()
	{
		$this->load->model('Mapping');
		$data['title'] = 'View map nodes';
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		$data['options2']=$this->Mapping->getBarangays();
		
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/map_form',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	
	function mapByType()
	{	
		$this->load->model('Mapping');
		$data['node_type'] = $this->input->post('NDtype-ddl');
		
		$data['title'] = 'View map';
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		
		//for table result for search
		$data['table'] = null; 
		$data['options']=$this->Mapping->getNodeTypes();
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
		if ($this->form_validation->run('') == FALSE)
		{ 
			//if ($this->input->post('NDtype-ddl')=="larvalpositive")
			{
				$date1= explode ('/', $this->input->post('date1'));
				$date2= explode ('/', $this->input->post('date2'));
				$this->input->post('date1')."CFYVGBHJK";
				$this->input->post('date2')."CFYVGBHJK<br/>";
				$data2['date1']=$date1[2].'-'.$date1[0].'-'.$date1[1];
				$data2['date2']=$date2[2].'-'.$date2[0].'-'.$date2[1];
				$data['date1']=$date1[2].'-'.$date1[0].'-'.$date1[1];
				$data['date2']=$date2[2].'-'.$date2[0].'-'.$date2[1];
				
				$data['nodes'] = $this->Mapping->mapByType($data);			
				$data['bcount'] = $this->Mapping->getBarangayCount($data2);
				$this->load->library('table');
				$this->load->view('pages/view_map',$data);
			}
			/*
			
			{
				$data['nodes'] = $this->Mapping->getAllPolygon();
				
				$this->load->view('templates/header',$data);
				$this->load->library('table');
				$this->load->view('pages/view_map',$data);
				$this->load->view('templates/footer');
			}//*/
		}
		else
		{
			$this->load->view('pages/success');
		}
		//*/
	}
	function mapPolygons()
	{	
		$this->load->model('Mapping');
		$data['polygon_name'] = $this->input->post('NDtype-ddl');
		$data['title'] = 'View map';
		
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		
		//for table result for search
		$data['table'] = null; 
		$data['options2']=$this->Mapping->getBarangays();
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
		if ($this->form_validation->run('') == FALSE)
		{ 
			$data['nodes'] = $this->Mapping->mapByType($data);
			$data['bcount'] = $this->Mapping->getBarangayCount();
			$this->load->library('table');
			$this->load->view('pages/view_map',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
		//*/
	}
	function mapAllPolygons()
	{	
		$this->load->model('Mapping');
		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = 'view_casereport';
		
		//for table result for search
		$data['table'] = null; 
		$data['options2']=$this->Mapping->getBarangays();
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
		if ($this->form_validation->run('') == FALSE)
		{ 
			$data['nodes'] = $this->Mapping->mapAllPolygon();
			$this->load->library('table');
			$this->load->view('pages/view_map',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
		//*/
	}
	
	function getNodeInfo($data)
	{	
		$this->load->model('Mapping');		
		return $this->Mapping->getNodeInfo($data);
	}
	
	function addNodeCluster($data)
	{	
		$this->load->model('Mapping');
		return $this->Mapping->addNodeCluster($data);
	}
}

/* End of file user/mapform.php */
/* Location: ./application/controllers/user/mapform.php */