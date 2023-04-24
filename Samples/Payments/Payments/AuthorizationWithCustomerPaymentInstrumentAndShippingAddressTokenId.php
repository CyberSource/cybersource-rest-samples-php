<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithCustomerPaymentInstrumentAndShippingAddressTokenId()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCustomerArr = [
            "id" => "AB695DA801DD1BB6E05341588E0A3BDC"
    ];
    $paymentInformationCustomer = new CyberSource\Model\Ptsv2paymentsPaymentInformationCustomer($paymentInformationCustomerArr);

    $paymentInformationPaymentInstrumentArr = [
            "id" => "AB6A54B982A6FCB6E05341588E0A3935"
    ];
    $paymentInformationPaymentInstrument = new CyberSource\Model\Ptsv2paymentsPaymentInformationPaymentInstrument($paymentInformationPaymentInstrumentArr);

    $paymentInformationShippingAddressArr = [
            "id" => "AB6A54B97C00FCB6E05341588E0A3935"
    ];
    $paymentInformationShippingAddress = new CyberSource\Model\Ptsv2paymentsPaymentInformationShippingAddress($paymentInformationShippingAddressArr);

    $paymentInformationArr = [
            "customer" => $paymentInformationCustomer,
            "paymentInstrument" => $paymentInformationPaymentInstrument,
            "shippingAddress" => $paymentInformationShippingAddress
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "102.21",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
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
    echo "\nAuthorizationWithCustomerPaymentInstrumentAndShippingAddressTokenId Sample Code is Running..." . PHP_EOL;
    AuthorizationWithCustomerPaymentInstrumentAndShippingAddressTokenId();
}
?>
