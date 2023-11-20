<?php

use CyberSource\Api\TokenApi;

require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './CreateInstrumentIdentifierCardEnrollForNetworkToken.php';

function PaymentCredentialsFromNetworkToken($tokenID = null) {
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
    if (!isset($tokenID)) {
        $tokenID = CreateInstrumentIdentifierCardEnrollForNetworkToken()[0]['id'];
    }
    print_r($tokenID);
    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new TokenApi($api_client);

    try {
        $apiResponse = $api_instance->postTokenPaymentCredentials($tokenID, $profileid);
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
        print_r("\n[Sample Code Testing] [$sampleCode] $status".PHP_EOL);
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nPaymentCredentialsForNetworkToken Sample Code is Running..." . PHP_EOL;
    PaymentCredentialsFromNetworkToken();
}