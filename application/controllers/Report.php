<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Mainlib');
		$this->load->library('form_validation');
		$userId = $this->session->userdata('uId');
		if ($userId == null) {
			$this->session->sess_destroy();
			redirect(base_url(), 'refresh');
		}
	}
	public function index()
	{
		$this->mainlib->header("Report");
		$this->reportEntry();
		$this->mainlib->footer();
	}
	public function reportEntry()
	{
		$data['Report'] = "";
		$this->load->view('admin/Report', $data);
	}
	public function manageReport()
	{
		
	}
	
	public function delete()
	{
	}
}
