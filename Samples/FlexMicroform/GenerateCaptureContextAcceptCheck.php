<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateCaptureContextAcceptCheck()
{
    $targetOrigins = array();
    $targetOrigins[0] = "https://www.test.com";
    $allowedPaymentTypes = array();
    $allowedPaymentTypes[0] = "CHECK";
    $requestObjArr = [
            "clientVersion" => "v2",
            "targetOrigins" => $targetOrigins,
            "allowedPaymentTypes" => $allowedPaymentTypes

    ];
    $requestObj = new CyberSource\Model\GenerateCaptureContextRequest($requestObjArr);



    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $apiClient = new CyberSource\ApiClient($config, $merchantConfig);
    $apiInstance = new CyberSource\Api\MicroformIntegrationApi($apiClient);

    try {
        $apiResponse = $apiInstance->generateCaptureContext($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    }
}

if (!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\GenerateCaptureContextAcceptCheck Sample Code is Running..." . PHP_EOL;
    GenerateCaptureContextAcceptCheck();
}
?>