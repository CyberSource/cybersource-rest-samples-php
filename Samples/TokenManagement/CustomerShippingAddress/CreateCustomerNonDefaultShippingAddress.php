<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateCustomerNonDefaultShippingAddress()
{
    $customerTokenId = 'AB695DA801DD1BB6E05341588E0A3BDC';
    $shipToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "company" => "CyberSource",
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $shipTo = new CyberSource\Model\Tmsv2customersEmbeddedDefaultShippingAddressShipTo($shipToArr);

    $requestObjArr = [
            "_default" => false,
            "shipTo" => $shipTo
    ];
    $requestObj = new CyberSource\Model\PostCustomerShippingAddressRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CustomerShippingAddressApi($api_client);

    try {
        $apiResponse = $api_instance->postCustomerShippingAddress($customerTokenId, $requestObj, null);
        print_r(PHP_EOL);
        print_r($apiResponse);

        WriteLogAudit($apiResponse[1]);
        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
        $errorCode = $e->getCode();
        WriteLogAudit($errorCode);
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    CreateCustomerNonDefaultShippingAddress();
}
?>
