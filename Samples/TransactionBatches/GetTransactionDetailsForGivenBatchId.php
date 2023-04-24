<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetTransactionDetailsForGivenBatchId()
{
    $id = "12345";
    $uploadDate = "2019-08-30";
    $status = "Rejected";

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\TransactionBatchesApi($api_client);

    try {
        $apiResponse = $api_instance->getTransactionBatchDetails($id, $uploadDate, $status);
        print_r(PHP_EOL);
        print_r($apiResponse);

        $download_data = $apiResponse[0];
        $file_path = $commonElement->downloadReport($download_data, "BatchDetails.xml");
        echo "File downloaded in the location: \n" . $file_path . "\n";
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
    echo "\nGetTransactionDetailsForGivenBatchId Sample Code is Running..." . PHP_EOL;
    GetTransactionDetailsForGivenBatchId();
}
?>
