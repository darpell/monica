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
}

/* End of remap.php */
/* Location: ./application/models/remap.php */