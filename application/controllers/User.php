<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $this->mainlib->header("PM-Dashboard");
        $this->dashboard();
        $this->mainlib->footer();
    }
    public function dashboard()
    {
        $data['Test'] = "Welcome To ZOFTECH User dashboard";
        $this->load->view('admin/User', $data);
    }
    public function customer()
    {

    }
}