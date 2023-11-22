<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateWebhookSymmetricKey($vCcorrelationId, $vCsenderOrganizationId, $vCpermissions)
{
    $keyInformationArr = [
            "provider" => "nrtd",
            "tenant" => "merchantName",
            "keyType" => "sharedSecret",
            "organizationId" => "merchantName"
    ];
    $keyInformation = new CyberSource\Model\Kmsegressv2keyssymKeyInformation($keyInformationArr);

    $requestObjArr = [
            "clientRequestAction" => "CREATE",
            "keyInformation" => $keyInformation
    ];
    $requestObj = new CyberSource\Model\SaveSymEgressKey($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CreateNewWebhooksApi($api_client);

    try {
        $apiResponse = $api_instance->saveSymEgressKey($vC-senderOrganizationId, $vC-permissions, $requestObj, $vC-correlationId);
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
    echo "\nCreateWebhookSymmetricKey Sample Code is Running..." . PHP_EOL;
    CreateWebhookSymmetricKey($vC-correlationId, $vC-senderOrganizationId, $vC-permissions);
}
?>