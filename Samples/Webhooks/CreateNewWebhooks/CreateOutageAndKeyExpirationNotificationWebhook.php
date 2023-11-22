<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateOutageAndKeyExpirationNotificationWebhook()
{
    $eventTypes = array();
    $eventTypes[0] = "cns.outage.notify.freeform";
    $eventTypes[1] = "cns.report.keyExpiration.detail";
    $retryPolicyArr = [
            "algorithm" => "ARITHMETIC",
            "firstRetry" => 1,
            "interval" => 1,
            "numberOfRetries" => 3,
            "deactivateFlag" => "false",
            "repeatSequenceCount" => 0,
            "repeatSequenceWaitTime" => 0
    ];
    $retryPolicy = new CyberSource\Model\Notificationsubscriptionsv1webhooksRetryPolicy($retryPolicyArr);

    $securityPolicyArr = [
            "securityType" => "KEY",
            "proxyType" => "external"
    ];
    $securityPolicy = new CyberSource\Model\Notificationsubscriptionsv1webhooksSecurityPolicy1($securityPolicyArr);

    $requestObjArr = [
            "name" => "My Custom Webhook",
            "description" => "Sample Webhook from Developer Center",
            "organizationId" => "organizationId",
            "productId" => "cns",
            "eventTypes" => $eventTypes,
            "webhookUrl" => "https://MyWebhookServer.com:8443/simulateClient",
            "healthCheckUrl" => "https://MyWebhookServer.com:8443/simulateClientHealthCheck",
            "notificationScope" => "SELF",
            "retryPolicy" => $retryPolicy,
            "securityPolicy" => $securityPolicy
    ];
    $requestObj = new CyberSource\Model\CreateWebhook($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CreateNewWebhooksApi($api_client);

    try {
        $apiResponse = $api_instance->createWebhook($requestObj);
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
    echo "\nCreateOutageAndKeyExpirationNotificationWebhook Sample Code is Running..." . PHP_EOL;
    CreateOutageAndKeyExpirationNotificationWebhook();
}
?>