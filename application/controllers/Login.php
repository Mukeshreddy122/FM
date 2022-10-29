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
        try {
            //code...
            if (
                isset($_SESSION['uId']) 
                && isset($_SESSION['name'])
                && isset($_SESSION['permission'])
                && isset($_SESSION['USER_API_TOKEN'])
                && isset($_SESSION['customerId'])
                // && $_SESSION['myCustomerName'] != null
            ) {
                redirect(base_url() . 'PM');
            } else {
                $this->load->view('Login');
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->load->view('Login');
        }
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

                $uId = $logininfo['id'];
                $name = $logininfo['name'];
                $email = $logininfo['email'];
                // $phone = $logininfo['phone'];
                $permission = $logininfo['permission'];
                $user_api_token = $logininfo['USER_API_TOKEN'];
                $myCustomerName = $logininfo['customerName'];

                $arr = array(
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'USER_API_TOKEN' => $user_api_token
                );

                // $MailAddress = (array_key_exists('Mail Address', $logininfo)) ? $logininfo['Mail Address'] : "";
                // $PhoneNumber = (array_key_exists('Phone Number', $logininfo)) ? $logininfo['Phone Number'] : "";
                // $CompanyRole = (array_key_exists('Company Role', $logininfo)) ? $logininfo['Company Role'] : "";
                // $ExternalCompany = (array_key_exists('External Company', $logininfo)) ? $logininfo['External Company'] : "";
                // $ProjectConnection = (array_key_exists('Project Connection', $logininfo)) ? $logininfo['Project Connection'] : "";
                if ($permission == "ADMIN") {
                    $customerId = 0;
                } else {
                    $customerId = $logininfo['customerId'];
                }
                // $settings_customerName = 'true';
                // $settings_customerTypeOfCompany = $settingsInfo['customerTypeOfCompany'];
                $session_data = array(
                    'uId' => $uId,
                    'name' => $name,
                    'email' => $email,
                    // 'phone' => $phone,
                    // 'Mail Address' => $MailAddress,
                    // 'Phone Number' => $PhoneNumber,
                    // 'Company Role' => $CompanyRole,
                    // 'External Company' => $ExternalCompany,
                    // 'Project Connection' => $ProjectConnection,
                    'permission' => $permission,
                    'USER_API_TOKEN' => $user_api_token,
                    'customerId' => $customerId,
                    'myCustomerName' => $myCustomerName,
                    
                    // 'settings_customerName' => $settings_customerName,
                );

                $this->session->set_userdata($session_data);
                $sessionId = session_id();


                $settingsArray = $this->LoginModel->getSettings($arr);
                $this->session->set_userdata($settingsArray);
                echo $sessionId;

                // if ($permission == "ADMIN") {
                //     $customer = array(
                //         'name' => 'ADMIN'
                //     );
                // } else {
                //     $customer = $this->CustomerModel->getCustomer($logininfo['customerId']);
                // }

                // $customerArray = array(
                //     'myCustomerName' => $customer['name']
                // );
                // $this->session->set_userdata($customerArray);
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
