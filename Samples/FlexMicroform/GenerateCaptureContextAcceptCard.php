<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateCaptureContextAcceptCard()
{
    $targetOrigins = array();
    $targetOrigins[0] = "https://www.test.com";
    $allowedCardNetworks = array();
    $allowedCardNetworks[0] = "VISA";
    $allowedCardNetworks[1] = "MASTERCARD";
    $allowedCardNetworks[2] = "AMEX";
    $allowedCardNetworks[3] = "CARNET";
    $allowedCardNetworks[4] = "CARTESBANCAIRES";
    $allowedCardNetworks[5] = "CUP";
    $allowedCardNetworks[6] = "DINERSCLUB";
    $allowedCardNetworks[7] = "DISCOVER";
    $allowedCardNetworks[8] = "EFTPOS";
    $allowedCardNetworks[9] = "ELO";
    $allowedCardNetworks[10] = "JCB";
    $allowedCardNetworks[11] = "JCREW";
    $allowedCardNetworks[12] = "MADA";
    $allowedCardNetworks[13] = "MAESTRO";
    $allowedCardNetworks[14] = "MEEZA";
    $allowedPaymentTypes = array();
    $allowedPaymentTypes[0] = "CARD";
    $requestObjArr = [
            "clientVersion" => "v2",
            "targetOrigins" => $targetOrigins,
            "allowedCardNetworks" => $allowedCardNetworks,
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
        $parsedCaptureContext = CyberSource\Utilities\CaptureContext\CaptureContextParser::parseCaptureContextResponse($apiResponse[0], $merchantConfig);
        echo PHP_EOL . "Parsed and Verified JWT Response:" . PHP_EOL;
        print_r($parsedCaptureContext);
        echo PHP_EOL;

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    }
}

if (!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\GenerateCaptureContextAcceptCard Sample Code is Running..." . PHP_EOL;
    GenerateCaptureContextAcceptCard();
}
?>
