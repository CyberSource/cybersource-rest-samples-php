<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ReplaySpecificListOfTransactions($webhookId)
{
    $byTransactionTraceIdentifiers = array();
    $byTransactionTraceIdentifiers[0] = "1f1d0bf4-9299-418d-99d8-faa3313829f1";
    $byTransactionTraceIdentifiers[1] = "d19fb205-20e5-43a2-867e-bd0f574b771e";
    $byTransactionTraceIdentifiers[2] = "2f2461a3-457c-40e9-867f-aced89662bbb";
    $byTransactionTraceIdentifiers[3] = "e23ddc19-93d5-4f1f-8482-d7cafbb3ed9b";
    $byTransactionTraceIdentifiers[4] = "eb9fc4a9-b31f-48d5-81a9-b1d773fd76d8";
    $requestObjArr = [
            "byTransactionTraceIdentifiers" => $byTransactionTraceIdentifiers
    ];
    $requestObj = new CyberSource\Model\ReplayWebhooks($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ManageWebhooksApi($api_client);

    try {
        $apiResponse = $api_instance->replayPreviousWebhook($webhookId, $requestObj);
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
    echo "\nReplaySpecificListOfTransactions Sample Code is Running..." . PHP_EOL;
    ReplaySpecificListOfTransactions($webhookId);
}
?>