<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function PartialAuthorization()
{
    $clientReferenceInformationArr = [
            "code" => "1234567890"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCardArr = [
            "number" => "4111111111111111",
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "securityCode" => "123"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "7012.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "1 Market St",
            "locality" => "san francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $pointOfSaleInformationEmvArr = [
            "fallback" => false,
            "fallbackCondition" => 1
    ];
    $pointOfSaleInformationEmv = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformationEmv($pointOfSaleInformationEmvArr);

    $pointOfSaleInformationArr = [
            "catLevel" => 6,
            "terminalCapability" => 4,
            "emv" => $pointOfSaleInformationEmv
    ];
    $pointOfSaleInformation = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
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
    echo "\nPartialAuthorization Sample Code is Running..." . PHP_EOL;
    PartialAuthorization();
}
?>
