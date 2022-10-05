<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mainlib
{

    protected $CI;
    public function __construct()
    {
        // Do something with $params
        $this->CI = &get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('url_helper');
        $this->CI->load->library('encryption');
        //Models
        $this->CI->load->model('LoginModel');
        $this->CI->load->model('CustomerModel');
        $this->CI->load->model('UserModel');
        $this->CI->load->model('PermissionModel');
        $this->CI->load->model('DeviceModel');
        $this->CI->load->model('SettingsModel');
        $this->CI->load->model('ProjectModel');
    }
    public function header($title = "PM")
    {
        $userId = $this->CI->session->userdata('uId');
        if ($userId != null) {
            $data['title'] = $title;
            $data['name'] = $this->CI->session->userdata('name');
            $data['email'] = $this->CI->session->userdata('email');
            $data['phone'] = $this->CI->session->userdata('phone');
            $this->CI->load->view('templates/Preheader', $data);
            $this->CI->load->view('templates/Header', $data);
            $this->CI->load->view('templates/Sidebar');
            $this->CI->load->view('templates/Pageheader');
        }
    }
    public function footer()
    {
        $this->CI->load->view('templates/Footer');
    }
    public function getUserTypes()
    {
        return array(
            'Administrator', 'Manager', 'User'
        );
    }
    #list of devices
    public function senderTypes()
    {
        return array(
            'GSM', ' Beacon', 'Static List Elements'
        );
    }

    #list of object Categories
    public function objectCategories()
    {
        return array(
            'Screw Driver', 'Saw', 'Drill Machine'  
        );
    }
}
