<?php
class Upload extends CI_Controller
{
	public function index()
	{
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'View patients';
			$data['table'] = null;
			$data['script'] = '';
			$data['error'] =  '';
			$this->load->view('templates/header',$data);
			$this->load->library('table');
			$data['result'] = "";
			$this->load->view('pages/view_upload',$data);
			$this->load->view('templates/footer');
	
			
		}
	function view()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'mdb';
		$config['max_size'] = '0';
		$this->load->library('upload' ,$config);
		if ( ! $this->upload->do_upload())
		{
			$error = $this->upload->display_errors();

			$this->load->helper(array('form', 'url'));
				
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'View patients';
			$data['table'] = null;
			$data['script'] = '';
			$data['error'] =  $error;
			$this->load->view('templates/header',$data);
			$this->load->library('table');
			$this->load->view('pages/view_upload',$data);
			$this->load->view('templates/footer');
		}
		else
		{

			$upload = $this->upload->data();
			
		
		$db_connection = new COM("ADODB.Connection", NULL, 1251);
		$db_connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" .
		$upload['full_path']  . "; ''; '';";
		
		$db_connection->open($db_connstr);
		$rs = $db_connection->execute("SELECT * FROM Dengue");
		
		$rs_fld0 = $rs->Fields(1);
		$rs_fld1 = $rs->Fields(1);
		$rs_fld2 = $rs->Fields(2);
		$rs_fld3 = $rs->Fields(3);
		$rs_fld4 = $rs->Fields(4);
		$rs_fld5 = $rs->Fields(5);
		$rs_fld6 = $rs->Fields(6);
		$rs_fld7 = $rs->Fields(7);
		$rs_fld8 = $rs->Fields(8);
		$rs_fld9 = $rs->Fields(9);
		$rs_fld10 = $rs->Fields(10);
		$rs_fld11 = $rs->Fields(11);
		$rs_fld12 = $rs->Fields(12);
		$rs_fld13 = $rs->Fields(13);
		$rs_fld14 = $rs->Fields(14);
		$rs_fld15 = $rs->Fields(15);
		$rs_fld16 = $rs->Fields(16);
		$rs_fld17 = $rs->Fields(17);
		$rs_fld18 = $rs->Fields(18);
		$rs_fld19 = $rs->Fields(19);
		$rs_fld20 = $rs->Fields(20);
		$rs_fld21 = $rs->Fields(21);
		$rs_fld22 = $rs->Fields(22);
		$rs_fld23 = $rs->Fields(23);
		$rs_fld24 = $rs->Fields(24);
		$rs_fld25 = $rs->Fields(25);
		$rs_fld26 = $rs->Fields(26);
		$rs_fld27 = $rs->Fields(27);
		$rs_fld28 = $rs->Fields(28);
		$rs_fld29 = $rs->Fields(29);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld31 = $rs->Fields(31);
		$rs_fld32 = $rs->Fields(32);
		$rs_fld33 = $rs->Fields(33);
		$rs_fld34 = $rs->Fields(34);
		$rs_fld35 = $rs->Fields(35);
		$rs_fld36 = $rs->Fields(36);
		$rs_fld37 = $rs->Fields(37);
		$rs_fld38 = $rs->Fields(38);
		$rs_fld39 = $rs->Fields(39);
		$rs_fld40 = $rs->Fields(40);
		$rs_fld41 = $rs->Fields(41);
		$rs_fld42 = $rs->Fields(42);
		$rs_fld43 = $rs->Fields(43);
		
		while (!$rs->EOF) {
		
		$region[]	=$rs_fld0->value;
		$province[]	=$rs_fld1->value;
		$city[]	=$rs_fld2->value;
		$street[]	=$rs_fld3->value;
		$dateofentry[]	=$rs_fld4->value;
		$DRU[]	=$rs_fld5->value;
		$patientnum[]	=$rs_fld6->value;
		$firstname[]	=$rs_fld7->value;
		$familyname[]	=$rs_fld8->value; 
		$fullname[]	=$rs_fld9->value; 
		$ageyears[]	=$rs_fld10->value;
		$agemonths[]	=$rs_fld11->value;
		$agedays[]	=$rs_fld12->value;
		$sex[]	=$rs_fld13->value;
		$addressofDRU[]	=$rs_fld14->value;
		$provofDRU[]	=$rs_fld15->value;
		$cityofDRU[]	=$rs_fld16->value;
		$DOB[]	=$rs_fld17->value;
		$admitted[]	=$rs_fld18->value;
		$dAdmit[]	=$rs_fld19->value; 
		$dOnset[]	=$rs_fld20->value;
		$type[]	=$rs_fld21->value;
		$labres[]	=$rs_fld22->value;
		$caseclassifiaction[]	=$rs_fld23->value;
		$outcome[]	=$rs_fld24->value;
		$regionofDRU[]	=$rs_fld25->value;
		$EPIID[]	=$rs_fld26->value;
		$DateDied[]	=$rs_fld27->value;
		$icdCode[]	=$rs_fld28->value;
		$MorbidityMonth[]	=$rs_fld29->value;
		$MorbidityWeek[]	=$rs_fld30->value; 
		$admittoentry[]	=$rs_fld31->value;
		$onsettoadmit[]	=$rs_fld32->value;
		$sentinelsite[]	=$rs_fld33->value;
		$deleterecord[]	=$rs_fld34->value;
		$year[]	=$rs_fld35->value;
		$recStatus[]	=$rs_fld36->value;
		$uniqueKey[]	=$rs_fld37->value;
		$NameofDRU[]	=$rs_fld38->value;
		$ILHZ[]	=$rs_fld39->value;
		$district[]	=$rs_fld40->value;
		$barangay[]	=$rs_fld41->value; 
		$typeofhospital[]	=$rs_fld42->value;
		$sent[]	=$rs_fld43->value;
		
		$rs->MoveNext();
		// Do something with the data here, like put it into mysql, put it into a file, or print it to the screen
		
		}
		$rs->Close();
		$db_connection->Close();
		
		
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'View patients';
		
			$values[]=array(
				'cr_patient_no'=>'Patient No.',
				'cr_name'=> 'Patient Name',
				'cr_dob'=> 'Date of birth',
				'cr_address'=> 'Address',
				'cr_date_onset'=> 'Date onset of illness',
				'cr_date_of_entry'=> 'Date of Entry',);
			for ($i=0; $i < count($patientnum); $i++)
			{
			$values[]=array(
				'cr_patient_no'=> $patientnum[$i],
				'cr_name'=> $firstname[$i] . ", ". $familyname[$i],
				'cr_dob'=> $DOB[$i] ,
				'cr_address'=> $street[$i] . " " . $barangay[$i] . " " . $city[$i] . " " . $province[$i] ,
				'cr_date_onset'=> $dOnset[$i],
				'cr_date_of_entry'=> $dateofentry[$i],
				);
			}
			
			$data['table'] = $values;
			$data['script'] = '';
			$this->load->view('templates/header',$data);
			$this->load->library('table');
			$this->load->view('pages/view_upload',$data);
			$this->load->view('templates/footer');
			$this->session->set_userdata('TPuploadvalues', $upload['full_path']);
			}
	}
	function confirmUpload()
	{		
		if($this->input->post('TPsubmit') == 'Confirm Upload')
		{
		$this->load->model('Case_report');
		
		$db_connection = new COM("ADODB.Connection", NULL, 1251);
		$db_connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" .
		$this->session->userdata('TPuploadvalues')  . "; ''; '';";
		
		$db_connection->open($db_connstr);
		$rs = $db_connection->execute("SELECT * FROM Dengue");
		
		$rs_fld0 = $rs->Fields(1);
		$rs_fld1 = $rs->Fields(1);
		$rs_fld2 = $rs->Fields(2);
		$rs_fld3 = $rs->Fields(3);
		$rs_fld4 = $rs->Fields(4);
		$rs_fld5 = $rs->Fields(5);
		$rs_fld6 = $rs->Fields(6);
		$rs_fld7 = $rs->Fields(7);
		$rs_fld8 = $rs->Fields(8);
		$rs_fld9 = $rs->Fields(9);
		$rs_fld10 = $rs->Fields(10);
		$rs_fld11 = $rs->Fields(11);
		$rs_fld12 = $rs->Fields(12);
		$rs_fld13 = $rs->Fields(13);
		$rs_fld14 = $rs->Fields(14);
		$rs_fld15 = $rs->Fields(15);
		$rs_fld16 = $rs->Fields(16);
		$rs_fld17 = $rs->Fields(17);
		$rs_fld18 = $rs->Fields(18);
		$rs_fld19 = $rs->Fields(19);
		$rs_fld20 = $rs->Fields(20);
		$rs_fld21 = $rs->Fields(21);
		$rs_fld22 = $rs->Fields(22);
		$rs_fld23 = $rs->Fields(23);
		$rs_fld24 = $rs->Fields(24);
		$rs_fld25 = $rs->Fields(25);
		$rs_fld26 = $rs->Fields(26);
		$rs_fld27 = $rs->Fields(27);
		$rs_fld28 = $rs->Fields(28);
		$rs_fld29 = $rs->Fields(29);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld31 = $rs->Fields(31);
		$rs_fld32 = $rs->Fields(32);
		$rs_fld33 = $rs->Fields(33);
		$rs_fld34 = $rs->Fields(34);
		$rs_fld35 = $rs->Fields(35);
		$rs_fld36 = $rs->Fields(36);
		$rs_fld37 = $rs->Fields(37);
		$rs_fld38 = $rs->Fields(38);
		$rs_fld39 = $rs->Fields(39);
		$rs_fld40 = $rs->Fields(40);
		$rs_fld41 = $rs->Fields(41);
		$rs_fld42 = $rs->Fields(42);
		$rs_fld43 = $rs->Fields(43);
		
		while (!$rs->EOF) {
		
		$region[]	=$rs_fld0->value;
		$province[]	=$rs_fld1->value;
		$city[]	=$rs_fld2->value;
		$street[]	=$rs_fld3->value;
		$dateofentry[]	=$rs_fld4->value;
		$DRU[]	=$rs_fld5->value;
		$patientnum[]	=$rs_fld6->value;
		$firstname[]	=$rs_fld7->value;
		$familyname[]	=$rs_fld8->value; 
		$fullname[]	=$rs_fld9->value; 
		$ageyears[]	=$rs_fld10->value;
		$agemonths[]	=$rs_fld11->value;
		$agedays[]	=$rs_fld12->value;
		$sex[]	=$rs_fld13->value;
		$addressofDRU[]	=$rs_fld14->value;
		$provofDRU[]	=$rs_fld15->value;
		$cityofDRU[]	=$rs_fld16->value;
		$DOB[]	=$rs_fld17->value;
		$admitted[]	=$rs_fld18->value;
		$dAdmit[]	=$rs_fld19->value; 
		$dOnset[]	=$rs_fld20->value;
		$type[]	=$rs_fld21->value;
		$labres[]	=$rs_fld22->value;
		$caseclassifiaction[]	=$rs_fld23->value;
		$outcome[]	=$rs_fld24->value;
		$regionofDRU[]	=$rs_fld25->value;
		$EPIID[]	=$rs_fld26->value;
		$DateDied[]	=$rs_fld27->value;
		$icdCode[]	=$rs_fld28->value;
		$MorbidityMonth[]	=$rs_fld29->value;
		$MorbidityWeek[]	=$rs_fld30->value; 
		$admittoentry[]	=$rs_fld31->value;
		$onsettoadmit[]	=$rs_fld32->value;
		$sentinelsite[]	=$rs_fld33->value;
		$deleterecord[]	=$rs_fld34->value;
		$year[]	=$rs_fld35->value;
		$recStatus[]	=$rs_fld36->value;
		$uniqueKey[]	=$rs_fld37->value;
		$NameofDRU[]	=$rs_fld38->value;
		$ILHZ[]	=$rs_fld39->value;
		$district[]	=$rs_fld40->value;
		$barangay[]	=$rs_fld41->value; 
		$typeofhospital[]	=$rs_fld42->value;
		$sent[]	=$rs_fld43->value;
		
		$rs->MoveNext();
		// Do something with the data here, like put it into mysql, put it into a file, or print it to the screen
		
		}
		$rs->Close();
		$db_connection->Close();
		$crno = time().'-'.mt_rand();
			for ($i=0; $i < count($patientnum); $i++)
			{
			$date= explode ('/', $DOB[$i]);
			$date2= explode ('/', $dAdmit[$i]);
			$date3= explode ('/', $dOnset[$i]);
			$date4= explode ('/', $dateofentry[$i]);
			$data = array(
			'TPpatientno-txt' => $patientnum[$i],
			'TPfirstname-txt' => $firstname[$i],
			'TPlastname-txt' => $familyname[$i],			
			'TPage-txt' => $ageyears[$i],
			'TPsex-dd' => $sex[$i],
			'TPbirthdate-txt' =>  $date[2].'/'.$date[0].'/'.$date[1],
			'TPcity-txt' => $city[$i],
			'TPbarangay-txt' => $barangay[$i], 
			'TPstreet-txt' => 	$street[$i], 			
			'TPadmitted-rd' => 	$admitted[$i],
			'TPconsuldate-txt' =>  $date2[2].'-'.$date2[0].'-'.$date2[1],
			'TPillnessdate-txt' =>  $date3[2].'-'.$date3[0].'-'.$date3[1],
			'TPclassification-rd'=>$caseclassifiaction[$i],
			'TPtype-rd'=>$type[$i],
			'TPregion-txt' => $region[$i],
			'TPprovince2-txt' => $provofDRU[$i],
			'TPdru-txt' => $NameofDRU[$i],
			'TPaddress-txt'=>$addressofDRU[$i]	,
			'TPcity2-txt'=>$cityofDRU[$i],
			'TPprovince-txt' =>$province[$i]	,
			'TPoutcome-rd'=> $outcome[$i],
			'TPcrno-txt' => $crno,
			'TPdateofentry-txt' => $date4[2].'-'.$date4[0].'-'.$date4[1],
			);
			$this->Case_report->addCase($data);
			}
					$this->load->helper(array('form', 'url'));
		$data['base'] = $this->config->item('base_url');
		$data['css'] = $this->config->item('css');
		$data['title'] = 'View patients';
			$data['table'] = null;
			$data['script'] = '';
			$data['error'] =  '';
		$this->load->view('templates/header',$data);
		$data['result'] = "Successfully Uploaded " .  count($patientnum) . " Cases";
		$this->load->view('pages/view_upload',$data);
		$this->load->view('templates/footer');
		
		}
		else if ($this->input->post('TPsubmit') == 'Cancel')
		{
			$this->session->unset_userdata('TPuploadvalues');
		 	redirect('/upload/', 'refresh');
		}
	}
}
		
/* End of file user/upload.php */
/* Location: ./application/controllers/user/upload.php */