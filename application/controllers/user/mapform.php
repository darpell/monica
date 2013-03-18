<?php
class Mapform extends CI_Controller
{
	public function index()
	{
		$this->load->model('Mapping');
		$data['node_type'] = $this->input->post('NDtype-ddl');
		
		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = 'view_casereport';
		
		//for table result for search
		$data['table'] = null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
		if ($this->form_validation->run('') == FALSE)
		{
			{
				if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
				{
					$date1=$this->input->post('YearStart-ddl').'-'.$this->input->post('MonthStart-ddl').'-'.'01';
					$date2=$this->input->post('YearEnd-ddl').'-'.$this->input->post('MonthEnd-ddl').'-'.'01';
					$date2=date('Y-m-t', strtotime($date2));
				}
				else
				{
					$date1=date('Y-m-01');
					$date2=date('Y-m-t');
				}
				/*
				if(strtotime($date1)>strtotime($date2))
				{
					echo "OH NOES!";
					$temp=date1;
					$date1=$date2;
					$date2=$temp;
				}//*/

				echo $date1." ";
				echo $date2;
				
				$data2['date1']=$date1;
				$data2['date2']=$date2;
				$data['date1']=$date1;
				$data['date2']=$date2;
				
				$data['nodes'] = $this->Mapping->mapByType($data);
				$data['bage'] = $this->Mapping->getBarangayAges($data2);
				$data['binfo'] = $this->Mapping->getBarangayInfo($data2);
				$data['bcount'] = $this->Mapping->getBarangayCount($data2);
				$data['dist'] = $this->Mapping->calculateDistanceFormula($data2);
				$this->load->library('table');
				$this->load->view('pages/view_map',$data);
			}
		}
		else
		{
			$this->load->view('pages/success');
		}//*/
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