<?php
class Crform extends CI_Controller
{
	public function index()
	{	$this->redirectLogin();
		
		$data['title'] = 'Add report';
		 
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{	//scripts if none keep '' 
			$data['script'] = 'view_casereport';
			$this->load->view('pages/cr_form',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function redirectLogin()
	{	$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{
			$this->load->view('mobile/index.php');
		}
		else{
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		if($this->session->userdata('logged_in') != TRUE )
		redirect(substr(base_url(), 0, -1) . '/index.php/login');
		}
	}
	function addcase()
	{		
		/* css */
		$data['title'] = 'Add Case Report';
		$data['script'] = '';
		
		$this->form_validation->set_rules('TPpatientno-txt', 'patient no.', 'required');
		$this->form_validation->set_rules('TPfirstname-txt', 'first name', 'required');
		$this->form_validation->set_rules('TPlastname-txt', 'last name', 'required');
		$this->form_validation->set_rules('TPage-txt', 'age', 'required');
		$this->form_validation->set_rules('TPbirthdate-txt', 'birthdate', 'required');
		$this->form_validation->set_rules('TPcity-txt', 'city', 'required');
		$this->form_validation->set_rules('TPbarangay-txt', 'barangay', 'required');
		$this->form_validation->set_rules('TPstreet-txt', 'street', 'required');
		$this->form_validation->set_rules('TPconsuldate-txt', 'date of consultation', 'required');
		$this->form_validation->set_rules('TPillnessdate-txt', 'illness date', 'required');
		$this->form_validation->set_rules('TPclassification-rd', 'classification', 'required');
		$this->form_validation->set_rules('TPregion-txt', 'region', 'required');
		$this->form_validation->set_rules('TPprovince2-txt', 'province', 'required');
		$this->form_validation->set_rules('TPdru-txt', 'DRU', 'required');
		$this->form_validation->set_rules('TPaddress-txt', 'address', 'required');
		$this->form_validation->set_rules('TPcity-txt', 'city', 'required');
		$this->form_validation->set_rules('TPprovince-txt', 'province', 'required');

		
		if ($this->form_validation->run('') == FALSE)
		{		$data['script'] = 'view_casereport';
			$this->load->view('pages/cr_form',$data);
		}
		else
		{	
			$this->load->view('pages/cr_form');
			$this->load->model('Case_report');
			
			$date= explode ('/', $this->input->post('TPbirthdate-txt'));
			$date2= explode ('/', $this->input->post('TPconsuldate-txt'));
			$date3= explode ('/', $this->input->post('TPillnessdate-txt'));
			$data = array(
			'TPpatientno-txt' => $this->input->post('TPpatientno-txt'),
			'TPfirstname-txt' => $this->input->post('TPfirstname-txt'),
			'TPlastname-txt' => $this->input->post('TPlastname-txt'),			
			'TPage-txt' => $this->input->post('TPage-txt'),
			'TPsex-dd' => $this->input->post('TPsex-dd'),
			'TPbirthdate-txt' => $date[2].'/'.$date[0].'/'.$date[1] ,
			'TPcity-txt' => $this->input->post('TPcity-txt'),
			'TPbarangay-txt' => $this->input->post('TPbarangay-txt'), 
			'TPstreet-txt' => $this->input->post('TPstreet-txt'), 
			'TPadmitted-rd' => $this->input->post('TPadmitted-rd'),
			'TPconsuldate-txt' =>  $date2[2].'/'.$date2[0].'/'.$date2[1],
			'TPillnessdate-txt' =>  $date3[2].'/'.$date3[0].'/'.$date3[1],
			'TPclassification-rd'=>$this->input->post('TPclassification-rd'),
			'TPtype-rd'=>$this->input->post('TPtype-rd'),
			'TPregion-txt' => $this->input->post('TPregion-txt'),
			'TPprovince2-txt' => $this->input->post('TPprovince2-txt'),
			'TPdru-txt' => $this->input->post('TPdru-txt'),
			'TPaddress-txt'=>$this->input->post('TPaddress-txt'),
			'TPcity2-txt'=>$this->input->post('TPcity-txt'),
			'TPprovince-txt' => $this->input->post('TPprovince-txt'),
			'TPoutcome-rd'=>$this->input->post('TPoutcome-rd'),
			'TPcrno-txt'=> time().'-'.mt_rand(),
			'TPdateofentry-txt' => date('Y-m-d'),
		);
		
		$this->Case_report->addCase($data);
		redirect(substr(base_url(), 0, -1) . '/index.php/case_report');
		}
	}
	function viewCaseReport()
	{	
		$this->redirectLogin();
		
		$data['title'] = 'Add report';
		
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		
		//for table result keep null here
		$data['table'] = null;
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->view('pages/view_crform',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function searchCaseReport()
	{		$this->redirectLogin();
			$this->load->model('case_report');
			
			$datefrom = explode ('/', $this->input->post('datefrom'));
			$dateto = explode ('/', $this->input->post('dateto'));
			$data = array(
			'TPdru-txt' => $this->input->post('TPdru-txt'),
			'TPcity-txt' => $this->input->post('TPcity-txt'),
			'TPdatefrom-txt' => ($datefrom[2]. '-' . $datefrom[0]. '-' .$datefrom[1]),			
			'TPdateto-txt' =>  ($dateto[2]. '-' . $dateto[0]. '-' .$dateto[1]),
			'TPsort-dd' => $this->input->post('TPsort-dd')
			);
		
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		$data['title']= "searchcases";
		//for table result for search
		$data['table'] = $this->case_report->searchcase($data); 
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->library('table');
			$this->load->view('pages/view_crform',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
			
		 
	}
	function view_patients()
	{	$this->redirectLogin();
		$this->load->model('case_report');
		
		$data['patientno'] = $this->uri->segment(3,"");
		$data['title'] = 'View patients';
		
		
		//scripts if none keep '' 
		$data['script'] = '';
		
		//for table result for search
		$data['table'] = $this->case_report->viewPatients($data); 
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->library('table');
			$this->load->view('pages/view_patients',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function update_patient()
	{	$this->redirectLogin();
		$this->load->model('case_report');		
		$data['patientno'] = $this->uri->segment(3,"");
		
		/* css */
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'Update patient';
		
		
		//scripts if none keep '' 
		$data['script'] = 'view_casereport';
		
		//for table result for search
		$data['info'] = $this->case_report->getPatientInfo($data); 
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{
			$this->load->library('table');
			$this->load->view('pages/update_patient',$data);
		}
		else
		{
			$this->load->view('pages/success');
		}
	}
	function update_patient_info()
	{
		$datedob = explode ('/', $this->input->post('TPbirthdate-txt'));
		$dateconsul = explode ('/', $this->input->post('TPconsuldate-txt'));
		$dateill = explode ('/', $this->input->post('TPillnessdate-txt'));
		
		$this->load->model('Case_report');
			$data = array(
			'TPpatientno-txt' => $this->input->post('TPpatientno-txt'),
			'TPfirstname-txt' => $this->input->post('TPfirstname-txt'),
			'TPlastname-txt' => $this->input->post('TPlastname-txt'),			
			'TPage-txt' => $this->input->post('TPage-txt'),
			'TPsex-dd' => $this->input->post('TPsex-dd'),
			'TPbirthdate-txt' => ($datedob[2]. '-' . $datedob[0]. '-' .$datedob[1]),
			'TPcity-txt' => $this->input->post('TPcity-txt'),
			'TPbarangay-txt' => $this->input->post('TPbarangay-txt'), 
			'TPstreet-txt' => $this->input->post('TPstreet-txt'), 			
			'TPadmitted-rd' => $this->input->post('TPadmitted-rd'),
			'TPconsuldate-txt' => ($dateconsul[2]. '-' . $dateconsul[0]. '-' .$dateconsul[1]),
			'TPillnessdate-txt' => ($dateill[2]. '-' . $dateill[0]. '-' .$dateill[1]),
			'TPclassification-rd'=>$this->input->post('TPclassification-rd'),
			'TPtype-rd'=>$this->input->post('TPtype-rd'),
			'TPprovince-txt' => $this->input->post('TPprovince-txt'),
			'TPoutcome-rd'=>$this->input->post('TPoutcome-rd')
		);
		
		$this->Case_report->updatePatientInfo($data);
		redirect('/case_report/viewCaseReport', 'refresh');
	}
	function testchart()
	{
		$this->load->model('Case_report');
		$data['year'] = '2012';
		$data['title'] = 'Add report';
		
		$case = $this->Case_report->get_report_data_cases($data);
		
		$case = explode('%%', $case);
		
		for  ($i = 0; $i < (count($case)); $i++)
		{
			$data2[] =  explode('&&', $case[$i]);
		}
		$m1 = 0;
	    $m2 = 0;
		$m3 = 0;
		$m4 = 0;
		$m5 = 0;
		$m6 = 0;
		$m7 = 0;
		$m8 = 0;
		$m9 = 0;
		$m10 = 0;
		$m11 = 0;
		$m12 = 0;
		
		$mn1 = 0;
	    $mn2 = 0;
		$mn3 = 0;
		$mn4 = 0;
		$mn5 = 0;
		$mn6 = 0;
		$mn7 = 0;
		$mn8 = 0;
		$mn9 = 0;
		$mn10 = 0;
		$mn11 = 0;
		$mn12 = 0;
		for ($i = 0; $i < (count($data2)-1); $i++)
		{	
			if($data2[$i][2] == 2012)
			{
			if ($data2[$i][1] == 1) 
			{$mn1 = $data2[$i][0];}
			if ($data2[$i][1] == 2) 
			{$mn2 = $data2[$i][0];}
			if ($data2[$i][1] == 3) 
			{$mn3 = $data2[$i][0];}
			if ($data2[$i][1] == 4) 
			{$mn4 = $data2[$i][0];}
			if ($data2[$i][1] == 5) 
			{$mn5 = $data2[$i][0];}
			if ($data2[$i][1] == 6) 
			{$mn6 = $data2[$i][0];}
			if ($data2[$i][1] == 7) 
			{$mn7 = $data2[$i][0];}
			if ($data2[$i][1] == 8) 
			{$mn8 = $data2[$i][0];}
			if ($data2[$i][1] == 9) 
			{$mn9 = $data2[$i][0];}
			if ($data2[$i][1] == 10) 
			{$mn10 = $data2[$i][0];}
			if ($data2[$i][1] == 11) 
			{$mn11 = $data2[$i][0];}
			if ($data2[$i][1] == 12) 
			{$mn12 = $data2[$i][0];}
			}
			else if($data2[$i][2] == 2011)
			{
			if ($data2[$i][1] == 1) 
			{$m1 = $data2[$i][0];}
			if ($data2[$i][1] == 2) 
			{$m2 = $data2[$i][0];}
			if ($data2[$i][1] == 3) 
			{$m3 = $data2[$i][0];}
			if ($data2[$i][1] == 4) 
			{$m4 = $data2[$i][0];}
			if ($data2[$i][1] == 5) 
			{$m5 = $data2[$i][0];}
			if ($data2[$i][1] == 6) 
			{$m6 = $data2[$i][0];}
			if ($data2[$i][1] == 7) 
			{$m7 = $data2[$i][0];}
			if ($data2[$i][1] == 8) 
			{$m8 = $data2[$i][0];}
			if ($data2[$i][1] == 9) 
			{$m9 = $data2[$i][0];}
			if ($data2[$i][1] == 10) 
			{$m10 = $data2[$i][0];}
			if ($data2[$i][1] == 11) 
			{$m11 = $data2[$i][0];}
			if ($data2[$i][1] == 12) 
			{$m12 = $data2[$i][0];}
			}
		}
		
		$age = $this->Case_report->get_report_data_age($data);
		
		$age = explode('%%', $age);
		
		for ($i = 0; $i < count($age); $i++)
		{
			$data3[] = explode('&&', $age[$i]);
		}
		$age0m = 0;
		$age1m = 0;
		$age2m = 0;
		$age3m = 0;
		$age4m = 0;
		$age0f = 0;
		$age1f = 0;
		$age2f = 0;
		$age3f = 0;
		$age4f = 0;
		
		for ($i = 0; $i < count($data3)-1; $i++)
		{	
			if ($data3[$i][2] == 0) 
			{
			if($data3[$i][1] == 'F')
			{$age0f = $data3[$i][0];}
			else {$age0m = $data3[$i][0];}
			}
			else if ($data3[$i][2] == 1) 
			{
			if($data3[$i][1] == 'F')
			{$age1f = $data3[$i][0];}
			else {$age1m = $data3[$i][0];}
			}
			else if ($data3[$i][2] == 2) 
			{
			if($data3[$i][1] == 'F')
			{$age2f = $data3[$i][0];}
			else {$age2m = $data3[$i][0];}
			}
			else if ($data3[$i][2] == 3) 
			{
			if($data3[$i][1] == 'F')
			{$age3f = $data3[$i][0];}
			else {$age3m = $data3[$i][0];}
			}
			else if ($data3[$i][2] >= 4) 
			{
			if($data3[$i][1] == 'F')
			{$age4f = $age4f + $data3[$i][0];}
			else {$age4m = $age4m + $data3[$i][0];}
			}
			
		}

		
		
		/** Validation rules could be seen at application/config/form_validation.php **/
		if ($this->form_validation->run('') == FALSE)
		{	//scripts if none keep '' 
			$data['script'] = 'test_charts';
			//$this->load->view('templates/header',$data);
			$data['report_data_age'] = $this->Case_report->get_report_data_age($data);;
			$data['report_data_cases'] = $this->Case_report->get_report_data_cases($data);
			$data['totalcur'] = $mn1 + $mn2 + $mn3 + $mn4 + $mn5 + $mn6 + $mn7 + $mn8 + $mn9 + $mn10 + $mn11 + $mn12;
			$data['totalprev'] = $m1 + $m2 + $m3 + $m4 + $m5 + $m6 + $m7 + $m8 + $m9 + $m10 + $m11 + $m12;
			
			$max[] = $age0m + $age0f;
			$max[] = $age1m + $age1f;
			$max[] = $age2m + $age2f;
			$max[] = $age3m + $age3f;
			$max[] = $age4m + $age4f;
			
			$value = max($max);
			$key = array_search($value, $max);
			$data['agegroup'] = $key;
			$data['agegrouppercent'] = round(($max[$key] / $data['totalcur']) *100,2);
			$data['summ'] = round((($age0m + $age1m + $age2m + $age3m +$age4m)/$data['totalcur'])*100 ,2) ;
			$data['sumf'] = round((($age0f + $age1f + $age2f + $age3f +$age4f)/$data['totalcur'])*100 ,2) ;
			
			$data['percent'] = round($data['totalcur']/$data['totalprev'] , 2);
			$data['percent'] =  $data['percent'] * 100;
			$this->load->view('pages/surviellance_report', $data);
			//$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('pages/success');
		}
	
	}
}

/* End of file user/crform.php */
/* Location: ./application/controllers/user/crform.php */