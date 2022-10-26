<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PM extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
       
        $this->lang->load('PM','english');
        $this->load->library('Mainlib');
        $userId = $this->session->userdata('uId');
        if ($userId == null) {
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        }
    }
    public function index()
    {
        $this->lang->load('Sidebar','english');
        $this->mainlib->header("PM-Dashboard");
        $this->dashboard();
        $this->mainlib->footer();
    }
    public function dashboard()
    {
        $data['title'] = "ZofTECH Admin Dashboard";
        $data['customerCount'] = sizeof($this->apiresponse->convertData($this->CustomerModel->getCustomers()));
        $data['employeeCount'] = sizeof($this->apiresponse->convertData($this->UserModel->getUsers()));
        $data['projectCount'] = sizeof($this->apiresponse->convertData($this->ProjectModel->getProjects()));
        $data['fleetCount'] = sizeof($this->apiresponse->convertData($this->DeviceModel->getDevice()));

        $this->load->view('admin/Dashboard', $data);
    }
    public function customer()
    {
    }
}
