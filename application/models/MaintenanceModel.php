<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaintenanceModel extends CI_Model
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


    #Select
    public function getAllMaintenance()
    {
        $options['userId'] = $this->session->userdata('email');
        $response = WpOrg\Requests\Requests::GET($this->url . 'maintenance', $this->headers, $this->apirequests->auth());
        // print_r($response->body);
        // die;
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Select
    public function getMaintenance($maintenanceId)
    {
        $options['userId'] = $this->session->userdata('email');
        $response = WpOrg\Requests\Requests::GET($this->url . 'maintenance/' . $maintenanceId, $this->headers, $this->apirequests->auth());
        // print_r($response->body);
        // die;
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Insert
    public function postMaintenance($param)
    {
        $response = WpOrg\Requests\Requests::POST($this->url . 'maintenance', $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #update
    public function updateMaintenance($id, $param)
    {
        $response = \WpOrg\Requests\Requests::PUT($this->url . "maintenance/" . $id, $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Delete
    public function deleteMaintenance($id)
    {
        $successResponse = \WpOrg\Requests\Requests::PUT($this->url . 'maintenance/' . $id, $this->headers, $this->apirequests->auth());
        return $successResponse->status_code;
    }
}
