<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('Employee','swedish');
		$this->load->library('Mainlib');
		$this->load->library('ApiResponse');
		$this->load->library('form_validation');
		$userId = $this->session->userdata('uId');
		if ($userId == null) {
			$this->session->sess_destroy();
			redirect(base_url(), 'refresh');
		}
	}
	public function index()
	{
		$this->lang->load('Sidebar','swedish');
		$this->mainlib->header("Employee");
		$this->employeeEntry();
		$this->mainlib->footer();
	}
	public function employeeEntry()
	{
		$data['employees'] = $this->apiresponse->convertData($this->UserModel->getUsers());
		$data['userTypes'] = $this->mainlib->getUserTypes();
		$data['employeeInfo'] = $this->UserModel->getUsers();
		$this->load->view('admin/Employee', $data);
	}
	public function manageEmployee()
	{
		// print_r($_POST);
		// die;
		$userLimit = 0;
		$readOnly = false;
		switch ($_POST['access']) {
			case 'User':
				$userLimit = 0;
				break;
			case 'Manager':
				$userLimit = 10;
				break;
			case 'Read Only':
				$userLimit = 0;
				$readOnly = true;
				break;
			default:
				$userLimit = 0;
				break;
		}
		$formData = json_encode(
			array(
				"id" => -1,
				"name" => $_POST['employeeName'],
				"phone" => "",
				"Mail Address" => $_POST['mailAddress'],
				"phone" => "",
				"Company Role" => $_POST['companyRole'],
				"customerId" => $_POST['customerId'],
				"External Company" => $_POST['externalCompany'],
				"email" => $_POST['emailId'],
				"password" => md5($_POST['password']),
				"employeeStatus" => 0,
				"countryCode" => "",
				"permission" => "MANAGER",
				"createdDate" => ""
			)
		);
		if (empty($_POST['employeeId'])) {
			$createResult = $this->UserModel->postUser($formData);
			if (!empty($createResult)) {
				$this->session->set_flashdata('info', 'Record Inserted Successfully');
				redirect(base_url() . 'Employee', "refresh");
			} else {
				$this->session->set_flashdata('error', 'Record Not Inserted');
				redirect(base_url() . 'Employee', "refresh");
			}
		} else {
			$employeeId = $_POST['employeeId'];
			$updateResult = $this->UserModel->updateUser($employeeId, $formData);
			if (!empty($updateResult)) {
				$this->session->set_flashdata('info', 'Record Updated Successfully');
				redirect(base_url() . 'Employee', "refresh");
			} else {
				$this->session->set_flashdata('error', 'Record Not Updated');
				redirect(base_url() . 'Employee', "refresh");
			}
		}
	}

	public function delete()
	{
		$success = $this->UserModel->deleteUser($this->input->get('id'));
		redirect(base_url() . 'Employee', "refresh");
	}
}
