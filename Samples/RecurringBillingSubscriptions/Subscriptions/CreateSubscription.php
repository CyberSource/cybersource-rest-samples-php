<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function CreateSubscription()
{
    $clientReferenceInformationPartnerArr = [
            "developerId" => "ABCD1234",
            "solutionId" => "GEF1234"
    ];
    $clientReferenceInformationPartner = new CyberSource\Model\Rbsv1subscriptionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "TC501713",
            "partner" => $clientReferenceInformationPartner,
            "applicationName" => "CYBS-SDK",
            "applicationVersion" => "v1"
    ];
    $clientReferenceInformation = new CyberSource\Model\Rbsv1subscriptionsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationAuthorizationOptionsInitiatorArr = [
            "type" => "merchant"
    ];
    $processingInformationAuthorizationOptionsInitiator = new CyberSource\Model\Rbsv1subscriptionsProcessingInformationAuthorizationOptionsInitiator($processingInformationAuthorizationOptionsInitiatorArr);

    $processingInformationAuthorizationOptionsArr = [
            "initiator" => $processingInformationAuthorizationOptionsInitiator
    ];
    $processingInformationAuthorizationOptions = new CyberSource\Model\Rbsv1subscriptionsProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

    $processingInformationArr = [
            "commerceIndicator" => "recurring",
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSource\Model\Rbsv1subscriptionsProcessingInformation($processingInformationArr);

    $subscriptionInformationArr = [
            "planId" => "6868912495476705603955",
            "name" => "Subscription with PlanId" . generateRandomString(3),
            "startDate" => "2025-06-11"
    ];
    $subscriptionInformation = new CyberSource\Model\Rbsv1subscriptionsSubscriptionInformation($subscriptionInformationArr);

    $paymentInformationCustomerArr = [
            "id" => "C24F5921EB870D99E053AF598E0A4105"
    ];
    $paymentInformationCustomer = new CyberSource\Model\Rbsv1subscriptionsPaymentInformationCustomer($paymentInformationCustomerArr);

    $paymentInformationArr = [
            "customer" => $paymentInformationCustomer
    ];
    $paymentInformation = new CyberSource\Model\Rbsv1subscriptionsPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "subscriptionInformation" => $subscriptionInformation,
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSource\Model\CreateSubscriptionRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SubscriptionsApi($api_client);

    try {
        $apiResponse = $api_instance->createSubscription($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);
        WriteLogAudit($apiResponse[1]);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r("HELLO");
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nCreateSubscription Sample Code is Running..." . PHP_EOL;
    CreateSubscription();
}
?>