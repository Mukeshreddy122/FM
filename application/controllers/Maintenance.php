<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maintenance extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('Maintenance','swedish');
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
		$this->mainlib->header("Maintenance");
		$this->maintenanceEntry();
		$this->mainlib->footer();
	}
	public function maintenanceEntry()
	{
		$data['test'] = "Maintenances";
		$maintenances = $this->MaintenanceModel->getAllMaintenance();
		// $maintenances = $this->apiresponse->convertData($this->MaintenanceModel->getMaintenances());
		// $maintenanceName = [];
		// foreach ($maintenances as $key => $maintenance) {
		// 	foreach ($maintenance as $projKey => $projValue)
		// 		if ($projKey == 'name') {
		// 			array_push($maintenanceName, $projValue);
		// 		}
		// }
		// print_r($maintenances);
		// print_r(sizeof($maintenances[0]['devicesList']));die;
		$data['maintenanceInfo'] = $maintenances;
		$this->load->view('admin/Maintenance', $data);
	}
	public function manageMaintenance()
	{
		$formData = json_encode(array(
			'id' => (!empty($_POST['maintenanceId'])) ? $_POST['maintenanceId'] : -1,
			'name' => $_POST['maintenanceName'],
			'uniqueId' => '0',
			'attributes' => array(
				'customerId' => $_POST['maintenanceName'],
				'Maintenance Cost' => $_POST['maintenanceCost'],
				'Maintenance Income' => $_POST['maintenanceIncome'],
				'Maintenance Devices' => $_POST['maintenanceDevices'],
				'Maintenance Manpower' => $_POST['maintenanceManpower'],
				'Maintenance StartTime' => $_POST['maintenanceStartTime'],
				'Maintenance EndTime' => $_POST['maintenanceEndTime'],
			)
		));
		if (empty($_POST['maintenanceId'])) { #create Maintenance
			$maintenanceResult = $this->MaintenanceModel->postMaintenance($formData);
			$maintenanceData = [];
			if (!empty($maintenanceResult)) {
				$maintenanceData = json_encode(
					array(
						"id" => -1,
						"name" => $_POST['maintenanceName'],
						"uniqueId" => "0",
						"attributes" => array(
							"customerId" => $_POST['maintenanceName'],
							"Maintenance Cost" => $_POST['maintenanceCost'],
							"Maintenance Income" => $_POST['maintenanceIncome'],
							"Maintenance Devices" => $_POST['maintenanceDevices'],
							"Maintenance Manpower" => $_POST['maintenanceManpower'],
							"Maintenance StartTime" => $_POST['maintenanceStartTime'],
							"Maintenance EndTime" => $_POST['maintenanceEndTime']
						)
					)
				);
				if (empty($_POST['maintenanceId'])) {
					// echo 'console.log("Creating user now!")';
					$adminUserResult = $this->UserModel->postUser($maintenanceData);
					if (!empty($adminUserResult)) {
						$mapAdmin = json_encode(
							array(
								"userId"  => $adminUserResult['id'],
								"maintenanceId" => $maintenanceResult['id']
							)
						);
						$permissionResult = $this->PermissionModel->postPermission($mapAdmin);
						if ($permissionResult['successWithNoContent']) {
							redirect(base_url() . 'Maintenance', "refresh");
						}
					} else {
						// Can't create user due to some issue. Roll back and provide alert. 
						$this->session->set_flashdata("error", "Please use a different email address");
						$this->MaintenanceModel->deleteMaintenance($maintenanceResult['id']);
						// redirect(base_url() . 'Maintenance');
					}
				} else {
					// $this->session->set_flashdata("error", "Unable to create Maintenance");
				}
			}
		} else { #update maintenance
			$id = $_POST['maintenanceId'];
			$updateMaintenance = $this->MaintenanceModel->updateMaintenance($id, $formData);
			if (!empty($updateMaintenance)) {
				redirect(base_url() . 'Maintenance', "refresh");
			}
		}
	}
	public function delete()
	{
		$success = $this->MaintenanceModel->deleteMaintenance($this->input->get('id'));
		if ($success == 204) {
			redirect(base_url() . 'Maintenance', "refresh");
		}
	}
}
