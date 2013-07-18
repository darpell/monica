<?php 
class Remap_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_map_nodes($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		//$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
		$this->db->from('map_nodes');
		if ($place != NULL && $place != 'NULL')
		{
			$this->db->where($this->check_place($place),$value);
		}
			
		if ($begin_date === FALSE && $end_date === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
		}
		
		$this->db->where("node_addedOn BETWEEN '$begin_date' AND '$end_date'");
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_polygon_nodes($place = NULL)
	{
		if ($place === NULL)
		{
			$query = $this->db->get('map_polygons');
			return $query->result_array();
			$query->free_result();
		}
		$query = $this->db->get_where('map_polygons',array('polygon_name' => $place));
		return $query->result_array();
		$query->free_result();
	}
	
	function get_pidsr_case_count($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		//TODO
		$this->db->select('cr_barangay');
		$this->db->select('count()r_barangay');
		$this->db->from('case_report_main');
		$this->db->group_by('cr_barangay');
		$this->db->order_by('cr_barangay');
		if ($place != NULL && $place != 'NULL')
		{
			$this->db->where($this->check_place($place),$value);
		}
			
		if ($begin_date === FALSE && $end_date === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
		}
		
		//$this->db->where("node_addedOn BETWEEN '$begin_date' AND '$end_date'");
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_brgy_with_cases($begin_date = FALSE, $end_date = FALSE)
	{
		$this->db->select('cr_barangay');
		$this->db->from('case_report_main');
		$this->db->join('barangay','case_report_main.cr_barangay = barangay.barangay');
		$this->db->group_by('cr_barangay');
		$this->db->order_by('cr_barangay');
		
		if ($begin_date === FALSE && $end_date === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
		}
		
		$this->db->where("cr_date_onset BETWEEN '$begin_date' AND '$end_date'");
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function getBarangayAges($data2)
	{
		$qString = 'CALL ';
		$qString .= "get_case_ages('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data2['date1']. "','".
		$data2['date2']. "'". ")";
		$qString." END ";
		$data[]=array(
				'cr_barangay'=>'Barangay',
				'patientcount'=> 'Patient Count',
				'agerange'=> 'Age Range'
		);
	
		$q = $this->db->query($qString);
		//*
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$agerange=null;
				if($row->agerange*10==0)
				{
					$agerange = ($row->agerange*10)."-".(($row->agerange*10)+10);
				}
				else
					$agerange = ($row->agerange*10+1)."-".(($row->agerange*10)+10);
	
				$data[]=array(
						'cr_barangay'=> $row->cr_barangay,
						'patientcount'=> $row->patientcount,
						'agerange'=> $agerange
				);
			}
			$q->free_result();
			return $data;
		}
		else
		{
			$q->free_result();
			return $data;
		}
		//*/
	}
	
	function getDengueInfo($data2)
	{
		$qString = 'CALL ';
		$qString .= "get_brangay_count('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data2['date1']. "','".
		$data2['date2']. "'". ")";
			
		$q = $this->db->query($qString);
		//*
		if($q->num_rows() > 0)
		{	$data = "";
		foreach ($q->result() as $row)
			{
				$data[]=array(
						'polygon_ID'=> $row->polygon_ID,
						'barangay'=> $row->barangay,
						'amount'=> $row->amount,
						'gendF'=> $row->gendF,
						'gendM'=> $row->gendM,
						'ageMin'=> $row->ageMin,
						'ageMax'=> $row->ageMax,
						'ageAve'=> $row->ageAve,
						'outA'=> $row->outA,
						'outD'=> $row->outD,
						'outU'=> $row->outU
				);
			}
		$q->free_result();
		return $data;
		}
		else
		{
			$q->free_result();
			return 0;
		}
		//*/
	}

	function getRepeatingLarvals($data2)
	{
		$dataPres;
		$dataPresR[]=array();
		$dataPrev1;
		$dataPrev1R[]=array();
		$dataPrev2;
		$invariant1=true;
		$invariant2=true;
		$invariant3=true;
		
		$qString = 'CALL ';
		$qString .= "view_larval_nodes('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data2['datePresB']. "','".
		$data2['datePresE']. "'". ")";
		$q = $this->db->query($qString);
		//*
		if($q->num_rows() > 0)
		{	
			foreach ($q->result() as $row)
			{
				$dataPres[]=array(
						'ls_lat'=> $row->ls_lat,
						'ls_lng'=> $row->ls_lng,
						'ls_household'=> $row->ls_household,
						'ls_street'=> $row->ls_street,
						'ls_container'=> $row->ls_container,
						'ls_date'=> $row->ls_date,
						'created_by'=> $row->created_by
				);
			}
		}
		else
		{
			$invariant1=false;
		}
		$q->free_result();
		
		$qString = 'CALL ';
		$qString .= "view_larval_nodes('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data2['datePrev1B']. "','".
		$data2['datePrev1E']. "'". ")";
		$q = $this->db->query($qString);
		//*
		if($q->num_rows() > 0)
		{	
			foreach ($q->result() as $row)
			{
				$dataPrev1[]=array(
						'ls_lat'=> $row->ls_lat,
						'ls_lng'=> $row->ls_lng,
						'ls_household'=> $row->ls_household,
						'ls_street'=> $row->ls_street,
						'ls_container'=> $row->ls_container,
						'ls_date'=> $row->ls_date,
						'created_by'=> $row->created_by
				);
			}
		}
		else
		{
			$invariant2=false;
		}
		$q->free_result();
		
		$qString = 'CALL ';
		$qString .= "view_larval_nodes('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data2['datePrev2B']. "','".
		$data2['datePrev2E']. "'". ")";
		$q = $this->db->query($qString);
		//*
		if($q->num_rows() > 0)
		{	
			foreach ($q->result() as $row)
			{
				$dataPrev2[]=array(
						'ls_lat'=> $row->ls_lat,
						'ls_lng'=> $row->ls_lng,
						'ls_household'=> $row->ls_household,
						'ls_street'=> $row->ls_street,
						'ls_container'=> $row->ls_container,
						'ls_date'=> $row->ls_date,
						'created_by'=> $row->created_by
				);
			}
		}
		else
		{
			$invariant3=false;
		}
		$q->free_result();
		
		if($invariant2 && $invariant3)
		{
			foreach ($dataPrev2 as $oldkey => $value)
			{
				$lat_a=$value['ls_lat']* PI()/180;
				$long_a=$value['ls_lng']* PI()/180;				
				foreach($dataPrev1 as $key => $value2)
				{
					$lat_b = $value2['ls_lat'] * PI()/180;
					$long_b = $value2['ls_lng'] * PI()/180;
					$distance =
					acos(
							sin($lat_a ) * sin($lat_b) +
							cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
					) * 6371;
					$distance*=1000;
					if ($distance<=50)
					{
						array_push($dataPrev1R,$dataPrev1[$key]);
						unset($dataPrev1[$key]);
					}
				}
			}
		}
		if($invariant1 && $invariant2)
		{
			foreach ($dataPrev1 as $value)
			{
				$lat_a=$value['ls_lat']* PI()/180;
				$long_a=$value['ls_lng']* PI()/180;				
				foreach($dataPres as $key => $value2)
				{
					$lat_b = $value2['ls_lat'] * PI()/180;
					$long_b = $value2['ls_lng'] * PI()/180;
					$distance =
					acos(
							sin($lat_a ) * sin($lat_b) +
							cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
					) * 6371;
					$distance*=1000;
					if ($distance<=50)
					{
						array_push($dataPresR,$dataPres[$key]);
						unset($dataPres[$key]);
					}
						
				}
			}
			unset($dataPresR[0]);
			unset($dataPrev1R[0]);
			$dataReturn['presentData']=$dataPresR;
			$dataReturn['oldData']=$dataPrev1R;
			$dataReturn['olderData']=$dataPrev2;
			return $dataReturn;
		}
		elseif($invariant1)
		{
			$dataReturn['presentData']=$dataPres;
		}
		elseif($invariant2)
		{
			unset($dataPrev1R[0]);
			$dataReturn['oldData']=$dataPrev1R;
		}
		$dataReturn['olderData']=$dataPrev2;
		$dataReturn['presentDataExists']=$invariant1;
		$dataReturn['oldDataExists']=$invariant2;
		$dataReturn['olderDataExists']=$invariant3;
		return $dataReturn;
	}
	
	function investigated_cases($data)
	{
		$this->db->from('investigated_cases');
		$this->db->join('case_report_main','investigated_cases.case_no = case_report_main.cr_no');
		$where="";
		if($data['barangay']===null)
		{
			$where="cr_date_onset BETWEEN ".$data['dateSel1']." AND ".$data['dateSel2'];
		}
		else
		{
			$where="cr_date_onset BETWEEN ".$data['dateSel1']." AND ".$data['dateSel2']." AND (";
			foreach ($data['barangay'] as $value)
			{
				$where.="cr_barangay=".$value." OR";
			}
			$where=substr($where, 0, -2).")";
		}
		$this->db->where($where);
		$q = $this->db->get();
		
		$dataReturn['data_exists']=false;
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$dataCases[]=array(
						'ic_lat'=> $row->lat,
						'ic_lng'=> $row->lng,
						'ic_feedback'=> $row->feedback,
						'ic_fname'=> $row->cr_first_name,
						'ic_lname'=> $row->cr_last_name,
						'ic_dateOnset'=> $row->cr_date_onset,
						'ic_age'=> $row->cr_age,
						'ic_barangay'=> $row->cr_barangay
				);
			}
			$dataReturn['data_exists']=true;
			$dataReturn['dataCases']=$dataCases;
		}
		$q->free_result();
		return $dataReturn;
	}
}

/* End of remap.php */
/* Location: ./application/models/remap.php */