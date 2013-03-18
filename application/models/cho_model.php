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
			$data[$row->barangay]=array(
				$row->user_username=>$name,
				);
		
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
					$data['sent_by']. "'". ")";
			
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
	}

/* End of cho_model.php */
/* Location: ./application/models/cho_model.php */
