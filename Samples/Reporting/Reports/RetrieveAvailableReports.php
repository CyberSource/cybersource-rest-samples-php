<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function RetrieveAvailableReports()
{
    $organizationId = null;
    $startTime = "2021-04-01T00:00:00Z";
    $endTime = "2021-04-03T23:59:59Z";
    $timeQueryType = "executedTime";
    $reportMimeType = "application/xml";
    $reportFrequency = null;
    $reportName = null;
    $reportDefinitionId = null;
    $reportStatus = null;

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ReportsApi($api_client);

    try {
        $apiResponse = $api_instance->searchReports($startTime, $endTime, $timeQueryType, $organizationId, $reportMimeType, $reportFrequency, $reportName, $reportDefinitionId, $reportStatus);
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
    echo "\nRetrieveAvailableReports Sample Code is Running..." . PHP_EOL;
    RetrieveAvailableReports();
}
?>
