<?php 
	
	class midwife extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		function get_cases($brgy)
		{
			//$date = date('Y-m-d');
			$date = '2013-07-01';
			
			$data = array (date('Y') => 0,(date('Y')-1) => 0);
			$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear  
					FROM (`case_report_main`) 
					WHERE
					(YEAR( cr_date_onset ) = YEAR('".$date."') OR YEAR( cr_date_onset )= YEAR('".$date."')-1 )
					AND month(cr_date_onset) = month('".$date."')
					AND cr_barangay = '" . $brgy . "'
					GROUP BY YEAR(`cr_date_onset`)";
			$this->db->select($where);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ $x = $row->caseyear;
					$data[$x] = $row->patientcount;
				}
			}
			
			return $data;
			$q->free_result();
			
		}
		
		function get_households($bhw = FALSE,$midwife = FALSE)
		{	
			if ($bhw == FALSE)
			{
				$barangay = $this->get_barangay_midwife($midwife);
				
				$this->db->from('catchment_area');
				$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
				$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
				$this->db->join('users','users.user_username = bhw.user_username');
				$this->db->where('barangay', $barangay);
				$this->db->group_by('household_address.house_no');
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
			else
			{
				$this->db->from('catchment_area');
				$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
				$this->db->where('catchment_area.bhw_id',$bhw);
				$this->db->group_by('household_address.house_no');
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
		}
		
		function add_household($household,$houseno,$street)
		{
			$data = array(
					'household_name' => $household ,
					'house_no' => $houseno ,
					'street' => $street
			);
			
			$this->db->insert('household_address', $data);
			$this->db->select_max('household_id');
			
			$query = $this->db->get('household_address');
			$query = $query->result_array();
			return $query[0]['household_id'];

		}
		function add_catchment_area($houseid,$person_id,$bhw)
		{
			$data = array(
					'household_id' => $houseid ,
					'person_id' => $person_id,
					'bhw_id' => $bhw,
					'last_visited_on' => '0000-00-00',
			);
				
			$this->db->insert('catchment_area', $data);
		}
		function add_masterlist($data)
		{
			
			$this->db->insert('master_list', $data);
			
			$this->db->select_max('person_id');
			$query = $this->db->get('master_list');
			$query = $query->result_array();
			return $query[0]['person_id'];
		
		}
		function add_masterlist_midwife($house_id,$data)
		{
			$this->db->from('catchment_area');
			$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->where('catchment_area.household_id', $house_id);
			$this->db->group_by('household_address.house_no');
			$query = $this->db->get();
			$query = $query->result_array();
			$bhw =  $query[0]['user_username'];
			
			$person_id = $this->add_masterlist($data);
			
			$this->add_catchment_area($house_id, $person_id,$bhw );
		}
		function get_masterlist($bhw = FALSE,$midwife = FALSE)
		{
			$this->db->from('master_list');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
				
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{	
				if( $bhw != FALSE){
					foreach ($q->result() as $row)
					{
						if($bhw === $row->bhw_id)
						{
						$name = $row->person_first_name . ' ' . $row->person_last_name;
						$date= explode ('-', $row->person_dob);
						if( $row->person_blood_type === null || $row->person_blood_type == 'null')
						$bloodtype = 'Not Indicated';
						else
						$bloodtype = $row->person_blood_type;
						$data[$row->household_id][] =array(
								'Name' => $name ,
								'Birthday'=>$date[1].'/'.$date[2].'/'.$date[0]  ,
								'Gender'=> $row->person_sex,
								'Marital Status'=> $row->person_marital,
								'Nationality'=> $row->person_nationality,
								'Blood type'=> $bloodtype,
						);
						}
					}
				}
				else {
					foreach ($q->result() as $row)
					{
							$name = $row->person_first_name . ' ' . $row->person_last_name;
							$date= explode ('-', $row->person_dob);
							if( $row->person_blood_type === null || $row->person_blood_type == 'null')
								$bloodtype = 'Not Indicated';
							else
								$bloodtype = $row->person_blood_type;
							$data[$row->household_id][] =array(
									'Name' => $name ,
									'Birthday'=>$date[1].'/'.$date[2].'/'.$date[0]  ,
									'Gender'=> $row->person_sex,
									'Marital Status'=> $row->person_marital,
									'Nationality'=> $row->person_nationality,
									'Blood type'=> $bloodtype,
							);
						
					}
					
				}
					
				return $data;
			}
			else
			{
					return null;
			}
				
				$query->free_result();

		}
		function get_list($bhw, $person_id = FALSE)
		{
			/*
			$this->db->query('
						SELECT *
						FROM master_list ml 
						INNER JOIN catchment_area ca
							ON ml.person_id = ca.person_id
						INNER JOIN household_address ha
							ON ca.household_id = ha.household_id
						INNER JOIN bhw b
							ON b.user_username = ca.bhw_id
						
					');
			*/
			//$this->db->select();
			$this->db->from('master_list');
			$this->db->join('catchment_area','catchment_area.person_id = master_list.person_id','inner');
			$this->db->join('household_address','household_address.household_id = catchment_area.household_id','inner');
			$this->db->join('bhw','bhw.user_username = catchment_area.bhw_id','inner');
			$this->db->where('catchment_area.bhw_id',$bhw);
			
			if ($person_id === FALSE)
			{
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
			
			$query = $this->db->get_where('master_list.person_id','$person_id');
				return $query->row_array();
				$query->free_result();
			
		}
		function get_barangay_midwife($midwife)
		{
			$this->db->from('bhw');
			$this->db->where('user_username', $midwife);
			$query = $this->db->get();
			$query = $query->result_array();
			$barangay =  $query[0]['barangay'];
			return $barangay;
		}
		function get_barangay($midwife)
		{
			$this->db->from('bhw');
			$this->db->where('user_username', $midwife);
			$query = $this->db->get();
			$query = $query->result_array();
			$barangay =  $query[0]['barangay'];
			return $barangay;
		}

		function get_immediate_cases($midwife)
		{
			$barangay = $this->get_barangay_midwife($midwife);
			
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->where('bhw.barangay', $barangay);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
				
				$name = $row->person_first_name . ' ' . $row->person_last_name;
				$date = explode ('-', $row->created_on);
				$birthDate = explode ('-', $row->person_dob);
				$birthDate = $birthDate[1].'/'.$birthDate[2].'/'.$birthDate[0];
				//explode the date to get month, day and year
				$birthDate = explode("/", $birthDate);
				//get age from date or birthdate
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
					$data[] =array(
						'Name' => $name ,
						'Age' => $age,
						'Days Of Fever' => $row->days_fever ,
						'Muscle Pain' => $row->has_muscle_pain ,
						'Joint Pain' => $row->has_joint_pain ,
						'Head Ache' => $row->has_headache ,
						'Bleedling'  => $row->has_bleeding ,
						'Rashes' => $row->has_rashes ,
						'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0] ,
						'Remarks' => $row->remarks 
				);
				}
			}
			else $data = null;
			return $data;
		}
		
		function get_bhw_catchment($midwife)
		{
			$barangay = $this->get_barangay_midwife($midwife);
				
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->join('users','users.user_username = bhw.user_username');
			$this->db->where('bhw.barangay', $barangay);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
		
					$name = $row->person_first_name . ' ' . $row->person_last_name;
					$date = explode ('-', $row->created_on);
					$birthDate = explode ('-', $row->person_dob);
					$birthDate = $birthDate[1].'/'.$birthDate[2].'/'.$birthDate[0];
					//explode the date to get month, day and year
					$birthDate = explode("/", $birthDate);
					//get age from date or birthdate
					$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
					$data[] =array(
							'Name' => $name ,
							'Age' => $age,
							'Days Of Fever' => $row->days_fever ,
							'Muscle Pain' => $row->has_muscle_pain ,
							'Joint Pain' => $row->has_joint_pain ,
							'Head Ache' => $row->has_headache ,
							'Bleedling'  => $row->has_bleeding ,
							'Rashes' => $row->has_rashes ,
							'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0] ,
							'Remarks' => $row->remarks
					);
				}
			}
			else $data = null;
			return $data;
		}
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
