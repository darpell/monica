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
						$row->ls_lng . "%%" ;
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
					$row->ls_lng . "%%" ;
				}
				$q->free_result();
				$data = substr($data,0,-2);
				}
				else
				{
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
	/*
	function mapPolygon($data)
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "get_polygon_points ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['polygon_name'] . "'". ")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->polygon_name . "&&" . 
					$row->point_lat . "&&" . 
					$row->point_lng . "%%" ;
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
		/*
		function getNodeInfo($data)
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "view_node_info ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['reference_no'] . "'". ")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->node_type . "&&" . 
					$row->reference_no . "&&" . 
					$row->node_lat . "&&" . 
					$row->node_lng . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}//*/
		function getBarangayCount($data2)
		{
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
			{	$data = "";
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
				return 0;
			}
			//*/
		}
		/*function getNodeTypes()
		{
			//echo $data['node_type'];			
			$qString = 'CALL '; 
			$qString .= "view_node_types("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data[]=array
					(
						$row->node_type=>$row->node_type
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
			
		}//*/
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
					$data[]=array
					(
						$row->cr_barangay=>$row->cr_barangay
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
					$row->ls_updated_on . "%%" ;
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