<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetDetailsOnAllCreatedWebhooks()
{
    // QUERY PARAMETERS
    // $organizationId = "testrest";
    // $productId = "testProductId";
    // $eventType = "testEventType";

    // $commonElement = new CyberSource\ExternalConfiguration();
    // $config = $commonElement->ConnectionHost();
    // $merchantConfig = $commonElement->merchantConfigObject();

    // $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    // $api_instance = new CyberSource\Api\ManageWebhooksApi($api_client);

    // try {
    //     $apiResponse = $api_instance->getWebhookSubscriptionsByOrg($organizationId, $productId, $eventType);
    //     print_r(PHP_EOL);
    //     print_r($apiResponse);
    //     WriteLogAudit($apiResponse[1]);

    //     return $apiResponse;
    // } catch (Cybersource\ApiException $e) {
    //     print_r($e->getResponseBody());
    //     print_r($e->getMessage());
    //     $errorCode = $e->getCode();
    //     WriteLogAudit($errorCode);
    // }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nGetDetailsOnAllCreatedWebhooks Sample Code is Running..." . PHP_EOL;
    GetDetailsOnAllCreatedWebhooks();
}
?>