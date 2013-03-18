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
			{	$data .=
				'Name' . "&&" .
				'Barangay' . "&&" .
				'Task' . "&&" .
				'Status'  . "%%" ;
			foreach ($q->result() as $row)
			{	if($row->date_accomplsied == '0000-00-00' )
					$status = 'Not Done';
				else 
					$status = 'Completed';
				$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
				$data .=
				$name . "&&" .
				$row->barangay . "&&" .
				$row->task . "&&" .
				$status  . "%%" ;
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
