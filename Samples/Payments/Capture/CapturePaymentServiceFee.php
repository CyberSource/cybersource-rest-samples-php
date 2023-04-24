<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/ServiceFeesWithCreditCardTransaction.php';

function CapturePaymentServiceFee()
{
    $id = ServiceFeesWithCreditCardTransaction('false')[0]['id'];

    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "2325.00",
            "currency" => "USD",
            "serviceFeeAmount" => "30.0"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformation($orderInformationArr);

    $merchantInformationServiceFeeDescriptorArr = [
            "name" => "Vacations Service Fee",
            "contact" => "8009999999",
            "state" => "CA"
    ];
    $merchantInformationServiceFeeDescriptor = new CyberSource\Model\Ptsv2paymentsMerchantInformationServiceFeeDescriptor($merchantInformationServiceFeeDescriptorArr);

    $merchantInformationArr = [
            "serviceFeeDescriptor" => $merchantInformationServiceFeeDescriptor
    ];
    $merchantInformation = new CyberSource\Model\Ptsv2paymentsidcapturesMerchantInformation($merchantInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation
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
    echo "\nCapturePaymentServiceFee Sample Code is Running..." . PHP_EOL;
    CapturePaymentServiceFee();
}
?>
