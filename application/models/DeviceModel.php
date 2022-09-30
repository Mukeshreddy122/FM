<?php
defined('BASEPATH') or exit('No direct script allowed');

class DeviceModel extends CI_Model
{

    public $url;
    public $headers = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ApiRequests');
        $this->load->library('ApiResponse');
        $this->load->library('session');
        $this->url = $this->apirequests->baseApiUrl();
        $this->headers = $this->apirequests->headers();
    }

    #select
    public function getDevice()
    {
        $request = \WpOrg\Requests\Requests::GET($this->url . "fleet", $this->headers, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($request->status_code, $request->body);
    }

    #insert
    public function postDevice($param)
    {
        $request = \WpOrg\Requests\Requests::POST($this->url . "fleet", $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($request->status_code, $request->body);
    }

    #update
    public function updateDevice($id, $param)
    {
        $request = \WpOrg\Requests\Requests::PUT($this->url . "fleet/" . $id, $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($request->status_code, $request->body);
    }

    #delete
    public function deleteDevice($id)
    {
        $request = \WpOrg\Requests\Requests::DELETE($this->url . "fleet" . $id, $this->headers, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($request->status_code, $request->body);
    }
}
