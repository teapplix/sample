<?php

/**
* Copyright (c) 2018, Teapplix, Inc.
* All rights reserved.
*/

class TeapplixAPI {
    protected $apiUrl = 'https://api.teapplix.com/api2/';
    protected $apiToken;
    
    const METHOD_GET = 'GET';       //use to get data from API
    const METHOD_POST = 'POST';     //use to create new object or submit data
    const METHOD_PUT = 'PUT';       //use to update object
    const METHOD_DELETE = 'DELETE'; //use to delete object
    
    public function __construct($apiToken) {
        $this->apiToken = $apiToken;
    }
    
    /**
     * Implement API call
     *
     * @param string $endpoint API Endpoint Name
     * @param string $method Method Verb
     * @param array $data Array of data to submit
     *
     * @throws Exception
     * 
     * @return array
     */
    public function call($endpoint, $method, $data) {
        $url = $this->apiUrl . $endpoint;
        
        $ch = @curl_init();
    
        if('GET' == $method) {
            //GET method does not support only query parameters, e.g. https://server.tld/endpoint?param1=value
            $query = http_build_query ($data);
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
        } else {
            //POST, PUT, DELETE methods support request body
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //send APIToken and Content-Type in header
        $header = array(
            'APIToken:' . $this->apiToken, 
            'Content-Type: application/json'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        if($info['http_code'] != 200) {
            throw new \Exception('API Request Exception');
        }

        $output = json_decode($output, true);
        
        return $output;
    }
}