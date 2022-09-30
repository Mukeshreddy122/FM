<?php
defined('BASEPATH') or exit("No direct script allowwed");

class PermissionModel extends CI_Model{
    
    public $url;
    public $headers = [];
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('ApiRequests');
        $this->load->library('ApiResponse');
        $this->url = $this->apirequests->baseApiUrl();
        $this->headers = $this->apirequests->headers();
    }

    #select
    public function getPermissions($param)
    {
     $response = \WpOrg\Requests\Requests::GET($this->url.'permissions'.$param, $this->headers, $this->apirequests->auth());
     //echo ($response->body);die;
     return $this->apiresponse->getApiResponse($response->status_code, $response->body);   
    }

    #create
    public function postPermission($param)
    {
        $response = WpOrg\Requests\Requests::POST($this->url.'permissions', $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #delete
    public function deletePermission($param)
    {
        # code...
    }
}