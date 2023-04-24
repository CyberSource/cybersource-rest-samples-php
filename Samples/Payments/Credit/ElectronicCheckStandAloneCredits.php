<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ElectronicCheckStandAloneCredits()
{
    $clientReferenceInformationArr = [
            "code" => "TC46125-1"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationBankAccountArr = [
            "type" => "C",
            "number" => "4100",
            "checkNumber" => "123456"
    ];
    $paymentInformationBankAccount = new CyberSource\Model\Ptsv2paymentsPaymentInformationBankAccount($paymentInformationBankAccountArr);

    $paymentInformationBankArr = [
            "account" => $paymentInformationBankAccount,
            "routingNumber" => "071923284"
    ];
    $paymentInformationBank = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformationBank($paymentInformationBankArr);

    $paymentInformationPaymentTypeArr = [
            "name" => "CHECK"
    ];
    $paymentInformationPaymentType = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

    $paymentInformationArr = [
            "bank" => $paymentInformationBank,
            "paymentType" => $paymentInformationPaymentType
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

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
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\CreateCreditRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CreditApi($api_client);

    try {
        $apiResponse = $api_instance->createCredit($requestObj);
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
    echo "\nElectronicCheckStandAloneCredits Sample Code is Running..." . PHP_EOL;
    ElectronicCheckStandAloneCredits();
}
?>
