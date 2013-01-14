<?php 
class Mod_login extends CI_Model
{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function check($data){
			
			$qString = 'CALL '; 
			$qString .= "login ('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data['TPusername-txt'] . "','" . 
			$data['TPpassword-txt'] . "')";
			
			$q= $this->db->query($qString);
			
			if($q->num_rows() > 0) 
			{
			foreach ($q->result() as $row) {
			
			$data2[]=array(
				'TPusername'=>$row->user_username , 
				'TPtype'=>$row->user_type ,
				'TPfirstname'=> $row->user_firstname ,
				'TPmiddlename'=> $row->user_middlename ,
				'TPlastname'=> $row->user_lastname ,
				);

			}
			return $data2;
			}
			
			else return false;
	

		}
		
		function add_user($data){
			
			$qString = 'CALL '; 
			$qString .= "add_user ('"; // name of stored procedure
			$qString .= 
				//variables needed by the stored procedure
				$data['TPusername-txt'] . "','" . 
				$data['TPpassword-txt'] . "','" .
				$data['TPfirstname-txt'] . "','" .
				$data['TPmiddlename-txt'] . "','" .
				$data['TPlastname-txt'] . "','" .
				$data['TPtype-dd'] . "'," . "'n'" . ")";
			
			
			$query = $this->db->query($qString);
		}
}

/* End of mod_login.php */
/* Location: ./application/models/mod_login.php */