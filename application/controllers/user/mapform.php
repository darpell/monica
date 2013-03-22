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
				
				//*DATE MANIPULATION BEGINS HERE
				//yyyy-mm-dd
				$data['date1']=$date1;
				$data['date2']=$date2;
				
				$dateData1['date1']=$date1;
				$dateData1['date2']=$date2;

				if($this->input->post('deflt')==1||strtoupper($_SERVER['REQUEST_METHOD']) != 'POST')
				{
					//*PREVIOUS DATE INTERVAL DATA PREPARATION
					$dateTemp1=explode("-",$date1);
					$dateTemp2=explode("-",$date2);
	
					$dateTemp1[0]=intval($dateTemp1[0]);
					$dateTemp2[0]=intval($dateTemp2[0]);
					if((($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]))==$date2))
					{
						$dateData2['date1']=($dateTemp1[0]-1)."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-1)."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					else
					{
						$dateData2['date1']=($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					//*/					
				}
				else
				{
					$dateData2['date1']=$this->input->post('PYearStart-ddl').'-'.$this->input->post('PMonthStart-ddl').'-'.'01';
					$dateData2['date2']=$this->input->post('PYearEnd-ddl').'-'.$this->input->post('PMonthEnd-ddl').'-'.'01';
					$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
				}

				//echo $dateData2['date1']." to ".$dateData2['date2']." : ";
				//echo $dateData1['date1']." to ".$dateData1['date2'];
								
				//*CURRENT DATE INTERVAL DATA EXTRACTION
				$data['nodes'] = $this->Mapping->mapByType($data);
				$data['bage'] = $this->Mapping->getBarangayAges($dateData1);
				$data['binfo'] = $this->Mapping->getBarangayInfo($dateData1);
				$data['bcount'] = $this->Mapping->getBarangayCount($dateData1);
				$data['dist'] = $this->Mapping->calculateDistanceFormula($dateData1);
				//*/

				$data['date1']=$dateData2['date1'];
				$data['date2']=$dateData2['date2'];
				$data['cdate1']=$dateData1['date1'];
				$data['cdate2']=$dateData1['date2'];
				$data['pdate1']=$dateData2['date1'];
				$data['pdate2']=$dateData2['date2'];
				
				//*PREVIOUS DATE INTERVAL DATA EXTRACTION
				$data['Pnodes'] = $this->Mapping->mapByType($data);
				$data['Pbage'] = $this->Mapping->getBarangayAges($dateData2);
				$data['Pbinfo'] = $this->Mapping->getBarangayInfo($dateData2);
				$data['Pbcount'] = $this->Mapping->getBarangayCount($dateData2);
				$data['Pdist'] = $this->Mapping->calculateDistanceFormula($dateData2);
				//*/
				//-------------------*/

				$data['table1'] = $this->Mapping->getBarangayAges($dateData1);
				$data['table2'] = $this->Mapping->getBarangayAges($dateData2);
							
				$this->load->library('table');
				$this->load->view('pages/view_map',$data);
			}
		}
		else
		{
			$this->load->view('pages/success');
		}//*/
	}
	function getAgeData($bname,$date1,$date2)
	{
		$this->load->model('Mapping');
		if(strtotime($date1)>strtotime($date2))
		{
			$temp=$date1;
			$date1=$date2;
			$date2=$temp;
		}
		$dates['date1']=$date1;
		$dates['date2']=$date2;
		$temp=$this->Mapping->getBarangayAges($dates);
		$arrData[]=array(
				'cr_barangay'=>'Barangay',
				'pateintcount'=> 'Patient Count',
				'agerange'=> 'Age Range'
		);
		foreach($q->result() as $row)
		{
			if($row->cr_barangay===$bname)
				$arrData[]=array(
						'cr_barangay'=> $row->cr_barangay,
						'pateintcount'=> $row->pateintcount,
						'agerange'=> $row->agerange,
				);
		}
		return $arrData;
	}	
}

/* End of file user/mapform.php */
/* Location: ./application/controllers/user/mapform.php */