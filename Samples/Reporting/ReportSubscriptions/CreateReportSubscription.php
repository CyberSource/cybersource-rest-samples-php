<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateReportSubscription()
{
    $reportFields = array();
    $reportFields[0] = "Request.RequestID";
    $reportFields[1] = "Request.TransactionDate";
    $reportFields[2] = "Request.MerchantID";

    $requestObjArr = [
            "reportDefinitionName" => "TransactionRequestClass",
            "reportFields" => $reportFields,
            "reportMimeType" => "application/xml",
            "reportFrequency" => "WEEKLY",
            "reportName" => "testrest_subcription_v1",
            "timezone" => "GMT",
            "startTime" => "0900",
            "startDay" => 1
    ];
    $requestObj = new CyberSource\Model\CreateReportSubscriptionRequest($requestObjArr);

    $organizationId = null;

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ReportSubscriptionsApi($api_client);

    try {
        $apiResponse = $api_instance->createSubscription($requestObj, $organizationId);
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
    echo "\nCreateReportSubscription Sample Code is Running..." . PHP_EOL;
    CreateReportSubscription();
}
?>
