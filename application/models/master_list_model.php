<?php 
	
	class Master_list_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function add_immediate_cases()
		{
			$data = array(
					'person_id'			=> $this->input->post('person_id'),
					'has_muscle_pain'	=> $hmp = ($this->input->post('has_muscle_pain') == 'Y') ? 'Y' : 'N',
					'has_joint_pain'	=> $hjp = ($this->input->post('has_joint_pain') == 'Y') ? 'Y' : 'N',
					'has_headache'		=> $hh = ($this->input->post('has_headache') == 'Y') ? 'Y' : 'N',
					'has_bleeding'		=> $hb = ($this->input->post('has_bleeding') == 'Y') ? 'Y' : 'N',
					'has_rashes'		=> $hr = ($this->input->post('has_rashes') == 'Y') ? 'Y' : 'N',
					'days_fever'		=> $this->input->post('duration'),
					'suspected_source'	=> $this->input->post('source'),
					'remarks'			=> $this->input->post('remarks'),
					'imcase_lat'		=> $this->input->post('lat'),
					'imcase_lng'		=> $this->input->post('lng')
			);
			$this->db->set('created_on', 'NOW()', FALSE);
			$this->db->set('last_updated_on', 'NOW()', FALSE);
			$this->db->insert('immediate_cases', $data);
			
			// updates last_visited_on at `household_address`
			$hh = array(
					'last_visited' => date('Y-m-d')
			);
			
			$this->db->where('household_id',$this->input->post('household_id'));
			$this->db->update('household_address', $hh);
			
		}
		
		function get_households($bhw, $household_id = FALSE, $person_id = FALSE)
		{
			$this->db->from('catchment_area');
			$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
			
			if ($household_id === FALSE && $person_id === FALSE)
			{
				$this->db->where('catchment_area.bhw_id',$bhw);
				$this->db->group_by('household_address.house_no');
				$query = $this->db->get();
					return $query->result_array();
					$query->free_result();
			}
			else if ($household_id != FALSE && $person_id === FALSE)
			{
				$this->db->join('master_list','catchment_area.person_id = master_list.person_id','inner');
				$this->db->where('catchment_area.bhw_id',$bhw);
				$this->db->where('catchment_area.household_id',$household_id);
				$query = $this->db->get();
					return $query->result_array();
					$query->free_result();
			}
			else
			{
				$this->db->join('master_list','catchment_area.person_id = master_list.person_id','inner');
				$this->db->where('catchment_area.bhw_id',$bhw);
				$this->db->where('catchment_area.household_id',$household_id);
				$this->db->where('catchment_area.person_id',$person_id);
				$query = $this->db->get();
					return $query->result_array();
					$query->free_result();
			}
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
	}

/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
