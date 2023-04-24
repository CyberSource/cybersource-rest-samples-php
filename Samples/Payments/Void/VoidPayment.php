<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/SimpleAuthorizationInternet.php';

function VoidPayment()
{
    $id = SimpleAuthorizationInternet("false")[0]['id'];

    $clientReferenceInformationArr = [
            "code" => "test_void"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation
    ];
    $requestObj = new CyberSource\Model\VoidPaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\VoidApi($api_client);

    try {
        $apiResponse = $api_instance->voidPayment($requestObj, $id);
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
    echo "\nVoidPayment Sample Code is Running..." . PHP_EOL;
    VoidPayment();
}
?>
