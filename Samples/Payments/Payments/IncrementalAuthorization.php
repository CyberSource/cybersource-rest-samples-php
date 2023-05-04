<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './AuthorizationForIncrementalAuthorizationFlow.php';

function IncrementalAuthorization()
{

    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationAuthorizationOptionsInitiatorArr = [
            "storedCredentialUsed" => true
    ];
    $processingInformationAuthorizationOptionsInitiator = new CyberSource\Model\Ptsv2paymentsidProcessingInformationAuthorizationOptionsInitiator($processingInformationAuthorizationOptionsInitiatorArr);

    $processingInformationAuthorizationOptionsArr = [
            "initiator" => $processingInformationAuthorizationOptionsInitiator
    ];
    $processingInformationAuthorizationOptions = new CyberSource\Model\Ptsv2paymentsidProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

    $processingInformationArr = [
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsidProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "additionalAmount" => "22.49",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsidOrderInformation($orderInformationArr);

    $merchantInformationArr = [
            "transactionLocalDateTime" => "20191002080000"
    ];
    $merchantInformation = new CyberSource\Model\Ptsv2paymentsidMerchantInformation($merchantInformationArr);

    $travelInformationArr = [
            "duration" => "4"
    ];
    $travelInformation = new CyberSource\Model\Ptsv2paymentsidTravelInformation($travelInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation,
            "travelInformation" => $travelInformation
    ];
    $requestObj = new CyberSource\Model\IncrementAuthRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentsApi($api_client);

    try {
        $id = AuthorizationForIncrementalAuthorizationFlow()[0]['id'];
        $apiResponse = $api_instance->incrementAuth($id, $requestObj);
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
    echo "\nIncrementalAuthorization Sample Code is Running..." . PHP_EOL;
    IncrementalAuthorization();
}
?>
