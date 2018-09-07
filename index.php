<?php

/**
* Copyright (c) 2018, Teapplix, Inc.
* All rights reserved.
*/

require 'TeapplixAPI.php';

//INIT PART
$apiToken = '25911-eb49c-57f72-65113-4e5c4-5110b-aa61';

//MAIN PART
try {
    $api = new TeapplixAPI($apiToken);
    
    //GET request
    $data = array(
        'StoreType' => 'ebay',
        'PaymentDateStart' => '2018/09/07'
    );
    $endpoint = 'OrderNotification';
    $result = $api->call($endpoint, TeapplixAPI::METHOD_GET, $data);
    //handle $data here
    
    //POST request
    $data = array(
        'Operation' => 'Submit',
        'Orders' => array(
            array(
                'TxnId' => 'your-order-ID',
                'StoreType' => 'generic',
                'PaymentStatus' => 'Completed',
                'To' => array(
                    'Name' =>  'John Smith',
                    'Street' => '2019 Dixie Belle Dr',
                    'State' => 'FL',
                    'City' => 'Orlando',
                    'ZipCode' => '32812',
                    'Country' => 'United States',
                    'CountryCode' => 'US',
                    'SkipAddressValidation' => false
                ),
                'OrderTotals' => array(
                    'Shipping' => 1,
                    'Total' => 5
                ),
                'OrderDetails' => array(
                    'PaymentDate' => '2018-09-07',
                ),
                'OrderItems' => array(
                    array (
                        'Name' => 'order item',
                        'Quantity' => 2,
                        'Amount' => 4,
                    )
                ),
                'ShippingDetails' => array(
                    array(
                        'Package' => array(
                            'Weight' => array(
                                'Value' => 10,
                                'Unit' => 'OZ'
                            )
                        )
                    )
                )
            )
        )
    );
    $endpoint = 'OrderNotification';
    $result = $api->call($endpoint, TeapplixAPI::METHOD_POST, $data);

    //handle $data here
} catch(\Exception $e) {
    //handle exception here
}