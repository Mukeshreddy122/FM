<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
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
		$this->mainlib->header("Project");
		$this->projectEntry();
		$this->mainlib->footer();
	}
	public function projectEntry()
	{
		$data['test'] = "Projects";
		$projects = $this->ProjectModel->getProjects();
		// $projects = $this->apiresponse->convertData($this->ProjectModel->getProjects());
		// $projectName = [];
		// foreach ($projects as $key => $project) {
		// 	foreach ($project as $projKey => $projValue)
		// 		if ($projKey == 'name') {
		// 			array_push($projectName, $projValue);
		// 		}
		// }
		// print_r($projects);
		// print_r(sizeof($projects[0]['devicesList']));die;
		$data['projectInfo'] = $projects;
		$this->load->view('admin/Project', $data);
	}
	public function manageProject()
	{
		$formData = json_encode(array(
			'id' => (!empty($_POST['projectId'])) ? $_POST['projectId'] : -1,
			'name' => $_POST['projectName'],
			'uniqueId' => '0',
			'attributes' => array(
				'customerId' => $_POST['projectName'],
				'Project Cost' => $_POST['projectCost'],
				'Project Income' => $_POST['projectIncome'],
				'Project Devices' => $_POST['projectDevices'],
				'Project Manpower' => $_POST['projectManpower'],
				'Project StartTime' => $_POST['projectStartTime'],
				'Project EndTime' => $_POST['projectEndTime'],
			)
		));
		if (empty($_POST['projectId'])) { #create Project
			$projectResult = $this->ProjectModel->postProject($formData);
			$projectData = [];
			if (!empty($projectResult)) {
				$projectData = json_encode(
					array(
						"id" => -1,
						"name" => $_POST['projectName'],
						"uniqueId" => "0",
						"attributes" => array(
							"customerId" => $_POST['projectName'],
							"Project Cost" => $_POST['projectCost'],
							"Project Income" => $_POST['projectIncome'],
							"Project Devices" => $_POST['projectDevices'],
							"Project Manpower" => $_POST['projectManpower'],
							"Project StartTime" => $_POST['projectStartTime'],
							"Project EndTime" => $_POST['projectEndTime']
						)
					)
				);
				if (empty($_POST['projectId'])) {
					// echo 'console.log("Creating user now!")';
					$adminUserResult = $this->UserModel->postUser($projectData);
					if (!empty($adminUserResult)) {
						$mapAdmin = json_encode(
							array(
								"userId"  => $adminUserResult['id'],
								"projectId" => $projectResult['id']
							)
						);
						$permissionResult = $this->PermissionModel->postPermission($mapAdmin);
						if ($permissionResult['successWithNoContent']) {
							redirect(base_url() . 'Project', "refresh");
						}
					} else {
						// Can't create user due to some issue. Roll back and provide alert. 
						$this->session->set_flashdata("error", "Please use a different email address");
						$this->ProjectModel->deleteProject($projectResult['id']);
						// redirect(base_url() . 'Project');
					}
				} else {
					// $this->session->set_flashdata("error", "Unable to create Project");
				}
			}
		} else { #update project
			$id = $_POST['projectId'];
			$updateProject = $this->ProjectModel->updateProject($id, $formData);
			if (!empty($updateProject)) {
				redirect(base_url() . 'Project', "refresh");
			}
		}
	}
	public function delete()
	{
		$success = $this->ProjectModel->deleteProject($this->input->get('id'));
		if ($success == 204) {
			redirect(base_url() . 'Project', "refresh");
		}
	}
}
