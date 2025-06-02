<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Subscriptions/CreateSubscription.php';

function UpdateSubscription()
{
    $id = CreateSubscription()[0]['id'];

    print_r($id);

    $clientReferenceInformationPartnerArr = [
            "developerId" => "ABCD1234",
            "solutionId" => "GEF1234"
    ];
    $clientReferenceInformationPartner = new CyberSource\Model\Rbsv1subscriptionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "APGHU",
            "partner" => $clientReferenceInformationPartner
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
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSource\Model\Rbsv1subscriptionsProcessingInformation($processingInformationArr);

    $subscriptionInformationArr = [
            "planId" => "424242442",
            "name" => "Gold subs" . generateRandomString(3),
            "startDate" => "2024-06-15"
    ];
    $subscriptionInformation = new CyberSource\Model\Rbsv1subscriptionsidSubscriptionInformation($subscriptionInformationArr);

    $orderInformationAmountDetailsArr = [
            "billingAmount" => "10",
            "setupFee" => "5"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Rbsv1subscriptionsidOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Rbsv1subscriptionsidOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "subscriptionInformation" => $subscriptionInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\UpdateSubscription($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SubscriptionsApi($api_client);

    try {
        $apiResponse = $api_instance->updateSubscription($id, $requestObj);
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nUpdateSubscription Sample Code is Running..." . PHP_EOL;
    UpdateSubscription();
}
?>