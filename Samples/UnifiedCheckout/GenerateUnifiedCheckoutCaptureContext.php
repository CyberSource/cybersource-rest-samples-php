<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateUnifiedCheckoutCaptureContext()
{
    $targetOrigins = array();
    $targetOrigins[0] = "https://the-up-demo.appspot.com";
    $allowedCardNetworks = array();
    $allowedCardNetworks[0] = "VISA";
    $allowedCardNetworks[1] = "MASTERCARD";
    $allowedCardNetworks[2] = "AMEX";
    $allowedPaymentTypes = array();
    $allowedPaymentTypes[0] = "PANENTRY";
    $allowedPaymentTypes[1] = "SRC";
    $orderInformationAmountDetailsArr = [
            "totalAmount" => "21.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Upv1capturecontextsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Upv1capturecontextsOrderInformation($orderInformationArr);

    $shipToCountries = array();
    $shipToCountries[0] = "US";
    $shipToCountries[1] = "GB";
    $captureMandateArr = [
        "billingType" => "FULL",
        "requestEmail" => true,
        "requestPhone" => true,
        "requestShipping" => true,
        "shipToCountries" => $shipToCountries,
        "showAcceptedNetworkIcons" => true
    ];
    $captureMandate = new CyberSource\Model\Upv1capturecontextsCaptureMandate($captureMandateArr);

    $requestObjArr = [
            "targetOrigins" => $targetOrigins,
            "clientVersion" => "0.11",
            "allowedCardNetworks" => $allowedCardNetworks,
            "allowedPaymentTypes" => $allowedPaymentTypes,
            "country" => "US",
            "locale" => "en_US",
            "captureMandate" => $captureMandate,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\GenerateUnifiedCheckoutCaptureContextRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $apiClient = new CyberSource\ApiClient($config, $merchantConfig);
    $apiInstance = new CyberSource\Api\UnifiedCheckoutCaptureContextApi($apiClient);

    try {
        $apiResponse = $apiInstance->generateUnifiedCheckoutCaptureContext($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    }
}

if (!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nGenerateUnifiedCheckoutCaptureContext Sample Code is Running..." . PHP_EOL;
    GenerateUnifiedCheckoutCaptureContext();
}