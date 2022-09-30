<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Mainlib');
		$userId = $this->session->userdata('uId');
		if ($userId == null) {
			$this->session->sess_destroy();
			redirect(base_url(), 'refresh');
		}
	}
	public function index()
	{
		$this->mainlib->header();
		$this->testEntry();
		$this->mainlib->footer();
	}
	public function testEntry()
	{
		$this->load->view('Test');
	}
}
