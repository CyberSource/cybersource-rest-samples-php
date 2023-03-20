<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateAdhocReport()
{
    $reportFields = array();
    $reportFields[0] = "Request.RequestID";
    $reportFields[1] = "Request.TransactionDate";
    $reportFields[2] = "Request.MerchantID";

    $reportPreferencesArr = [
            "signedAmounts" => true,
            "fieldNameConvention" => "SOAPI"
    ];
    $reportPreferences = new CyberSource\Model\Reportingv3reportsReportPreferences($reportPreferencesArr);

    $requestObjArr = [
            "reportDefinitionName" => "TransactionRequestClass",
            "reportFields" => $reportFields,
            "reportMimeType" => "application/xml",
            "reportName" => "testrest_v2",
            "timezone" => "GMT",
            "reportStartTime" => "2021-03-01T17:30:00.000+05:30",
            "reportEndTime" => "2021-03-02T17:30:00.000+05:30",
            "reportPreferences" => $reportPreferences
    ];
    $requestObj = new CyberSource\Model\CreateAdhocReportRequest($requestObjArr);

    $organizationId = "testrest";

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ReportsApi($api_client);

    try {
        $apiResponse = $api_instance->createReport($requestObj, $organizationId);
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
    echo "\nCreateAdhocReport Sample Code is Running..." . PHP_EOL;
    CreateAdhocReport();
}
?>
