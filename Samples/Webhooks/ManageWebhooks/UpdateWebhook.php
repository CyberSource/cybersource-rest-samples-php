<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function UpdateWebhook($webhookId)
{
    // $eventTypes = array();
    // $eventTypes[0] = "terminalManagement.assignment.update";
    // $eventTypes[1] = "terminalManagement.status.update";
    // $notificationScopeArr = [
    //         "scope" => "SELF"
    // ];
    // $notificationScope = new CyberSource\Model\Notificationsubscriptionsv1webhooksNotificationScope($notificationScopeArr);

    // $requestObjArr = [
    //         "name" => "My Sample Webhook",
    //         "description" => "Update to my sample webhook",
    //         "organizationId" => "<INSERT ORGANIZATION ID HERE>",
    //         "productId" => "terminalManagement",
    //         "eventTypes" => $eventTypes,
    //         "webhookUrl" => "https://MyWebhookServer.com:8443:/simulateClient",
    //         "healthCheckUrl" => "https://MyWebhookServer.com:8443:/simulateClientHealthCheck",
    //         "status" => "INACTIVE",
    //         "notificationScope" => $notificationScope
    // ];
    // $requestObj = new CyberSource\Model\UpdateWebhookRequest($requestObjArr);


    // $commonElement = new CyberSource\ExternalConfiguration();
    // $config = $commonElement->ConnectionHost();
    // $merchantConfig = $commonElement->merchantConfigObject();

    // $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    // $api_instance = new CyberSource\Api\ManageWebhooksApi($api_client);

    // try {
    //     $apiResponse = $api_instance->updateWebhookSubscription($webhookId, $requestObj);
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
    echo "\nUpdateWebhook Sample Code is Running..." . PHP_EOL;
    UpdateWebhook($webhookId);
}
?>