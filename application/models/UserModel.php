<?php
defined('BASEPATH') or exit('No direct script allowed');

class UserModel extends CI_Model
{
    public $url;
    public $headers = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ApiRequests');
        $this->load->library('ApiResponse');
        $this->load->library('session');
        $this->url = $this->apirequests->baseApiUrlNew();
        $this->headers = $this->apirequests->headers();
    }

    #select
    public function getUsers()
    {
        $response = \WpOrg\Requests\Requests::GET($this->url . 'employee', $this->headers, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #insert
    public function postUser($param)
    {
        $response = \WpOrg\Requests\Requests::post($this->url . "employee", $this->headers, $param, $this->apirequests->auth());
        // var_dump($response->body);
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #update
    public function updateUser($id, $param)
    {
        $response = \WpOrg\Requests\Requests::PUT($this->url . "employee/" . $id, $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #delete
    public function deleteUser($id)
    {
        $response = \WpOrg\Requests\Requests::PUT($this->url . "employee/" . $id, $this->headers, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }
}
