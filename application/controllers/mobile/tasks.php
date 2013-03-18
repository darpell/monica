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
		$data['result'] = '';
		$data['tasks'] = $this->tasks->get_tasks();
		$this->load->view('mobile/tasks.php', $data);
	}
	
	function view($id)
	{
		$data['result'] = '';
		$data['tasks'] = $this->tasks->get_tasks($id);
		$this->load->view('mobile/task_view.php', $data);
	}
	
	function done()
	{
		$this->form_validation->set_rules('TPtask_remark', 'remark', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['tasks'] = $this->tasks->get_tasks($this->input->post('task_no'));
			$this->load->view('mobile/task_view.php', $data);
		}
		else
		{
			$this->tasks->task_done(
								$this->input->post('task_no'),
								$this->input->post('TPtask_remark')
							);
			$data['result'] = 'Your entry has been recorded.';
			$data['tasks'] = $this->tasks->get_tasks();
			$this->load->view('mobile/tasks.php', $data);
		}
	}
}

/* End of file mobile/tasks.php */
/* Location: ./application/controllers/mobile/tasks.php */