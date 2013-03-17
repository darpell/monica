<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tasks extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('tasks_model','tasks');
	}
	
	function index()
	{
		$data['tasks'] = $this->tasks->get_tasks();
		$this->load->view('mobile/tasks.php', $data);
	}
	
	function view($id)
	{
		$data['tasks'] = $this->tasks->get_tasks($id);
		$this->load->view('mobile/tasks.php', $data);
	}
}

/* End of file mobile/tasks.php */
/* Location: ./application/controllers/mobile/tasks.php */