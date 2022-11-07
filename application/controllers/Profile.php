<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('Profile','english');
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
		$this->lang->load('Sidebar','english');
		$this->mainlib->header("Profile");
		$this->profileEntry();
		$this->mainlib->footer();
	}
	public function ProfileEntry()
	{
		$data['userTypes'] = $this->mainlib->getUserTypes();
		$this->load->view('admin/Profile', $data);
	}
	public function updateProfile()
	{
		$formData = json_encode(array(
			"id" => (!empty($_POST['employeeId'])) ? $_POST['employeeId'] : -1,
			"name" => $_POST['employeeName'],
			"login" => "",
			"email" => $_POST['emailId'],
			"phone" => "",
			"readonly" => (!empty($this->session->userdata('phone')))? $this->session->userdata('readonly') : false,
			"administrator" => (!empty($this->session->userdata('administrator')))? $this->session->userdata('administrator') : false,
			"map" => (!empty($this->session->userdata('map ')))? $this->session->userdata('map ') : "",
			"latitude" => (!empty($this->session->userdata('latitude')))? $this->session->userdata('latitude') : 0,
			"longitude" => (!empty($this->session->userdata('longitude')))? $this->session->userdata('longitude') : 0,
			"zoom" => (!empty($this->session->userdata('zoom')))? $this->session->userdata('zoom') : 0,
			"twelveHourFormat" => (!empty($this->session->userdata('twelveHourFormat')))? $this->session->userdata('twelveHourFormat') : false,
			"coordinateFormat" => (!empty($this->session->userdata('coordinateFormat')))? $this->session->userdata('coordinateFormat') : "",
			"disabled" => (!empty($this->session->userdata('disabled')))? $this->session->userdata('disabled') : false,
			"expirationTime" => (!empty($this->session->userdata('expirationTime')))? $this->session->userdata('expirationTime') : null,
			"deviceLimit" => (!empty($this->session->userdata('deviceLimit')))? $this->session->userdata('deviceLimit') : -1,
			"userLimit" => (!empty($this->session->userdata('userLimit')))? $this->session->userdata('userLimit') : 0,
			"deviceReadonly" => false,
			"limitCommands" => false,
			"poiLayer" => "",
			"token" => "",
			"attributes" => array(
				"Mail Address" => $_POST['mailAddress'],
				"Phone Number" => $_POST['phoneNumber'],
				"Company Role" => $_POST['companyRole'],
				"External Company" => $_POST['externalCompany'],
			)
		));
		$employeeId = $_POST['employeeId'];
			$updateResult = $this->UserModel->updateUser($employeeId, $formData);
			if (!empty($updateResult)) {
				$this->session->set_flashdata('info', 'Record Updated Successfully.. Kindly Login Again to see changes');
				redirect(base_url() . 'Profile', "refresh");
			} else {
				$this->session->set_flashdata('error', 'Record Not Updated');
				redirect(base_url() . 'Profile', "refresh");
			}
		
	}
	public function changePassword()
	{
		
	}

}
