<?php 
class Mapping extends CI_Model
{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
	function addPolygon($id,$lat,$lng,$name)
		{
			$qString = 'CALL '; 
			$qString .= "add_polygonPoint("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$id . "," . 
			$lat . "," . 
			$lng . ",'" .
			$name . "'". ")";
			$query = $this->db->query($qString);
		}
	function delPolygon($name)
		{
			$qString = 'CALL '; 
			$qString .= "delete_polygon('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedur
			$name . "'". ")";
			echo $qString;
			$query = $this->db->query($qString);
		}
	function getPolygonNumberMax()
		{
			$qString = 'CALL getMAX_polygon_number';
			$query = $this->db->query($qString);
			foreach ($query->result() as $row)
			{
				$data=$row->polygon_ID;
			}
			return $data;
		}
	function mapByType($data)
		{
			if($data['node_type']=="larvalpositive")
			{
				
				//echo $data['node_type'];			
				$qString = 'CALL '; 
				$qString .= "view_nodes_type('"; // name of stored procedure
				$qString .= 
				//variables needed by the stored procedure
				$data['date1']. "','". 
				$data['date2']. "'". ")";
				
				$q = $this->db->query($qString);
				//*
				if($q->num_rows() > 0) 
				{	$data = "";
					foreach ($q->result() as $row) 
					{
						$data .=
						"larvalpositive" . "&&" . 
						$row->ls_no . "&&" . 
						$row->ls_lat . "&&" . 
						$row->ls_lng . "&&" . 
						$row->tracking_number . "&&" . 
						$row->ls_household . "&&" .
						$row->ls_container . "&&" .
						$row->created_on . "%%" ;
					}
					$q->free_result();
					return substr($data,0,-2);
				}
				else
				{
					$q->free_result();
					return 0;
				}
			}
			else if($data['node_type']=="denguecase")
			{
				$qString = 'CALL '; 
				$qString .= "get_all_polygon_points ()"; // name of stored procedure
				
				$q = $this->db->query($qString);
				//*
				if($q->num_rows() > 0) 
				{	$data2 = "";
					foreach ($q->result() as $row) 
					{
						
							$data2 .=
							$row->polygon_ID . "&&" . 
							$row->point_lat . "&&" . 
							$row->point_lng . "&&" . 
							$row->polygon_name . "%%" ;
					}
					
					$q->free_result();
					return substr($data2,0,-2);
				}
				else
				{
					$q->free_result();
					return 0;
				}
				
			}
			else
			{
				//QUERY LARVAL INFORMATION
				$qString = 'CALL ';
				$qString .= "view_nodes_type('"; // name of stored procedure
				$qString .=
				//variables needed by the stored procedure
				$data['date1']. "','".
				$data['date2']. "'". ")";
				
				$q = $this->db->query($qString);
				//*
				if($q->num_rows() > 0)
				{	$data = "";
				foreach ($q->result() as $row)
				{
					$data .=
					"larvalpositive" . "&&" . 
					$row->ls_no . "&&" . 
					$row->ls_lat . "&&" . 
					$row->ls_lng . "&&" . 
					$row->tracking_number . "&&" . 
					$row->ls_household . "&&" .
					$row->ls_container . "&&".
					$row->created_on . "%%"  ;
				}
				$q->free_result();
				$data = substr($data,0,-2);
				}
				else
				{
					$data = "";
					$q->free_result();
					//return null;
				}
				
				//QUERY POLYGON INFORMATION
				$qString = 'CALL ';
				$qString .= "get_all_polygon_points ()"; // name of stored procedure
				
				$q = $this->db->query($qString);
				//*
				$data .= "%&";
				if($q->num_rows() > 0)
				{	
				foreach ($q->result() as $row)
				{
				
					$data .=
					$row->polygon_ID . "&&" .
					$row->point_lat . "&&" .
					$row->point_lng . "&&" .
					$row->polygon_name . "%%" ;
				}
					
				$q->free_result();
				$data = substr($data,0,-2);
				}
				else
				{
					$q->free_result();
					//return null;
				}
				return $data;
			}
			//*/
		}
		//*
	function calculateDistanceFormula($data)
		{
			//QUERY LARVAL INFORMATION
			$qString = 'CALL ';
			$qString .= "view_nodes_type('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data['date1']. "','".
			$data['date2']. "'". ")";
			
			$q = $this->db->query($qString);
			//*
			$data=[];
			$ctr=0;
			if($q->num_rows() > 0) 
			{	
				foreach ($q->result() as $row) 
				{
					$data[$ctr][0] =$row->tracking_number;
					$data[$ctr][1] =$row->ls_lat;
					$data[$ctr][2] =$row->ls_lng;
					$ctr++;
				}
			}
			else
			{
				$data[0][0]=0;
				$data[0][1]=0;
				$data[0][2]=0;
			}
			$dist="";
			//echo count($data);
			for($i=0;$i<=count($data)-1;$i++)
			{
				$amount200a=0;
				$amount200p=0;
				$amount50a=0;
				$amount50p=0;
				$distance;
				for($_i=0;$_i<=count($data)-1;$_i++)
				{
					$distance=0;
					if($data[$i][0]===$data[$_i][0])
					{
					}
					else
					{
						//echo "Comparing ".$data[$i][0]." and ".$data[$_i][0]." ";
						$lat_a = $data[$i][1] * PI()/180;
				        $lat_b = $data[$_i][1] * PI()/180;
				        $long_a = $data[$i][2] * PI()/180;
				        $long_b = $data[$_i][2] * PI()/180;
				        $distance =
				                acos(
				                        sin($lat_a ) * sin($lat_b) +
				                        cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
				                ) * 6371;
				        $distance*=1000;
                		if ($distance<=50)
						{
							$amount50a++;
							$amount200a++;
						}
						else if ($distance<=200)
						{
							$amount200a++;
						}
					}
				}
				$amount200p=100*number_format($amount200a/count($data),2,'.','');
				$amount50p=100*number_format($amount50a/count($data),2,'.','');
				/*
				$dist[$i][0]=$data[$i][0];
				$dist[$i][1]=$amount200a;
				$dist[$i][2]=$amount200p;
				$dist[$i][3]=$amount50a;
				$dist[$i][4]=$amount50p;
				//*/
				$dist.=$data[$i][0]."&&".$amount200a."&&".$amount200p."&&".$amount50a."&&".$amount50p."%%";
			}
			return substr($dist,0,-2);;
		}
		/*
	function mapAllPolygon()//all polygons
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_all_polygon_points ()'"; // name of stored procedure
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{	
				$greaterdata;
				$data = "";
				$name= $q[0]->polygon_name;
				foreach ($q->result() as $row) 
				{
					if($name == $row->polygon_name)
					{
						$data .=
						$row->polygon_name . "&&" . 
						$row->point_lat . "&&" . 
						$row->point_lng . "%%" ;
					}
					else 
					{
						$greaterdata[]=array
						(
							$row->node_type=>$row->node_type
						);
					}
					$name= $row->polygon_name;
				}
				
				$q->free_result();
				return $greaterdata;
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}
		//*/
		function getBarangayAges($data2)
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_case_ages('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['date1']. "','".
			$data2['date2']. "'". ")";
			$qString." END ";
			$data[]=array(
				'cr_barangay'=>'Barangay',
				'pateintcount'=> 'Patient Count',
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
						$agerange
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
		function getBarangayCount($data2)
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_empty_barangays()";
			$q = $this->db->query($qString);
			//*
			$data = "";
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->barangay . "&&0&&0%%";
				}
			}
			$q->free_result();
			
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_brangay_count('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data2['date1']. "','". 
			$data2['date2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->barangay . "&&" . 
					$row->amount . "&&" . 
					$row->polygon_ID . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return substr($data,0,-2);
			}
			//*/
		}
		function getBarangayInfo($data2)
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_empty_barangays()";
			$q = $this->db->query($qString);
			//*
			$data = "";
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->barangay . "&&0&&0&&0&&0&&0&&0&&0&&0%%";
				}
			}
			$q->free_result();
				
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_brangay_count('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['date1']. "','".
			$data2['date2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->barangay . "&&" .
					$row->gendF . "&&" .
					$row->gendM . "&&" .
					$row->ageMin . "&&" .
					$row->ageMax . "&&" .
					$row->ageAve . "&&" .
					$row->outA . "&&" .
					$row->outD . "&&" .
					$row->outU . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return substr($data,0,-2);
			}
			//*/
		}
		function getBarangays()
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_barangays("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data[$row->barangay]= $row->barangay;
				}
				
				$q->free_result();
				//print_r($data);
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function getAllBarangays()
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_allbarangays("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data[$row->barangay]= $row->barangay;
				}
				
				$q->free_result();
				//print_r($data);
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function getNodes($data2)
		{
			
			//echo $data['node_type'];			
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
					$data .=
					$row->polygon_ID . "&&" .
					$row->cr_barangay . "&&" . 
					$row->amount . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function getLarvals($data2)
		{
			
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "view_nodes_type('"; // name of stored procedure
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
					$data .=
					$row->created_on . "&&" .
					$row->ls_lat . "&&" . 
					$row->ls_lng . "&&" .
					$row->ls_result . "&&" .
					$row->ls_household . "&&" .
					$row->ls_container . "&&" . 
					$row->ls_updated_by . "&&" . 
					$row->ls_updated_on . "&&" . 
					$row->tracking_number . "%%" ;
				}
				$q->free_result();
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}
}

/* End of mapping.php */
/* Location: ./application/models/mapping.php */