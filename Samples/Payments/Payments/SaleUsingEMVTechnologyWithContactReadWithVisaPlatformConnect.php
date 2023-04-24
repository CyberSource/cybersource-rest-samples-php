<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function SaleUsingEMVTechnologyWithContactReadWithVisaPlatformConnect()
{
    $clientReferenceInformationArr = [
            "code" => "123456"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationAuthorizationOptionsArr = [
            "partialAuthIndicator" => true,
            "ignoreAvsResult" => false,
            "ignoreCvResult" => false
    ];
    $processingInformationAuthorizationOptions = new CyberSource\Model\Ptsv2paymentsProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

    $processingInformationArr = [
            "capture" => false,
            "commerceIndicator" => "retail",
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $pointOfSaleInformationEmvArr = [
            "tags" => "9F3303204000950500000000009F3704518823719F100706011103A000009F26081E1756ED0E2134E29F36020015820200009C01009F1A0208409A030006219F02060000000020005F2A0208409F0306000000000000",
            "cardSequenceNumber" => "1",
            "fallback" => false
    ];
    $pointOfSaleInformationEmv = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformationEmv($pointOfSaleInformationEmvArr);

    $pointOfSaleInformationArr = [
            "catLevel" => 1,
            "entryMode" => "contact",
            "terminalCapability" => 4,
            "emv" => $pointOfSaleInformationEmv,
            "trackData" => "%B4111111111111111^TEST/CYBS         ^2012121019761100      00868000000?;"
    ];
    $pointOfSaleInformation = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation,
            "pointOfSaleInformation" => $pointOfSaleInformation
    ];
    $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentsApi($api_client);

    try {
        $apiResponse = $api_instance->createPayment($requestObj);
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
    echo "\nSaleUsingEMVTechnologyWithContactReadWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
    SaleUsingEMVTechnologyWithContactReadWithVisaPlatformConnect();
}
?>
