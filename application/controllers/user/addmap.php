<?php
class Addmap extends CI_Controller
{
	public function index()
	{		
		$this->load->model('Mapping');
		$data['title'] = 'Add boundary';
		//scripts if none keep '' 
		$data['script'] = '';
		$data['options']=$this->Mapping->getBarangays();
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/add_map',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function addPolygon()
	{
		$this->load->model('Mapping');
		$data['title'] = 'Add Polygon';
		$data['script'] = '';
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
			$this->load->view('pages/add_map',$data);
			
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
				
				echo $id."      ".$lat."      ".$lng."      ".$this->input->post('NDtypeddl')."<br/>";
				$this->Mapping->addPolygon($id,$lat,$lng,$this->input->post('NDtypeddl'));
			}
		$this->Mapping->addPolygon($id,$lat,$lng,$this->input->post('NDtypeddl'));
		//*/
	}
}

/* End of file user/addmap.php */
/* Location: ./application/controllers/user/addmap.php */