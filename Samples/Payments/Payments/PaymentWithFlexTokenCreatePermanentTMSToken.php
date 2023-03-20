<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function PaymentWithFlexTokenCreatePermanentTMSToken()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationActionList = array();
    $processingInformationActionList[0] = "TOKEN_CREATE";
    $processingInformationActionTokenTypes = array();
    $processingInformationActionTokenTypes[0] = "customer";
    $processingInformationActionTokenTypes[1] = "paymentInstrument";
    $processingInformationActionTokenTypes[2] = "shippingAddress";
    $processingInformationArr = [
            "actionList" => $processingInformationActionList,
            "actionTokenTypes" => $processingInformationActionTokenTypes,
            "capture" => false
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "102.21",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "1 Market St",
            "locality" => "san francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationShipToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "1 Market St",
            "locality" => "san francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US"
    ];
    $orderInformationShipTo = new CyberSource\Model\Ptsv2paymentsOrderInformationShipTo($orderInformationShipToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo,
            "shipTo" => $orderInformationShipTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $tokenInformationArr = [
            "transientTokenJwt" => "eyJraWQiOiIwODVLd3ZiZHVqZW1DZDN3UnNxVFg3RG5nZzlZVk04NiIsImFsZyI6IlJTMjU2In0.eyJkYXRhIjp7Im51bWJlciI6IjQxMTExMVhYWFhYWDExMTEiLCJ0eXBlIjoiMDAxIn0sImlzcyI6IkZsZXgvMDgiLCJleHAiOjE1OTU2MjAxNTQsInR5cGUiOiJtZi0wLjExLjAiLCJpYXQiOjE1OTU2MTkyNTQsImp0aSI6IjFFMTlWWVlBUEFEUllPSzREUUM1NFhRN1hUVTlYN01YSzBCNTc5UFhCUU1HUUExVU1MOFI1RjFCM0IzQTU4MkIifQ.NKSM8zuT9TQC2OIUxIFJQk4HKeHhj_RGWmEqOQhBi0TIynt_kCIup1UVtAlhPzUfPWLwRrUVXnA9dyjLt_Q-pFZnvZ2lVANbiOq_R0us88MkM_mqaELuInCwxFeFZKA4gl8XmDFARgX1aJttC19Le6NYOhK2gpMrV4i0yz-IkbScsk0_vCH3raayNacFU2Wy9xei6H_V0yw2GeOs7kF6wdtMvBNw_uoLXd77LGE3LmV7z1TpJcG1SXy2s0bwYhEvkQGnrq6FfY8w7-UkDBWT1GhU3ZVP4y7h0l1WEX2xqf_ze25ZiYJQfWrEWPBHXRubOpAuaf4rfeZei0mRwPU-sQ"
    ];
    $tokenInformation = new CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation,
            "tokenInformation" => $tokenInformation
    ];
    $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentsApi($api_client);

    try {
        $apiResponse = $api_instance->createPayment($requestObj);
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
    echo "\nPaymentWithFlexTokenCreatePermanentTMSToken Sample Code is Running..." . PHP_EOL;
    PaymentWithFlexTokenCreatePermanentTMSToken();
}
?>
