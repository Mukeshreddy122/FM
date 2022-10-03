<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SettingsModel extends CI_Model
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
  public function getSettings()
  {
    $options['settingId'] = $this->session->userdata('email');
    $response = WpOrg\Requests\Requests::GET($this->url . 'settings', $this->headers, $this->apirequests->auth());
    // print_r($response->body);die;
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  #Insert
  #public function postSettings($param)
  #{
  #  $response = WpOrg\Requests\Requests::POST($this->url.'server', $this->headers, $param, $this->apirequests->auth());
  #  return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  #}

  #update
  public function updateSettings($id, $param)
  {
    $response = \WpOrg\Requests\Requests::PUT($this->url . "settings", $this->headers, $param, $this->apirequests->auth());
  
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  #Delete
  #public function deleteSettings($id)
  #{
  #  $successResponse = \WpOrg\Requests\Requests::DELETE($this->url.'groups/'.$id, $this->headers, $this->apirequests->auth());
  #  return $successResponse->status_code;
  #}
}
