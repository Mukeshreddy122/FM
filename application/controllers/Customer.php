<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
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
		$this->mainlib->header("Customer");
		$this->customerEntry();
		$this->mainlib->footer();
	}
	public function customerEntry()
	{
		$data['test'] = "Customers";
		$customers = $this->apiresponse->convertData($this->CustomerModel->getCustomers());
		$customerName = [];
		foreach ($customers as $key => $customer) {
			foreach ($customer as $custKey => $custValue)
				if ($custKey == 'name') {
					array_push($customerName, $custValue);
				}
		}
		$data['customerInfo'] = $customers;
		$data['sisterCompanies'] = $customerName;
		$data['userTypes'] = $this->mainlib->getUserTypes();
		$this->load->view('admin/Customer', $data);
	}
	public function manageCustomer()
	{
		// print_r("CustomerID: " . $_POST['customerId']);
		$formData = json_encode(array(
			'id' => (!empty($_POST['customerId'])) ? $_POST['customerId'] : -1,
			'name' => $_POST['customerName'],
			'Customer Type' => $_POST['typeOfCompany'],
			'CustomerIndustry' => $_POST['industry'],
			'No. of Employees' => $_POST['numberOfEmployees'],
			'VAT Number' => $_POST['VAT Number'],
			'Visit Address' => $_POST['Visit Address'],
			'Post Address' => $_POST['Post Address'],
			'Sister Companies' => '[' . $_POST['sisterCompanies'] . ']',
			'customerStatus' => 0,
			'createdDate' => '',
			'employeesList' => [],
			'devicesList' => [],
			'projectList' => []
		));
		if (empty($_POST['customerId'])) { #create Customer
			$customerResult = $this->CustomerModel->postCustomer($formData);
			$userData = [];
			if (!empty($customerResult)) {
				$userData = json_encode(
					array(
						"id" => -1,
						"name" => $_POST['employeeName'],
						"phone" => "",
						"Mail Address" => $_POST['mailAddress'],
						"phone" => "",
						"Company Role" => $_POST['companyRole'],
						"customerId" => $customerResult['id'],
						"External Company" => $_POST['externalCompany'],
						"email" => $_POST['emailId'],
						"password" => md5($_POST['password']),
						"employeeStatus" => 0,
						"countryCode" => "",
						"permission" => "MANAGER",
						"createdDate" => "",
						"Projects List" => "[]",
						"devices list" => "[]"
					)
				);
				if (empty($_POST['customerId'])) {
					// echo 'console.log("Creating user now!")';
					$adminUserResult = $this->UserModel->postUser($userData);
					if (!empty($adminUserResult)) {
						// Created user successfully
					} else {
						// Can't create user due to some issue. Roll back and provide alert. 
						$this->session->set_flashdata("error", "Please use a different email address");
						$this->CustomerModel->deleteCustomer($customerResult['id']);
						// redirect(base_url() . 'Customer');
					}
				} else {
					// $this->session->set_flashdata("error", "Unable to create Customer");
				}
			}
		} else { #update customer
			$id = $_POST['customerId'];
			$updateCustomer = $this->CustomerModel->updateCustomer($id, $formData);
			if (!empty($updateCustomer)) {
				redirect(base_url() . 'Customer', "refresh");
			}
		}
	}
	public function delete()
	{
		$success = $this->CustomerModel->deleteCustomer($this->input->get('id'));
		// print_r($success);die;
		if ($success == 204) {
			redirect(base_url() . 'Customer', "refresh");
		} else {
			$this->session->set_flashdata("error", "Permission denied");
		}
	}
}
