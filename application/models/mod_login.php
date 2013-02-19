<?php 
class Mod_login extends CI_Model
{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function check($data)
		{
			
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
				
				$data2[] = array(
					'TPusername'	=>	$row->user_username , 
					'TPtype'		=>	$row->user_type ,
					'TPfirstname'	=>	$row->user_firstname ,
					'TPmiddlename'	=>	$row->user_middlename ,
					'TPlastname'	=>	$row->user_lastname ,
					);
	
				}
				return $data2;
			}
			else 
				return false;
		}
		
		function add_user($data)
		{
			
			$qString = 'CALL '; 
			$qString .= "add_user ('"; // name of stored procedure
			$qString .= 
				//variables needed by the stored procedure
				$data['TPusername-txt'] . "','" . 
				$data['TPpassword-txt'] . "','" .
				$data['TPtype-dd']. "','" .
				$data['TPmiddlename-txt'] . "','" .
				$data['TPlastname-txt'] . "','" .
				 $data['TPfirstname-txt']. "'," . "'u'" . ")";
			
			
			$query = $this->db->query($qString);
		}
		function get_users()
		{

			$qString = 'CALL '; 
			$qString .= "get_users()"; // name of stored procedure
			
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row) {
					
					$data[]= $row->user_username ;
				}
			}
			else  $data = null;
			return $data;
		}
		function get_unapproved_users()
		{

			$qString = 'CALL ';
			$qString .= "get_unapproved_users ()"; // name of stored procedure
		
				
			$q = $this->db->query($qString);
				
			$data2[]=array(
					'username'=>'Username',
					'usertype'=> 'User Type',
					'firstname'=> 'Firstname',
					'middlename'=> 'Middlename',
					'lastname'=> 'Lastname',
			);
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row) {
						
					$data2[]=array(
							'username'=> anchor(base_url('index.php/login/view_user/').'/'. $row->user_username ,  $row->user_username  , 'target="_blank"'),
							'usertype'=>$row->user_type ,
							'firstname'=> $row->user_firstname,
							'middlename'=> $row->user_middlename,
							'lastname'=>  $row->user_lastname,
					);
				}
			}
			else
			{
				$data2[] =array(
						'cr_no'=> '</td><td align="center" colspan="13">No New Users Found',
				);
			}
			$q->free_result();
			return $data2;
			
		}
		function view_user($data)
		{
			$qString = 'CALL ';
			$qString .= "get_user ('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data['username']. "'" . ")";
			
			$q = $this->db->query($qString);

			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row) {
			
					$data2=array(
							'username'=> $row->user_username,
							'usertype'=>$row->user_type ,
							'firstname'=> $row->user_firstname,
							'middlename'=> $row->user_middlename,
							'lastname'=>  $row->user_lastname,
					);
				}
			}
			else
			{
				$data2= null;
			}
			$q->free_result();
			return $data2;
				
		}
		function approve_user($data)
		{
			
			$qString = 'CALL ';
			$qString .= "approve_user ('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data['TPusername-txt'] . "','" .
			$data['TPtype-dd']. "','" .
			$data['TPapproval-rd'] . "')" ;
			
			$q = $this->db->query($qString);
		}
}

/* End of mod_login.php */
/* Location: ./application/models/mod_login.php */