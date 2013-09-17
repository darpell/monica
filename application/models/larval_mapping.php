<?php 
class Larval_mapping extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	// returns the all larval points
	function get_points($begin_date = FALSE, $end_date = FALSE, $place = NULL, $value = NULL)
	{
		//$this->db->select('ls_barangay, ls_street, ls_municipality, ls_household, ls_container, ls_result, created_on, ls_lat, ls_lng');
			$this->db->from('ls_report_main');
			$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
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
		// http://stackoverflow.com/questions/4875668/codeigniter-getting-data-posted-in-between-two-dates
		// http://stackoverflow.com/questions/7215834/how-to-write-this-query-with-codeigniter
		$this->db->where("created_on BETWEEN '$begin_date' AND '$end_date'");
			$query = $this->db->get();
			return $query->result_array();
			$query->free_result();
	}
	
	function check_place($place)
	{
		if ($place == 'brgy')
		{
			return 'ls_barangay';
		}
		else if ($place == 'city')
		{
			return 'ls_municipality';
		}
		else if ($place == 'street')
		{
			return 'ls_street';
		}
	}
	
	function get_brgys()
	{
		$this->db->select('ls_barangay');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_barangay');
		
		return $this->db->get()->result_array();
	}
	
	function get_cities()
	{
		$this->db->select('ls_municipality');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_municipality');
		
		return $this->db->get()->result_array();
	}
	
	function get_streets()
	{
		$this->db->select('ls_street');
		$this->db->from('ls_report_header');
		$this->db->group_by('ls_street');
		
		return $this->db->get()->result_array();
	}
	
	function get_last_visit($user)
	{
		// prior to db v33_1
		/*
		$this->db->select('ls_date, ls_barangay');
			$this->db->from('ls_report_header');
			$this->db->where('ls_inspector', $user);
			$this->db->order_by('ls_date','desc');
			*/
		// after db v33_1
		$this->db->select('last_updated_on, ls_barangay');
			$this->db->from('ls_report');
			$this->db->where('created_by', $user);
			$this->db->order_by('last_updated_on','desc');
			$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row;
		}
		return NULL;
	}
	
	function get_oldest_date()
	{
		$this->db->select('created_on');
			$this->db->from('ls_report_main');
			$this->db->order_by('created_on','asc');
			$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row['created_on'];
		}
		return NULL;
	}
	
	function distance_formula($given_distance, $start_date = FALSE, $end_date = FALSE)
	{
		$return_data = [];
		if ($start_date === FALSE || $end_date === FALSE)
		{
			$this->db->from('ls_report_main');
				$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
				$this->db->group_by('tracking_number');
				$query = $this->db->get();
		}
		else
		{
			$this->db->from('ls_report_main');
				$this->db->join('ls_report_header', 'ls_report_main.ls_no = ls_report_header.ls_no');
				$this->db->where("last_updated_on BETWEEN '$start_date' AND '$end_date'");
				$this->db->group_by('tracking_number');
				$query = $this->db->get();
		}
		
		if ($query->num_rows > 0)
		{
			$ctr = 0;
			foreach ($query->result_array() as $row)
			{
				$data[$ctr]['track_no'] = $row['tracking_number'];
				$data[$ctr]['lat'] = $row['ls_lat'];
				$data[$ctr]['lng'] = $row['ls_lng'];
				$ctr++;
			}
		}
		
		$array_ctr = count($data);
		for ($i = 0; $i < $array_ctr; $i++)
		{
			$amount = 0;
			$lat_a = $data[$i]['lat'] * PI() / 180;
			$long_a = $data[$i]['lng'] * PI() / 180;
			
			for ($_i = 0; $_i < $array_ctr; $_i++)
			{
				if ($data[$i]['track_no'] === $data[$_i]['track_no']) {}
				else
				{
								//echo "Comparing ".$data[$i][0]." and ".$data[$_i][0]." ";
					$lat_b = $data[$_i]['lat'] * PI() / 180;
					$long_b = $data[$_i]['lng'] * PI() / 180;
					$distance = acos (
									sin($lat_a ) * sin($lat_b) +
									cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
									) * 6371;
					$distance *= 1000;
					if ($distance <= $given_distance)
					{
						$amount++;
					}
				}
			}
		
		$percentage = 100 * number_format($amount / count($data), 2, '.', '');
		
		//$dist.=$data[$i][0]."&&".$amount200a."&&".$amount200p."&&".$amount50a."&&".$amount50p."%%";
		
		
		array_push($return_data, array(	'tracking_no' => $data[$i]['track_no'],
		'amount' => $amount,
		'percentage' => $percentage)
		);
		
		// return array('tracking_no' => '', 'amount' => '', 'percentage' => '');
		}
		return $return_data;
	}
}


/* End of larval_mapping.php */
/* Location: ./application/models/larval_mapping.php */