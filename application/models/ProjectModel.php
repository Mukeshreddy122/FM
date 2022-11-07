<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProjectModel extends CI_Model
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
    public function getProjects()
    {
        $options['userId'] = $this->session->userdata('email');
        $response = WpOrg\Requests\Requests::GET($this->url . 'project?' . rand(0,10000), $this->headers, $this->apirequests->auth());
        // print_r($response->body);
        // die;
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Select
    public function getProject($projectId)
    {
        $options['userId'] = $this->session->userdata('email');
        $response = WpOrg\Requests\Requests::GET($this->url . 'project/' . $projectId, $this->headers, $this->apirequests->auth());
        // print_r($response->body);
        // die;
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Insert
    public function postProject($param)
    {
        $response = WpOrg\Requests\Requests::POST($this->url . 'project', $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #update
    public function updateProject($id, $param)
    {
        $response = \WpOrg\Requests\Requests::PUT($this->url . "project/" . $id, $this->headers, $param, $this->apirequests->auth());
        return $this->apiresponse->getApiResponse($response->status_code, $response->body);
    }

    #Delete
    public function deleteProject($id)
    {
        $successResponse = \WpOrg\Requests\Requests::PUT($this->url . 'project/' . $id, $this->headers, $this->apirequests->auth());
        return $successResponse->status_code;
    }
}
