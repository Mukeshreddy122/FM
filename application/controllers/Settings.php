<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
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
		$this->mainlib->header("Settings");
		$this->SettingsEntry();
		$this->mainlib->footer();
	}
	public function SettingsEntry()
	{
		$data['test'] = "Settings";
		$Settings = $this->apiresponse->convertData($this->SettingsModel->getSettings());
		// print_r($Settings);die;
		$SettingsName = [];
		foreach ($Settings as $key => $Settings) {
			foreach ($Settings as $key => $custValue)
				//print($key . " ::: " . $custValue);
			if ($key == 'name') {
				array_push($SettingsName, $custValue);
			}
		}
		$data['SettingsInfo'] = $Settings;
		$data['SettingsName'] = $SettingsName;
		$this->load->view('admin/Settings', $data);
	}
	public function manageSettings()
	{
		$formData = json_encode(array(
			'id' => (!empty($_POST['SettingsId'])) ? $_POST['SettingsId'] : -1,
			'name' => $_POST['SettingsName'],
			'groupId' => '0',
			'attributes' => array(
				'Settings Type' => $_POST['typeOfCompany'],
				'SettingsIndustry' => $_POST['industry'],
				'No. of Employees' => $_POST['numberOfEmployees'],
				'VAT Number' => $_POST['vatNumber'],
				'Visit Address' => $_POST['visitAdress'],
				'Post Address' => $_POST['postAdress'],
				'Sister Companies' => $_POST['sisterCompanies']
			)
		));
		if (empty($_POST['SettingsId'])) { #create Settings
			$SettingsResult = $this->SettingsModel->postSettings($formData);
			$userData = [];
			if (!empty($SettingsResult)) {
				$userData = json_encode(
					array(
						"id" => -1,
						"name" => $_POST['SettingsName'],
						"email" => $_POST['emailId'],
						"phone" => "",
						"readonly" => false,
						"administrator" => true,
						"map" => "",
						"latitude" => 0.0,
						"longitude" => 0.0,
						"zoom" => 0,
						"password" => $_POST['password'],
						"twelveHourFormat" => false,
						"coordinateFormat" => null,
						"disabled" => false,
						"expirationTime" => null,
						"deviceLimit" => -1,
						"userLimit" => $_POST['numberOfEmployees'],
						"deviceReadonly" => false,
						"limitCommands" => false,
						"poiLayer" => null,
						"token" => "",
						"attributes" => array(
							"Mail Address" => "",
							"Phone Number" => "",
							"Company Role" => "",
							"Externally company" => ""
						)
					)
				);
				if (empty($_POST['SettingsId'])) {
					$adminUserResult = $this->UserModel->postUser($userData);
					if (!empty($adminUserResult)) {
						$mapAdmin = json_encode(
							array(
								"userId"  => $adminUserResult['id'],
								"groupId" => $SettingsResult['id']
							)
						);
						$permissionResult = $this->PermissionModel->postPermission($mapAdmin);
						if ($permissionResult['successWithNoContent']) {
							redirect(base_url() . 'Settings', "refresh");
						}
					}
				} else {
				}
			}
		} else { #update Settings
			$id = $_POST['SettingsId'];
			$updateSettings = $this->SettingsModel->updateSettings($id, $formData);
			if (!empty($updateSettings)) {
				redirect(base_url() . 'Settings', "refresh");
			}
		}
	}
	public function delete()
	{
		$success = $this->SettingsModel->deleteSettings($this->input->get('id'));
		if ($success == 204) {
			redirect(base_url() . 'Settings', "refresh");
		}
	}
}
