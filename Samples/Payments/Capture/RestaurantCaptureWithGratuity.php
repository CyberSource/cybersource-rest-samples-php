<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function RestaurantCaptureWithGratuity()
{
    require_once __DIR__. DIRECTORY_SEPARATOR .'../Payments/RestaurantAuthorization.php';
    $id = RestaurantAuthorization()[0]['id'];

    $clientReferenceInformationPartnerArr = [
            "thirdPartyCertificationNumber" => "123456789012"
    ];
    $clientReferenceInformationPartner = new CyberSource\Model\Ptsv2paymentsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "1234567890",
            "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationArr = [
            "industryDataType" => "restaurant"
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsidcapturesProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100",
            "currency" => "USD",
            "gratuityAmount" => "11.50"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\CapturePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CaptureApi($api_client);

    try {
        $apiResponse = $api_instance->capturePayment($requestObj, $id);
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
    echo "\nRestaurantCaptureWithGratuity Sample Code is Running..." . PHP_EOL;
    RestaurantCaptureWithGratuity();
}
?>
