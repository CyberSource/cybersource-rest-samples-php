<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function UpdateInstrumentIdentifierPreviousTransactionId()
{
    $instrumentIdentifierTokenId = '7010000000016241111';
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

    $processingInformationAuthorizationOptionsInitiatorMerchantInitiatedTransactionArr = [
            "previousTransactionId" => "123456789012345"
    ];
    $processingInformationAuthorizationOptionsInitiatorMerchantInitiatedTransaction = new CyberSource\Model\Tmsv2customersEmbeddedMerchantInitiatedTransaction($processingInformationAuthorizationOptionsInitiatorMerchantInitiatedTransactionArr);

    $processingInformationAuthorizationOptionsInitiatorArr = [
            "merchantInitiatedTransaction" => $processingInformationAuthorizationOptionsInitiatorMerchantInitiatedTransaction
    ];
    $processingInformationAuthorizationOptionsInitiator = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierProcessingInformationAuthorizationOptionsInitiator($processingInformationAuthorizationOptionsInitiatorArr);

    $processingInformationAuthorizationOptionsArr = [
            "initiator" => $processingInformationAuthorizationOptionsInitiator
    ];
    $processingInformationAuthorizationOptions = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

    $processingInformationArr = [
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierProcessingInformation($processingInformationArr);

    $requestObjArr = [
            "processingInformation" => $processingInformation
    ];
    $requestObj = new CyberSource\Model\PatchInstrumentIdentifierRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\InstrumentIdentifierApi($api_client);

    try {
        $apiResponse = $api_instance->patchInstrumentIdentifier($instrumentIdentifierTokenId, $requestObj, $profileid, null);
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
    UpdateInstrumentIdentifierPreviousTransactionId();
}
?>
