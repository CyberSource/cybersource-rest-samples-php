<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateCaptureContextWithCheckoutAPI()
{
    $targetOrigins = array();
    $targetOrigins[0] = "https://www.test.com";
    $allowedCardNetworks = array();
    $allowedCardNetworks[0] = "VISA";
    $allowedCardNetworks[1] = "MASTERCARD";
    $allowedCardNetworks[2] = "AMEX";
    
    $requestObjArr = [
            "targetOrigins" => $targetOrigins,
            "clientVersion" => "v2.0",
            "allowedCardNetworks" => $allowedCardNetworks
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
    echo "\GenerateCaptureContextWithCheckoutAPI Sample Code is Running..." . PHP_EOL;
    GenerateCaptureContextWithCheckoutAPI();
}
?>