<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function UpdatePaymentInstrument()
{
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
    $paymentInstrumentTokenId = '888454C31FB6150CE05340588D0AA9BE';
    
    $cardArr = [
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "type" => "visa"
    ];
    $card = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentCard($cardArr);

    $billToArr = [
            "firstName" => "Jack",
            "lastName" => "Smith",
            "company" => "CyberSource",
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "updatedemail@cybs.com",
            "phoneNumber" => "4158888674"
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
    $requestObj = new CyberSource\Model\PatchPaymentInstrumentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentInstrumentApi($api_client);

    try {
        $apiResponse = $api_instance->patchPaymentInstrument($paymentInstrumentTokenId, $requestObj, $profileid, null);
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
    UpdatePaymentInstrument();
}
?>
