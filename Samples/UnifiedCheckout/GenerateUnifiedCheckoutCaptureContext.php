<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateUnifiedCheckoutCaptureContext()
{
    $targetOrigins = array();
    $targetOrigins[0] = "https://yourCheckoutPage.com";
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
    $allowedPaymentTypes[0] = "APPLEPAY";
    $allowedPaymentTypes[1] = "CHECK";
    $allowedPaymentTypes[2] = "CLICKTOPAY";
    $allowedPaymentTypes[3] = "GOOGLEPAY";
    $allowedPaymentTypes[4] = "PANENTRY";
    $allowedPaymentTypes[5] = "PAZE";
    $captureMandateShipToCountries = array();
    $captureMandateShipToCountries[0] = "US";
    $captureMandateShipToCountries[1] = "GB";
    $captureMandateArr = [
            "billingType" => "FULL",
            "requestEmail" => true,
            "requestPhone" => true,
            "requestShipping" => true,
            "shipToCountries" => $captureMandateShipToCountries,
            "showAcceptedNetworkIcons" => true
    ];
    $captureMandate = new CyberSource\Model\Upv1capturecontextsCaptureMandate($captureMandateArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "21.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Upv1capturecontextsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Upv1capturecontextsOrderInformation($orderInformationArr);
    $completeMandate = new CyberSource\Model\Upv1capturecontextsCompleteMandate([
        "type" => "CAPTURE",
        "decisionManager" => false
    ]); 
    $requestObjArr = [
            "clientVersion" => "0.23",
            "targetOrigins" => $targetOrigins,
            "allowedCardNetworks" => $allowedCardNetworks,
            "allowedPaymentTypes" => $allowedPaymentTypes,
            "country" => "US",
            "locale" => "en_US",
            "captureMandate" => $captureMandate,
            "orderInformation" => $orderInformation,
            "completeMandate" => $completeMandate
    ];
    $requestObj = new CyberSource\Model\GenerateUnifiedCheckoutCaptureContextRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $apiClient = new CyberSource\ApiClient($config, $merchantConfig);
    $apiInstance = new CyberSource\Api\UnifiedCheckoutCaptureContextApi($apiClient);

    try {
        $apiResponse = $apiInstance->generateUnifiedCheckoutCaptureContext($requestObj);
        $parsedCaptureContext = CyberSource\Utilities\CaptureContext\CaptureContextParser::parseCaptureContextResponse($apiResponse[0], $merchantConfig, true);
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
    echo "\nGenerateUnifiedCheckoutCaptureContext Sample Code is Running..." . PHP_EOL;
    GenerateUnifiedCheckoutCaptureContext();
}
