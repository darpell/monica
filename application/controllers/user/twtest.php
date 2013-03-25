<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Twtest extends CI_Controller {

	/* show link to connect to Twiiter */
	public function index() {
		$this->load->library('twconnect');
		$ok = $this->twconnect->twredirect('tweet/callback');
	}
	public function testpost()
	{	$this->load->library('twconnect');
		$this->load->model('Cho_model');
		$this->twconnect->twaccount_verify_credentials();
		
	if ($this->input->post('tweettype') == 'epi')
	{

		$parameters = array(
				'status' => $status
		);
	}
	else if ($this->input->post('tweettype') == 'count')
	{
		$parameters = array(
				'status' => $status
		);
	}
	else if ($this->input->post('tweettype') == 'fact')
	{
		$msg = $this->Cho_model->randomfact();
		
		$parameters = array(
				'status' => $msg
		);
	}
	else if ($this->input->post('tweettype') == 'msg')
	{
		
	}
	$this->twconnect->tw_post('https://api.twitter.com/1.1/statuses/update.json',$parameters);
		
	}
	/* redirect to Twitter for authentication */
	public function redirect() {
		$this->load->library('twconnect');

		/* twredirect() parameter - callback point in your application */
		/* by default the path from config file will be used */
		$ok = $this->twconnect->twredirect('tweet/callback');

		if (!$ok) {
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}


	/* return point from Twitter */
	/* you have to call $this->twconnect->twprocess_callback() here! */
	public function callback() {
		$this->load->library('twconnect');

		$ok = $this->twconnect->twprocess_callback();
		
		if ( $ok ) { }
			else redirect ('tweet/failure');
	}


	/* authentication successful */
	/* it should be a different function from callback */
	/* twconnect library should be re-loaded */
	/* but you can just call this function, not necessarily redirect to it */


	/* authentication un-successful */
	public function failure() {

		echo '<p>Twitter connect failed</p>';
		echo '<p><a href="' . base_url() . 'tweet/clearsession">Try again!</a></p>';
	}


	/* clear session */
	public function clearsession() {

		$this->session->sess_destroy();

		redirect('/tweet');
	}

}