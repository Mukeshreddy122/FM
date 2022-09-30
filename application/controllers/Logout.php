<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//load Dashboard Library                
        $this->load->library('Mainlib');
		$this->load->library('session');
	}
    function index()
    {
		$userId = $this->session->userdata('uId');
		// $sessionId = session_id();
		$this->session->sess_destroy();
		$this->session->set_flashdata('info', 'User Successfully Logged Out');
		redirect(base_url(),'refresh');
    }
}
