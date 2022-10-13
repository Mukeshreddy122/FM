<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Logout extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//load Dashboard Library                
		$this->load->library('Mainlib');
		$this->load->library('session');
	}
	function index()
	{
		$arr = array(
			'Accept' => 'application/json',
			'Content-Type' => 'application/json',
			'USER_API_TOKEN' => $_SESSION['USER_API_TOKEN']
		);

		$this->LoginModel->logout($arr);
		$userId = $this->session->userdata('uId');
		// $sessionId = session_id();
		$this->session->sess_destroy();
		$this->session->set_flashdata('info', 'User Successfully Logged Out');
		redirect(base_url(), 'refresh');
	}
}
