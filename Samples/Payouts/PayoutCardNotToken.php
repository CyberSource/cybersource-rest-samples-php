<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function PayoutCardNotToken()
{
    $clientReferenceInformationArr = [
            "code" => "33557799"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2payoutsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2payoutsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2payoutsOrderInformation($orderInformationArr);

    $merchantInformationMerchantDescriptorArr = [
            "name" => "Sending Company Name",
            "locality" => "FC",
            "country" => "US",
            "administrativeArea" => "CA",
            "postalCode" => "94440"
    ];
    $merchantInformationMerchantDescriptor = new CyberSource\Model\Ptsv2payoutsMerchantInformationMerchantDescriptor($merchantInformationMerchantDescriptorArr);

    $merchantInformationArr = [
            "merchantDescriptor" => $merchantInformationMerchantDescriptor
    ];
    $merchantInformation = new CyberSource\Model\Ptsv2payoutsMerchantInformation($merchantInformationArr);

    $recipientInformationArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "Paseo Padre Boulevard",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "country" => "US",
            "postalCode" => "94400",
            "phoneNumber" => "6504320556"
    ];
    $recipientInformation = new CyberSource\Model\Ptsv2payoutsRecipientInformation($recipientInformationArr);

    $senderInformationAccountArr = [
            "fundsSource" => "05"
    ];
    $senderInformationAccount = new CyberSource\Model\Ptsv2payoutsSenderInformationAccount($senderInformationAccountArr);

    $senderInformationArr = [
            "referenceNumber" => "1234567890",
            "account" => $senderInformationAccount,
            "name" => "Company Name",
            "address1" => "900 Metro Center Blvd.900",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "countryCode" => "US"
    ];
    $senderInformation = new CyberSource\Model\Ptsv2payoutsSenderInformation($senderInformationArr);

    $processingInformationArr = [
            "businessApplicationId" => "FD",
            "networkRoutingOrder" => "V8",
            "commerceIndicator" => "internet"
    ];
    $processingInformation = new CyberSource\Model\Ptsv2payoutsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "type" => "001",
            "number" => "4111111111111111",
            "expirationMonth" => "12",
            "expirationYear" => "2025"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2payoutsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2payoutsPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation,
            "recipientInformation" => $recipientInformation,
            "senderInformation" => $senderInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSource\Model\OctCreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PayoutsApi($api_client);

    try {
        $apiResponse = $api_instance->octCreatePayment($requestObj);
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
    echo "\nPayoutCardNotToken Sample Code is Running..." . PHP_EOL;
    PayoutCardNotToken();
}
?>
