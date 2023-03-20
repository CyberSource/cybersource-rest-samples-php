<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'CommittedTaxCallRequest.php';

function VoidCommittedTaxCall()
{
    $id = CommittedTaxCallRequest()[0]['id'];
    $clientReferenceInformationArr = [
            "code" => "TAX_TC001"
    ];
    $clientReferenceInformation = new CyberSource\Model\Vasv2taxidClientReferenceInformation($clientReferenceInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation
    ];
    $requestObj = new CyberSource\Model\VoidTaxRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\TaxesApi($api_client);

    try {
        $apiResponse = $api_instance->voidTax($requestObj, $id);
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
    VoidCommittedTaxCall();
}
?>
