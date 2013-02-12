<?php 
class Larval_survey extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	
	//stored proc
	function addLS_report($data){
			
		$qString = 'CALL '; 
		$qString .= "add_ls_report ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['TPcreatedby-txt'] . "','" . 
			$data['TPcreatedon-txt'] . "','" . 
			$data['TPlastupdatedby-txt'] ."','".
			$data['TPlastupdatedon-txt']. "','".
			$data['TPcontainer-txt'] . "','". 
			$data['TPhousehold-txt'] . "','" . 1234412 . "', '" . 
			$data['TPresult-rd'] . "','" .
			$data['TPbarangay-txt'] . "','" . 
			$data['TPdate-txt'] . "','".
			$data['TPinspector-txt'] . "','". 
			$data['TPmunicipality-txt'] . "','" . 1234412 . "', '" .
			$data['TPstreet-txt'] . "'". ")";
			
		$query = $this->db->query($qString);
	}
	
	function add($data)
	{
		$header_data = array(
						'ls_inspector'		=>	$data['TPinspector-txt'],
						'ls_date'			=>	$data['TPdate-txt'],
						'ls_barangay'		=>	$data['TPbarangay-txt'],
						'ls_street'			=>	$data['TPstreet-txt'],
						'ls_municipality'	=>	$data['TPmunicipality-txt'],
						);
		$query_header = $this->db->get_where('ls_report_header', $header_data);
		$header_data = $query_header->row_array();
		if ($query_header->num_rows() > 0) //if there is data about the header
		{
			// Add data to ls_report_main
			$insert_main_data = array(
					'ls_no'				=>	$header_data['ls_no'],
					'ls_household'		=>	$data['TPhousehold-txt'],
					'ls_result'			=>	$data['TPresult-rd'],
					'ls_container'		=>	$data['TPcontainer-txt'],
					'ls_lat'			=>	$data['lat'],
					'ls_lng'			=>	$data['lng'],
					'created_by'		=>	$data['TPcreatedby-txt'],
					'created_on'		=>	$data['TPcreatedon-txt'],
					'last_updated_by'	=>	$data['TPlastupdatedby-txt'],
					'last_updated_on'	=>	$data['TPlastupdatedon-txt']
			);
				
			$this->db->insert('ls_report_main', $insert_main_data);
		}
		
		else // if no data about header
		{
			// Add data to ls_report_header
			$insert_header_data = array(
					'ls_inspector'		=>	$data['TPinspector-txt'],
					'ls_date'			=>	$data['TPdate-txt'],
					'ls_barangay'		=>	$data['TPbarangay-txt'],
					'ls_street'			=>	$data['TPstreet-txt'],
					'ls_municipality'	=>	$data['TPmunicipality-txt'],
				);
			
			$this->db->insert('ls_report_header', $insert_header_data);
			
			$query_inserted_header_data = $this->db->get_where('ls_report_header', $insert_header_data);
			$inserted_header_data = $query_inserted_header_data->row_array();
			
			// Add data to ls_report_main
			$insert_main_data = array(
					'ls_no'				=>	$inserted_header_data['ls_no'],
					'ls_household'		=>	$data['TPhousehold-txt'],
					'ls_result'			=>	$data['TPresult-rd'],
					'ls_container'		=>	$data['TPcontainer-txt'],
					'ls_lat'			=>	$data['lat'],
					'ls_lng'			=>	$data['lng'],
					'created_by'		=>	$data['TPcreatedby-txt'],
					'created_on'		=>	$data['TPcreatedon-txt'],
					'last_updated_by'	=>	$data['TPlastupdatedby-txt'],
					'last_updated_on'	=>	$data['TPlastupdatedon-txt']
				);
			
			$this->db->insert('ls_report_main', $insert_main_data);
		}
	}
	function searchcase($data)
	{
		$qString = 'CALL ';
		$qString .= "view_larvalreport ('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data['TPtrack-txt'] . "','" .
		$data['TPdatefrom-txt']. "','".
		$data['TPdateto-txt'] . "','".
		$data['TPsort-dd'] . "'". ")";
			
		$q = $this->db->query($qString);
			
		$data2[]=array(
				'tracking_number'=>'Tracking Number',
				'ls_household'=> 'Name of Household',
				'ls_container'=> 'Container',
				'created_by'=> 'Submitted By',
				'created_on'=> 'Submitted On',
		);
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) {
				$date= explode ('-', $row->created_on);
					
				$data2[]=array(
						'tracking_number'=> anchor(base_url('index.php/larval_survey/view_survey/').'/'. $row->tracking_number ,  $row->tracking_number  , 'target="_blank"'),
						'ls_household'=>$row->ls_household ,
						'ls_container'=> $row->ls_container,
						'created_by'=> $row->created_by,
						'created_on'=> $date[1].'/'.$date[2].'/'.$date[0],
				);
			}
		}
		else
		{
			$data2[] =array(
					'tracking_number'=> '</td><td align="center" colspan="13">No Results Found',
			);
		}
		$q->free_result();
		return $data2;
	}
	
	function getReportInfo($data)
	{
		$qString = 'CALL ';
		$qString .= "get_larvalreport ('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
			
		$data['track'] . "'". ")";
			
		$q = $this->db->query($qString);
			
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) {
				$date= explode ('-', $row->created_on);
				$data = array(
						'tracking' => $row->tracking_number,
						'TPhousehold-txt' => $row->ls_household,
						'TPresult-rd' =>$row->ls_result,
						'TPcontainer-txt' => $row->ls_container,
						'TPcreatedby-txt' =>$row->created_by,
						'TPcreatedon-txt' => $date[1].'/'.$date[2].'/'.$date[0],
				);
					
			}
		}
		else
		{
			$data[] =null;
		}
		$q->free_result();
		return $data;
	}
	function updateResult($data)
	{
		$qString = 'CALL ';
		$qString .= "update_larval_survey ('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data['track'] . "','" .
		$data['result'] . "'". ")";
			
		$q = $this->db->query($qString);
			
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) {
				$date= explode ('-', $row->created_on);
				$data = array(
						'tracking' => $row->tracking_number,
						'TPhousehold-txt' => $row->ls_household,
						'TPresult-rd' =>$row->ls_result,
						'TPcontainer-txt' => $row->ls_container,
						'TPcreatedby-txt' =>$row->created_by,
						'TPcreatedon-txt' => $date[1].'/'.$date[2].'/'.$date[0],
				);
					
			}
		}
		else
		{
			$data[] =null;
		}
		$q->free_result();
		return $data;
	}
}

/* End of larval_survey.php */
/* Location: ./application/models/larval_survey.php */