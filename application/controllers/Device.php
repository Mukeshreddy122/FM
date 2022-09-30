<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Device extends CI_Controller
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
		$this->mainlib->header("Device");
		$this->deviceEntry();
		$this->mainlib->footer();
	}
	public function deviceEntry()
	{
		$data['devices'] = $this->apiresponse->convertData($this->DeviceModel->getDevice());
		$data['senderTypes'] = $this->mainlib->senderTypes();
		$data['objectCategories'] = $this->mainlib->objectCategories();
		$this->load->view('admin/Device', $data);
	}
	public function manageDevice()
	{
		$formData = json_encode(array(
			"id" => (!empty($_POST['deviceId'])) ? $_POST['deviceId'] : -1,
			"name" => $_POST['deviceName'],
			"uniqueId" => "",
			"phone" => "",
			"model" => "",
			"contact" => "",
			"category" => null,
			"status" => null,
			"lastUpdate" => null,
			"groupId" => 0,
			"disabled" => false,
			"attributes" => array(
				"Device Website" => $_POST['deviceWebsite'],
				"Serial Number" => $_POST['serialNumber'],
				"Sender Number" => $_POST['senderNumber'],
				"Sender Type" => $_POST['senderType'],
				"Object Category" => $_POST['objectCategory'],
				"Fabrication" => $_POST['fabrication'],
				"Service Interval" => $_POST['intervalPrefix'] ." ". $_POST['intervalSuffix']
			)
		));
		if (empty($_POST['deviceId'])) {
			$createResult = $this->DeviceModel->postDevice($formData);
			if (!empty($createResult)) {
				$this->session->set_flashdata('info', 'Record Inserted Successfully');
				redirect(base_url() . 'Device', "refresh");
			} else {
				$this->session->set_flashdata('error', 'Record Not Inserted');
				redirect(base_url() . 'Device', "refresh");
			}
		} else {
			$deviceId = $_POST['deviceId'];
			$updateResult = $this->DeviceModel->updateDevice($deviceId, $formData);
			if (!empty($updateResult)) {
				$this->session->set_flashdata('info', 'Record Updated Successfully');
				redirect(base_url() . 'Device', "refresh");
			} else {
				$this->session->set_flashdata('error', 'Record Not Updated');
				redirect(base_url() . 'Device', "refresh");
			}
		}
	}

	public function delete()
	{
	}
}
