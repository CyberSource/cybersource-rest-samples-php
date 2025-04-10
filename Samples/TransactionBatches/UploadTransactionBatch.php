<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function UploadTransactionBatch()
{
    try {
        // Specify the file name and path
        $fileName = "batchapiTest.csv";
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName;

        // Ensure the file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: " . $filePath);
        }

        // Create a file object
        $file = new SplFileObject($filePath);

        // Initialize configuration and API client
        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantDetails = $commonElement->getMerchantDetailsForBatchUploadSample();
        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\TransactionBatchesApi($api_client);

        // Upload the transaction batch
        $apiResponse = $api_instance->uploadTransactionBatch($file);

        // Print response details
        print_r(PHP_EOL);
        print_r("Response Code: " . $apiResponse[1] . PHP_EOL);
        print_r("Response Message: " . $apiResponse[0] . PHP_EOL);

        WriteLogAudit($apiResponse[1]);
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
        WriteLogAudit($e->getCode());
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

if (!function_exists('WriteLogAudit')) {
    function WriteLogAudit($status)
    {
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if (!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nUploadTransactionBatch Sample Code is Running..." . PHP_EOL;
    UploadTransactionBatch();
}
?>