<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public $options;
    public $apiUrl;

    public function __construct()
    {
        parent::__construct();

        //load Dashboard Library                
        $this->load->library('Mainlib');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('Login');
        // redirect(base_url() . 'Login');
    }

    public function validateLogin()
    {
        $this->form_validation->set_rules('userName', 'UserName', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        //validate user id and password

        if ($this->form_validation->run()) {
            $cred = array('email' => $_POST['userName'], 'password' => md5($_POST['password']), 'deviceDetails' => $_POST['ddetails']);
            $loginArray = $this->LoginModel->validateLogin(json_encode($cred));
            //print_r($loginArray);
            if (!empty($loginArray)) {
                $logininfo = $this->apiresponse->convertSingleData($loginArray);
                // $settingsArray = $this->LoginModel->getSettings(json_encode($cred));
                // $settingsInfo = $this->apiresponse->convertSingleData($settingsArray);

                $uId = $logininfo['id'];
                $name = $logininfo['name'];
                $email = $logininfo['email'];
                $phone = $logininfo['phone'];
                $permission = $logininfo['permission'];
                $user_api_token = $logininfo['USER_API_TOKEN'];
                $MailAddress = (array_key_exists('Mail Address', $logininfo)) ? $logininfo['Mail Address'] : "";
                $PhoneNumber = (array_key_exists('Phone Number', $logininfo)) ? $logininfo['Phone Number'] : "";
                $CompanyRole = (array_key_exists('Company Role', $logininfo)) ? $logininfo['Company Role'] : "";
                $ExternalCompany = (array_key_exists('External Company', $logininfo)) ? $logininfo['External Company'] : "";
                $ProjectConnection = (array_key_exists('Project Connection', $logininfo)) ? $logininfo['Project Connection'] : "";
                
                // $settings_customerName = 'true';
                // $settings_customerTypeOfCompany = $settingsInfo['customerTypeOfCompany'];
                $session_data = array(
                    'uId' => $uId,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'Mail Address' => $MailAddress,
                    'Phone Number' => $PhoneNumber,
                    'Company Role' => $CompanyRole,
                    'External Company' => $ExternalCompany,
                    'Project Connection' => $ProjectConnection,
                    'permission' => $permission,
                    'USER_API_TOKEN' => $user_api_token,
                    // 'settings_customerName' => $settings_customerName,
                );

                $this->session->set_userdata($session_data);
                $sessionId = session_id();
                echo $sessionId;
                $this->load->helper('cookie');
                $session_id = get_cookie('ci_session');
                echo $session_id;


                redirect(base_url() . 'PM');
            } else {
                $this->session->set_flashdata('error', 'Invalid UserName / Password.');
                // redirect(base_url() . 'Login/validateLogin');
                redirect(base_url() . 'Login');
            }
        } else {
            //false
            $this->index();
        }
    }
}
