<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ApiResponse
{
    public ?string $statusCode;
    public ?string $responseBody;

    protected $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getApiResponse($statusCode, $responseBody)
    {
        //  var_dump($responseBody);
        if ($statusCode == 200) {
            return json_decode($responseBody, true);
        } else if ($statusCode == 204) {
            return array("successWithNoContent" => true);
        } else {
            return array();
        }
    }
    // public function getApiResponse($statusCode, $responseBody)
    // public function getApiResponse($response)
    // {
    //     //  var_dump($responseBody);
    //     if ($response->statusCode == 200) {
    //         return json_decode($response->responseBody, true);
    //     } else if ($response->statusCode == 204) {
    //         return array("successWithNoContent" => true);
    //     } else {
    //         return array();
    //     }
    // }
    public function getLoginApiResponse($response)
    {
        //  var_dump($responseBody);
        if ($response->status_code == 200) {
            $user_api_token  = $response->headers->getValues('USER_API_TOKEN')[0];
            $response_body = $response->body;
            $response_json  = json_decode($response->body, true);
            $response_json['USER_API_TOKEN'] = $user_api_token;
            return $response_json;
        } else if ($response->status_code == 204) {
            return array("successWithNoContent" => true);
        } else {
            return array();
        }
    }
    public function convertData($response) #format response array at single level
    {
        return $response;
        // $responseArray = [];
        // if (is_array($response)) {
        //     foreach ($response as $indexKey => $indexValue) {
        //         if (is_array($indexValue)) {
        //             foreach ($indexValue as $fieldKey => $fieldValue) {
        //                 if (is_array($fieldValue)) {
        //                     foreach ($fieldValue as $Key => $Value) {
        //                         $responseArray[$indexKey][$Key] = $Value;
        //                     };
        //                 } else {
        //                     $responseArray[$indexKey][$fieldKey] = $fieldValue;
        //                 }
        //             }
        //         }
        //     }
        // }
        // return $responseArray;
    }
    public function convertSingleData($response) #format response array at single level
    {
        return $response;
        // $responseArray = [];
        // if (is_array($response)) {
        //     foreach ($response as $indexKey => $indexValue) {
        //         if (is_array($indexValue)) {
        //             foreach ($indexValue as $Key => $Value) {
        //                 $responseArray[$Key] = $Value;
        //             };
        //         } else {
        //             $responseArray[$indexKey] = $indexValue;
        //         }
        //     }
        // }
        // return $responseArray;
    }
}
