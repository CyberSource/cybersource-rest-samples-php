<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function CreateSearchRequest()
{
    $requestObjArr = [
            "save" => false,
            "name" => "MRN",
            "timezone" => "America/Chicago",
            "query" => "clientReferenceInformation.code:TC50171_3 AND submitTimeUtc:[NOW/DAY-7DAYS TO NOW/DAY+1DAY}",
            "offset" => 0,
            "limit" => 100,
            "sort" => "id:asc,submitTimeUtc:asc"
    ];
    $requestObj = new CyberSource\Model\CreateSearchRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SearchTransactionsApi($api_client);

    try {
        $apiResponse = $api_instance->createSearch($requestObj);
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
    echo "\nCreateSearchRequest Sample Code is Running..." . PHP_EOL;
    CreateSearchRequest();
}
?>
