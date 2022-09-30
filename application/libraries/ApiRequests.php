<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH . "vendor/rmccue/requests/library/Requests.php";
class ApiRequests
{

    protected $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
        WpOrg\Requests\Autoload::register();
    }
    public function baseApiUrl()
    {
        //    return "http://13.126.242.39:8082/api/";
        // return "http://localhost:8082/api/";
        return "http://vghar.ddns.net:6060/ZFMS/";
    }
    public function baseApiUrlNew()
    {
        //    return "http://13.126.242.39:8082/api/";
        // return "http://localhost:6060/ZFMS/";
        //    return "http://vghar.ddns.net:50005/api/";
        return "http://vghar.ddns.net:6060/ZFMS/";

    }
    public function auth()
    {

        // if ($this->CI->session->userdata('USER_API_TOKEN') != null) {
        //     return array('' => '');
        // } else {
        return array(
            'auth' => new WpOrg\Requests\Auth\Basic(array($this->CI->session->userdata('email'), $this->CI->session->userdata('password'))),
            //  'auth' => new WpOrg\Requests\Auth\Basic(array('admin', 'admin')),
        );
        // }
    }
    public function headers()
    {
        if ($this->CI->session->userdata('USER_API_TOKEN') != null) {
            return array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'USER_API_TOKEN' => $this->CI->session->userdata('USER_API_TOKEN')
            );
        } else {
            return array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            );
        }
    }
}
