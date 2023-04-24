<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/SimpleAuthorizationInternet.php';

function ProcessAuthorizationReversal()
{
    $id = SimpleAuthorizationInternet("false")[0]['id'];

    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

    $reversalInformationAmountDetailsArr = [
            "totalAmount" => "102.21"
    ];
    $reversalInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($reversalInformationAmountDetailsArr);

    $reversalInformationArr = [
            "amountDetails" => $reversalInformationAmountDetails,
            "reason" => "testing"
    ];
    $reversalInformation = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformation($reversalInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "reversalInformation" => $reversalInformation
    ];
    $requestObj = new CyberSource\Model\AuthReversalRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ReversalApi($api_client);

    try {
        $apiResponse = $api_instance->authReversal($id, $requestObj);
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
    echo "\nProcessAuthorizationReversal Sample Code is Running..." . PHP_EOL;
    ProcessAuthorizationReversal();
}
?>
