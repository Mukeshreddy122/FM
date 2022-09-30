<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerModel extends CI_Model
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


  #Select
  public function getCustomers()
  {
    $options['userId'] = $this->session->userdata('email');
    $response = WpOrg\Requests\Requests::GET($this->url . 'customer', $this->headers, $this->apirequests->auth());
    // print_r($response->body);die;
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  #Insert
  public function postCustomer($param)
  {
    $response = WpOrg\Requests\Requests::POST($this->url . 'customer', $this->headers, $param, $this->apirequests->auth());
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  #update
  public function updateCustomer($id, $param)
  {
    $response = \WpOrg\Requests\Requests::PUT($this->url . "customer/" . $id, $this->headers, $param, $this->apirequests->auth());
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  #Delete
  public function deleteCustomer($id)
  {
    $successResponse = \WpOrg\Requests\Requests::PUT($this->url . 'customer/' . $id, $this->headers, $this->apirequests->auth());
    return $successResponse->status_code;
  }
}
