<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Poi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('poi_model','poi');
	}
	
	function index()
	{
		$this->load->view('mobile/poi_form');
	}
	
	function add()
	{
		$this->form_validation->set_rules('TPname-txt_r', 'name', 'required');
		$this->form_validation->set_rules('TPremarks-txt_r', 'remarks', 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('mobile/poi_form');
		}
		else
		{
			$input_data = array(
					'node_name'		=>	$this->input->post('TPname-txt_r'),
					'node_lat'		=>	$this->input->post('lat'),
					'node_lng'		=>	$this->input->post('lng'),
					'node_notes'	=>	$this->input->post('TPremarks-txt_r'),
					'node_type'		=>	$this->input->post('TPtype-txt_r'),
					'node_addedOn'	=>	$this->input->post('TPdate-txt_r'),
					'node_barangay'	=>	$this->input->post('TPbarangay-txt_r'),
					'node_city'		=>	$this->input->post('TPmunicipality-txt_r')
				);
				
			$this->poi->add($input_data);
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/poi_success', $data);
		}
	}
}

/* End of file mobile/poi.php */
/* Location: ./application/controllers/mobile/poi.php */