<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
  public $url;
  public $headers;
  public function __construct()
  {
    parent::__construct();
    $this->load->library('ApiRequests');
    $this->load->library('ApiResponse');
    $this->load->library('session');
    $this->url = $this->apirequests->baseApiUrl();
    $this->headers = $this->apirequests->headers();
  }

  public function validateLogin($param)
  {
    $response = WpOrg\Requests\Requests::POST($this->url . "authenticate", array(), $param, $this->apirequests->auth());
    return $this->apiresponse->getLoginApiResponse($response);
  }

  public function getSettings($param)
  {
    $response = WpOrg\Requests\Requests::GET($this->url . "settings", $param, $this->apirequests->auth());
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }

  public function logout($param)
  {
    $response = WpOrg\Requests\Requests::DELETE($this->url . "logout", $param, $this->apirequests->auth());
    return $this->apiresponse->getApiResponse($response->status_code, $response->body);
  }
}
