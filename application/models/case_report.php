<?php 
	
	class Case_report extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function addCase($data){
			
			$qString = 'CALL '; 
			$qString .= "add_case ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['TPadmitted-rd'] . "','" . 
			$data['TPbarangay-txt'] . "','" . 
			$data['TPcity-txt'] ."','".
			$data['TPclassification-rd']. "','".
			$data['TPconsuldate-txt'] . "','". 
			$data['TPillnessdate-txt'] . "','" . 
			$data['TPbirthdate-txt'] . "','" . 
			$data['TPfirstname-txt'] . "','" .
			$data['TPlastname-txt'] . "','" . 
			$data['TPcrno-txt'] . "','" . 
			$data['TPoutcome-rd'] . "','" .
			$data['TPpatientno-txt'] . "','" . 
			$data['TPprovince-txt'] . "','".
			$data['TPsex-dd'] . "','". 
			$data['TPstreet-txt'] . "','" .
			$data['TPtype-rd'] . "','" . 
			'test'. "','". 
			date('Y-m-d') . "', '" . //change to system date
			'test' . "', '" . 
			date('Y-m-d') . "','".  //change to system date
			$data['TPaddress-txt'] . "','" . 
			$data['TPcity2-txt'] . "','" . 
			$data['TPdru-txt'] ."','".
			$data['TPprovince2-txt']. "','".
			$data['TPregion-txt'] . "','". 
			$data['TPage-txt'] . "','". 
			$data['TPdateofentry-txt']. "'". ")";
			$query = $this->db->query($qString);
			$query->free_result();
		}
		function searchcase($data)
		{
			$qString = 'CALL '; 
			$qString .= "view_casereport ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['TPdru-txt'] . "','" . 
			$data['TPcity-txt'] . "','" .
			$data['TPdatefrom-txt']. "','".
			$data['TPdateto-txt'] . "','". 			
			$data['TPsort-dd'] . "'". ")";
			
			$q = $this->db->query($qString);
			
			$data2[]=array(
				'cr_no'=>'Case Report No.',
				'cr_city'=> 'City',
				'cr_name_dru'=> 'DRU',
				'cr_address'=> 'Address',
				'created_on'=> 'Submitted On',
				);
			if($q->num_rows() > 0) 
			{
			foreach ($q->result() as $row) {
			$date= explode ('-', $row->created_on);
			
			$data2[]=array(
				'cr_no'=> anchor(base_url('index.php/case_report/view_patients/').'/'. $row->cr_no ,  $row->cr_no  , 'target="_blank"'),
				'cr_city'=>$row->cr_city ,
				'cr_name_dru'=> $row->cr_name_dru,
				'cr_address'=> $row->cr_address,
				'created_on'=> $date[1].'/'.$date[2].'/'.$date[0],
				);
			}
			}
			else
			{
			$data2[] =array(
				'cr_no'=> '</td><td align="center" colspan="13">No Results Found',
				);
				}
			 $q->free_result();  
			return $data2;
		}
		function viewPatients($data)
		{
			$qString = 'CALL '; 
			$qString .= "view_patients ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			
			$data['patientno'] . "'". ")";
			
			$q = $this->db->query($qString);
			
			$data2[]=array(
				'cr_patient_no'=>'Patient No.',
				'cr_name'=> 'Patient Name',
				'cr_dob'=> 'Date of birth',
				'cr_address'=> 'Address',
				'cr_date_onset'=> 'Date onset of illness',
				);
			if($q->num_rows() > 0) 
			{
			foreach ($q->result() as $row) {
			$date= explode ('-', $row->cr_dob);
			$date2= explode ('-', $row->cr_date_onset);
			
			$data2[]=array(
				'cr_patient_no'=>anchor(base_url('index.php/case_report/update_patient').'/'. $row->cr_patient_no ,  $row->cr_patient_no  , 'target="_blank"'),
				'cr_name'=> $row->cr_last_name . ", ". $row->cr_first_name,
				'cr_dob'=> $date[1].'/'.$date[2].'/'.$date[0],
				'cr_address'=>$row->cr_street . " " . $row->cr_barangay . " " . $row->cr_city . " " . $row->cr_province,
				'cr_date_onset'=> $date2[1].'/'.$date2[2].'/'.$date2[0],
				);
			}
			}
			else
			{
			$data2[] =array(
				'cr_no'=> '</td><td align="center" colspan="13">No Results Found',
				);
				}
			 $q->free_result();  
			return $data2;
		}
		function getPatientInfo($data)
		{
			$qString = 'CALL '; 
			$qString .= "get_patient_info ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			
			$data['patientno'] . "'". ")";
			
			$q = $this->db->query($qString);
			
			if($q->num_rows() > 0) 
			{
			foreach ($q->result() as $row) {
			$date= explode ('-', $row->cr_dob);
			$date2= explode ('-', $row->cr_date_onset);
			$date3= explode ('-', $row->cr_date_admitted);
			
			$data = array(
			'TPpatientno-txt' => $row->cr_patient_no,
			'TPfirstname-txt' => $row->cr_first_name,
			'TPlastname-txt' =>$row->cr_last_name,			
			'TPage-txt' => $row->cr_age,
			'TPsex-dd' =>$row->cr_sex,
			'TPbirthdate-txt' => $date[1].'/'.$date[2].'/'.$date[0],
			'TPcity-txt' => $row->cr_city,
			'TPbarangay-txt' => $row->cr_barangay,
			'TPstreet-txt' => $row->cr_street,	
			'TPadmitted-rd' => $row->cr_admitted,
			'TPconsuldate-txt' => $date3[1].'/'.$date3[2].'/'.$date3[0],
			'TPillnessdate-txt' => $date2[1].'/'.$date2[2].'/'.$date2[0],
			'TPclassification-rd'=> $row->cr_classification,
			'TPtype-rd'=>$row->cr_type,
			'TPprovince-txt' => $row->cr_province,
			'TPoutcome-rd'=>$row->cr_outcome
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
		function updatePatientInfo($data)
		{
			
			$qString = 'CALL '; 
			$qString .= "update_patient_info ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['TPadmitted-rd'] . "','" . 
			$data['TPbarangay-txt'] . "','" . 
			$data['TPcity-txt'] ."','".
			$data['TPclassification-rd']. "','".
			$data['TPconsuldate-txt'] . "','". 
			$data['TPillnessdate-txt'] . "','" . 
			$data['TPbirthdate-txt'] . "','" . 
			$data['TPfirstname-txt'] . "','" .
			$data['TPlastname-txt'] . "','" . 
			$data['TPoutcome-rd'] . "','" .
			$data['TPpatientno-txt'] . "','" . 
			$data['TPprovince-txt'] . "','".
			$data['TPsex-dd'] . "','". 
			$data['TPstreet-txt'] . "','" .
			$data['TPtype-rd'] . "','" . 
			'test'. "','". 
			date('Y-m-d') . "', '" . //change to system date
			$data['TPage-txt'] . "'". ")";
			
			
			$query = $this->db->query($qString);
		}
		function get_report_data_age($data)
		{
			$qString = 'CALL '; 
			$qString .= "get_report_data_age ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			
			$data['year'] . "'". ")";
			
			$q = $this->db->query($qString);
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->patientcount . "&&" . 
					$row->sex . "&&" . 
					$row->agerange  . "%%" ;
				}
				
				return $data;
			}
			else
			{
				return 0;
			}
		}
		function get_report_data_cases($data)
		{
			$qString = 'CALL '; 
			$qString .= "get_report_data_cases ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			
			$data['year'] . "'". ")";
			
			$q = $this->db->query($qString);
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->num . "&&" .  
					$row->month  . "&&" .
					$row->year2 .   "%%" ;
				}
				
				return $data;
			}
			else
			{
				return 0;
			}
		}
		
	}

/* End of case_report.php */
/* Location: ./application/models/case_report.php */