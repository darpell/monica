<?php
class Twitter extends CI_Controller
{	
	private $_consumer_key = 'QPMXQVU9lcpgt1bRUjLWg';
	private $_consumer_secret = 'eIR3yd9j3xxe1Y049xbyjVAm8ZFFn0URms6JvQQbbo';
	private $_access_token = '1295280488-oODNE13B8QIxluzhf8e8RwhJFWsvlLsBGioSyzI';
	private $_secret_access_token = 'jlQOM6Xtmk6voAtuBZts2jUpvsvTUgk8cLOVYqPcQ';
	
	
	public function index()
	{
		$this->load->view('pages/testtweet.php' , $data);
	}
	
}
		
/* End of file user/upload.php */
/* Location: ./application/controllers/user/upload.php */