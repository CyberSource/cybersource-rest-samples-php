<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function DownloadFileWithFileIdentifier()
{
    $organizationId = "testrest";
    $fileId = "Q2hhcmdlYmFja0FuZFJldHJpZXZhbFJlcG9ydC1hYWVkMWEwMS03OGNhLTU1YzgtZTA1My1hMjU4OGUwYWNhZWEuY3N2LTIwMjAtMDctMzA=";

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SecureFileShareApi($api_client);

    try {
        $apiResponse = $api_instance->getFile($fileId, $organizationId);
        print_r(PHP_EOL);
        print_r($apiResponse);

        $download_data = $apiResponse[0];
        $file_path = $commonElement->downloadReport($download_data, "DownloadedFileByFileIdentifier.xml");
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
    echo "\nDownloadFileWithFileIdentifier Sample Code is Running..." . PHP_EOL;
    DownloadFileWithFileIdentifier();
}
?>
