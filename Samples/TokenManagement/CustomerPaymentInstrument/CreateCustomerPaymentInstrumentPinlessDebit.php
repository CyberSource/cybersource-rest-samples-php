<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateCustomerPaymentInstrumentPinlessDebit()
{
    $customerTokenId = 'AB695DA801DD1BB6E05341588E0A3BDC';
    $cardArr = [
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "type" => "001",
            "issueNumber" => "01",
            "startMonth" => "01",
            "startYear" => "2020",
            "useAs" => "pinless debit"
    ];
    $card = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentCard($cardArr);

    $billToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "company" => "CyberSource",
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $billTo = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBillTo($billToArr);

    $instrumentIdentifierArr = [
            "id" => "7010000000016241111"
    ];
    $instrumentIdentifier = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentInstrumentIdentifier($instrumentIdentifierArr);

    $requestObjArr = [
            "card" => $card,
            "billTo" => $billTo,
            "instrumentIdentifier" => $instrumentIdentifier
    ];
    $requestObj = new CyberSource\Model\PostCustomerPaymentInstrumentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CustomerPaymentInstrumentApi($api_client);

    try {
        $apiResponse = $api_instance->postCustomerPaymentInstrument($customerTokenId, $requestObj, null);
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
    CreateCustomerPaymentInstrumentPinlessDebit();
}
?>
