<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetPurchaseAndRefundDetails()
{
    $startTime = "2021-10-01T12:00:00Z";
    $endTime = "2021-10-30T12:00:00Z";
    $organizationId = "testrest";
    $paymentSubtype = "VI";
    $viewBy = "requestDate";
    $groupName = "groupName";
    $offset = 20;
    $limit = 2000;

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PurchaseAndRefundDetailsApi($api_client);

    try {
        $apiResponse = $api_instance->getPurchaseAndRefundDetails($startTime, $endTime, $organizationId, $paymentSubtype, $viewBy, $groupName, $offset, $limit);
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
    echo "\nGetPurchaseAndRefundDetails Sample Code is Running..." . PHP_EOL;
    GetPurchaseAndRefundDetails();
}
?>
