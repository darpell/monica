<?php 
	
	class Cho_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function get_tasks()
		{
			
			$qString = 'CALL ';
			$qString .= "get_all_tasks ('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure	
			date('Y-m-d') . "'". ")";
				
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	$data =
				'Name' . "&&" .
				'Barangay' . "&&" .
				'Task Header' . "&&" .
				'Task' . "&&" .
				'Status' . "&&" .
				'Date Assigned'. "&&" .
				'Remarks'  . "%%" ;
			foreach ($q->result() as $row)
			{	if($row->date_accomplished == '0000-00-00' )
					$status = 'Not Done';
				else 
					$status = 'Completed';
				$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
				$date= explode ('-', $row->date_sent);
				$data .=
				$name . "&&" .
				$row->barangay . "&&" .
				$row->task_header . "&&" .
				$row->task . "&&" .
				$status . "&&" .
				$date[1].'/'.$date[2].'/'.$date[0]  . "&&" .
				$row->remarks . "%%" ;
				
			}
			
			return $data;
			}
			else
			{
				return 0;
			}
		}
		function get_pending_tasks()
		{
				
			$qString = 'CALL ';
			$qString .= "get_all_pending_tasks ()";
		
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	$data['table'][] =array(
				'Name' => 'Name'  ,
				'Barangay'=>'Barangay' ,
				'Task Header'=> 'Task Header',
				'Task'=> 'Task',
				'Date Assigned'=>'Date Assigned',
				'Approve'=>'Approve',
				'Deny'=>'Deny',
				 );
				$data['task'] = '';
			foreach ($q->result() as $row)
			{
			$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
			$date= explode ('-', $row->date_sent);
			$data['table'][] =array(
					'Name' => $name ,
					'Barangay'=>$row->barangay ,
					'Task Header'=> $row->task_header,
					'Task'=> $row->task,
					'Date Assigned'=> $row->date_sent,
					'Approve'=>'<input type="radio" name="'.$row->task_no.'" value="approved" checked="true">',
					'Deny'=>'<input type="radio" name="'.$row->task_no.'" value="denied">',
			);
			$data['task'] .=  $row->task_no . "/";
			}
				
			return $data;
			}
			else
			{
				return null;
			}
		}
		function get_bhw()
		{
				
			$qString = 'CALL ';
			$qString .= "get_bhw ()"; // name of stored procedure
			//$qString .=
			//variables needed by the stored procedure
		
			//date('Y-m-d') . "'". ")";
		
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{	
			$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
			$data[$row->barangay][$row->user_username]=$name;
			}
				
			return $data;
			}
			
		}
		function add_task($data)
		{
			$qString = 'CALL ';
			$qString .= "add_task ('"; // name of stored procedure
			$qString .=
					$data['task'] . "','" .
					$data['date_sent'] ."','".
					$data['sent_to']. "','".
					$data['sent_by']. "','".
					$data['task_header']. "'". ")";
			
			$query = $this->db->query($qString);
			$query->free_result();
		}
		function approve_task($data)
		{
			$qString = 'CALL ';
			$qString .= "approve_task ('"; // name of stored procedure
			$qString .=
			$data['task'] . "','" .
			$data['status']. "'". ")";
			$query = $this->db->query($qString);
			$query->free_result();
		}
		function get_barangay_count()
		{
			$qString = 'CALL ';
			$qString .= "get_barangay_dashboard_data ('"; // name of stored procedure
			$qString .=
			date('y-m-d'). "'". ")";
				
			$q = $this->db->query($qString);

			if($q->num_rows() > 0)
			{	$data ='';
			foreach ($q->result() as $row)
			{	
			$data .=
			$row->ctr . "&&" .
			$row->cr_barangay . "&&" .
			$row->year . "%%" ;
			}
				
			return $data;
			}
			else
			{
				return 0;
			}
		}
		function get_age_count()
		{
			$qString = 'CALL ';
			$qString .= "get_dashboard_data_age ('"; // name of stored procedure
			$qString .=
			date('y-m-d'). "'". ")"; 
		
			$q = $this->db->query($qString);
		
			if($q->num_rows() > 0)
			{	$data ="";
			foreach ($q->result() as $row)
			{	
				$data .=
				$row->cr_barangay . "&&" .
				($row->agerange * 10)."-".(($row->agerange *10)+10) . "&&" .
				$row->patientcount . "%%" ;
			}
		
			return $data;
			}
			else
			{
				return 0;
			}
		}
		function epidemic_threshold($barangay = null)
		{
			$qString = 'CALL ';
			
			if($barangay != null)
			{	$qString .= "epidemic_threshold_barangay ('"; 
				$qString .=$barangay . "','";	
				$str = "AND bhw.barangay = '".$barangay."'";
			}
			else
			{
				$qString .= "epidemic_threshold ('"; 
				$str = "";
			}
			$qString .=
			date('Y'). "'". ")";
			
			$ctr = date('Y') + 1;
			$q = $this->db->query($qString);
		
			if($q->num_rows() > 0)
			{	$sum=array(
					'1'=>0,
					'2'=>0,
					'3'=> 0,
					'4'=> 0,
					'5'=> 0,
					'6'=> 0,
					'7'=> 0,
					'8'=> 0,
					'9'=> 0,
					'10'=> 0,
					'11'=> 0,
					'12'=> 0,
				);
				$mean=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$sd=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$m2sd=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$csum=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$sdcsum=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$csum196sd=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$quartile=array(
						'1'=>0,
						'2'=>0,
						'3'=> 0,
						'4'=> 0,
						'5'=> 0,
						'6'=> 0,
						'7'=> 0,
						'8'=> 0,
						'9'=> 0,
						'10'=> 0,
						'11'=> 0,
						'12'=> 0,
				);
				$data[0]=array(
					'Year'=>'Year',
					'1'=> 'Jan.',
					'2'=> 'Feb.',
					'3'=> 'Mar.',
					'4'=> 'Apr.',
					'5'=> 'May',
					'6'=> 'Jun.',
					'7'=> 'Jul.',
					'8'=> 'Aug.',
					'9'=> 'Sept',
					'10'=> 'Oct.',
					'11'=> 'Nov.',
					'12'=> 'Dec.',
				);
				for($i = 6 ; $i >= 1 ; $i-- )
				{
				$data[$i]['Year'] = $ctr - $i;
				$data[$i]['1'] = 0;
				$data[$i]['2'] = 0;
				$data[$i]['3'] = 0;
				$data[$i]['4'] = 0;
				$data[$i]['5'] = 0;
				$data[$i]['6']= 0;
				$data[$i]['7']= 0;
				$data[$i]['8'] = 0;
				$data[$i]['9'] = 0;
				$data[$i]['10']= 0;
				$data[$i]['11'] = 0;
				$data[$i]['12']= 0;
				}
			foreach ($q->result() as $row)
			{	$year = $ctr - $row->year2;
				$data[$year][$row->month] = $row->num;
				
				if($row->year2 != date('Y'))
				$sum[$row->month] += $row->num;
			}
			$q->free_result();
			
			
			
			
			$where = "count(imcase_no) as num, Month(created_on) as month, Year(created_on) as year2
					FROM (`immediate_cases`) 
					JOIN `master_list` ON `master_list`.`person_id` = `immediate_cases`.`person_id` 
					JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id` 
					JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username` 
					JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id` 
					WHERE  (YEAR(created_on) >= ".date('Y')." - 5)".$str."
					GROUP BY MONTH(created_on), YEAR(created_on)
					ORDER BY YEAR(created_on),MONTH(created_on)
					";
			$this->db->select($where);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{	$year = $ctr - $row->year2;
				$data[$year][$row->month] = $data[$year][$row->month]  +  $row->num;
				
				if($row->year2 != date('Y'))
				$sum[$row->month] += $row->num;
			}
			}
			
			
			//mean
			for($i = 1 ; $i <= 12 ; $i++ )
				{
					$mean[$i]= $sum[$i]/5;
				}
				
			//sd
			for($i = 2 ; $i <= 6  ; $i++ )
				{	
				for($s = 1 ; $s <= 12 ; $s++ )
					{	
						$sd[$s] += pow($data[$i][$s]-$mean[$s],2);
					}
				}
			for($s = 1 ; $s <= 12 ; $s++ )
			{
				$sd[$s] = round(sqrt( $sd[$s]/4),0);
			}
			
			//mean2sd
			for($s = 1 ; $s <= 12 ; $s++ )
			{
				$m2sd[$s] = round($mean[$s] + (2 * $sd[$s]),0);
			}
				
			//csum
			for($s = 1 ; $s <= 12 ; $s++ )
			{
				if($s==1)
				{
					$csum[$s] = round(($sum[12] + $sum[1] + $sum[2])/15,0);
				}
				else if($s==12)
				{
					$csum[$s] = round(($sum[11] + $sum[12] + $sum[1])/15,0);
				}
				else
				{
					$csum[$s] = round(($sum[$s-1] + $sum[$s] + $sum[$s+1])/15,0);
				}
			}
			
			//sdcsum
		
				for($s = 1 ; $s <= 12 ; $s++ )
				{
					for($d = -1 ; $d <= 1 ; $d++ )
					{
						for($i = 2 ; $i <= 6  ; $i++ )
						{
						if($s==1)
							{	if($d == -1)
								$sdcsum[$s] += pow($data[$i][12]-$csum[$s],2);
								else
								$sdcsum[$s] += pow($data[$i][$s+$d]-$csum[$s],2);
							}
						else if($s==12)
							{	if($d == 1 )
								$sdcsum[$s] += pow($data[$i][1]-$csum[$s],2);
								else
								$sdcsum[$s] += pow($data[$i][$s+$d]-$csum[$s],2);
							}
						else
							{
								$sdcsum[$s] += pow($data[$i][$s+$d]-$csum[$s],2);
							}
						}

					}
				}
				for($s = 1 ; $s <= 12 ; $s++ )
				{
					$sdcsum[$s] = round(sqrt( $sdcsum[$s]/14),0);
				}
				
			//csum196sd
			for($s = 1 ; $s <= 12 ; $s++ )
			{
				$csum196sd[$s] = round($csum[$s] + (1.96 * $sdcsum[$s]),0);
			}
			
			//3rd quartile
			for($s = 1 ; $s <= 12 ; $s++ )
			{	$values = array();
				for($i = 2 ; $i <= 6  ; $i++ )
				{
					array_push($values , $data[$i][$s]);
				}
				sort($values);
				$count = count($values);
					
				$first = round( .25 * ( $count + 1 ) ) - 1;
				$second = ($count % 2 == 0) ? ($values[($count / 2) - 1] + $values[$count / 2]) / 2 : $second = $values[($count + 1) / 2];
				$third = round( .75 * ( $count + 1 ) ) - 1;
				
				$quartile[$s] = $values[$third-1];
			}
			
			
			$alldata = array(
					'data'=> $data,
					'sum'=> $sum,
					'mean'=> $mean,
					'sd'=> $sd,
					'm2sd'=> $m2sd,
					'csum'=> $csum,
					'sdcsum'=> $sdcsum,
					'csum196sd'=> $csum196sd,
					'quartile'=> $quartile,
					);
		
			return $alldata;
			}
			else
			{
				return 0;
			}
		}
		function getAllBarangays()
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_barangays("; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			")";
			$data['All'] = 'All';	
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
		function getPositiveSurveys()
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "positive_larval_nodes('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			date('y-m-d'). "'". ")";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{	$data ='';
				foreach ($q->result() as $row)
				{
					$data .=
				$row->ctr . "&&" .
				$row->ls_barangay . "%%" ;
				}
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function randomfact()
		{
			$fact[]='Dengue is a mosquito-borne viral infection. ';
			$fact[]="The global incidence of dengue has grown dramatically in recent decades. About half of the world's population is now at risk.";
			$fact[]='Severe dengue is a leading cause of serious illness and death among children in some Asian and Latin American countries.';
			$fact[]='There is no specific treatment for dengue/ severe dengue, but early detection and access to proper medical care lowers fatality rates below 1%.';
			$fact[]='Dengue is only really transmitted through mosquitoes. ';
			$fact[]='Dengue infects 50-100 million people each year ';
			$fact[]='Mothers who are pregnant and give birth while sick with Dengue Fever will share their sickness with their newborn child.';
			$fact[]='The middle aged has more of a chance of mild symptoms';
			$fact[]='The mosquito usually bites at dusk and dawn but may bite at any time during the day – especially indoors, in shady areas, or when the weather is cloudy, ';
			$fact[]='mosquitos need to bite an infected human and then bite a new person to transmit the disease. This means that populated areas are more prone to risk.';
			$fact[]='Cases of dengue fever increase during the rainy season.';
			$fact[]='Dengue is transmitted through the bite of the Aedes Agypti mosquito.';
			$fact[]='Dengue fever is not transmitted between humans.';
			$fact[]='Dengue fever can be caught more than once (although it will never be the same type). Those who have contracted dengue fever in the past should be extra careful as dengue hemorrhagic fever seems to develop almost exclusively on patients that had had classic dengue fever before';
			
			return $fact[rand(0, (count($fact))-1)];
		}
		function get_immediate_cases()
		{
			$qString = 'CALL ';
			$qString .= "get_immediate_case('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			date('Y-m').'-01' . "','" .
			date('Y-m').'-31' . "'". ")";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{	$data ='';
			foreach ($q->result() as $row)
			{
				$data .=
				$row->cr_first_name.' '.$row->cr_last_name . "&&" .
				$row->cr_age . "&&" .	
				$row->cr_sex . "&&" .
				$row->cr_barangay . "&&" .
				$row->cr_street . "&&" .
				$row->cr_date_onset . "%%" ;
			}
			return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}
		function get_dengue_profile($data = null)
		{
			if($data!= null)
			{
			$qString = 'CALL ';
			$qString .= "get_case_ages_gender ('"; // name of stored procedure
			$qString .=
						$data['datefrom']. "','".
						$data['dateto']. "'". ")";
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	
				$dateto= explode ('/', $data['dateto']);
				$datefrom= explode ('/', $data['datefrom']);
				
				for($i = $datefrom[0] ; $i <= $dateto[0]  ; $i++ )
				{
					foreach ($data['barangay'] as $row)
					{
						$data2['values'][$i][$row]['M'][0] = 0;
						$data2['values'][$i][$row]['M'][1] = 0;
						$data2['values'][$i][$row]['M'][2] = 0;
						$data2['values'][$i][$row]['M'][3] = 0;
						$data2['values'][$i][$row]['M'][4] = 0;
						$data2['values'][$i][$row]['F'][0] = 0;
						$data2['values'][$i][$row]['F'][1] = 0;
						$data2['values'][$i][$row]['F'][2] = 0;
						$data2['values'][$i][$row]['F'][3] = 0;
						$data2['values'][$i][$row]['F'][4] = 0;
						
						$data2['total'][$i][$row] = 0;
					}
				}
				
				foreach ($q->result() as $row)
				{	
					for($i = 0 ; $i < count($data['barangay']) ; $i++ )
					{	$range = null;
						if($data['barangay'][$i] == $row->cr_barangay)
						{	$range = null;
							if($row->agerange >= 4)
							{$range = 4;}
							else {$range =  $row->agerange;}
					
									$data2['values']
									[$row->caseyear]
									[$row->cr_barangay]
									[$row->cr_sex]
									[$range]
									+= //array(
									//'barangay'=>$row->cr_barangay ,
									$row->patientcount;
									//'range'=> (($row->agerange * 10)+1)."-".(($row->agerange *10)+10),
									//'sex'=>$row->cr_sex,
									//'year'=>$row->caseyear,
									//);
									
							$data2['total'][$row->caseyear][$row->cr_barangay] += $row->patientcount;
							$barangay [] = $row->cr_barangay ;
							$year[] = $row->caseyear;
							
						}
					}
				}
				$data2['barangay'] = array_values(array_unique($barangay));
				$data2['year'] = array_values(array_unique($year));
			}
			
			else {$data2 = null;}
			}
			
			return $data2;
		}
		
		function get_investigated_cases($data = null)
		{
			if($data!= null)
			{
				$qString = 'CALL ';
				$qString .= "get_investigated_cases ('"; // name of stored procedure
				$qString .=
				$data['datefrom']. "','".
				$data['dateto']. "'". ")";
				$q = $this->db->query($qString);
				if($q->num_rows() > 0)
				{
					$data2 = array();
					$data2[]=array(
							'Name'=>'Name',
							'Barangay'=>'Barangay',
							'Result'=> 'Result');
					foreach ($q->result() as $row)
					{
						for($i = 0 ; $i < count($data['barangay']) ; $i++ )
						{	$range = null;
						if($data['barangay'][$i] == $row->cr_barangay)
						{	
							
							$data2[]=array(
									'Name'=>$row->cr_last_name . ", ". $row->cr_first_name,
									'Barangay'=>$row->cr_barangay,
									'Result'=> $row->feedback);
							
						}
						}
					}
				}
					
				else {$data2 = null;}
			}
				
			return $data2;
		}
		
		
	}

/* End of cho_model.php */
/* Location: ./application/models/cho_model.php */
