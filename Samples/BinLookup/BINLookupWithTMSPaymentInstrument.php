<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function BINLookupWithTMSPaymentInstrument()
{
    $paymentInformationPaymentInstrumentArr = [
            "id" => "E5427539180789D0E053A2598D0AF053"
    ];
    $paymentInformationPaymentInstrument = new CyberSource\Model\Ptsv2paymentsPaymentInformationPaymentInstrument($paymentInformationPaymentInstrumentArr);

    $paymentInformationArr = [
            "paymentInstrument" => $paymentInformationPaymentInstrument
    ];
    $paymentInformation = new CyberSource\Model\Binv1binlookupPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSource\Model\CreateBinLookupRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\BinLookupApi($api_client);

    try {
        $apiResponse = $api_instance->getAccountInfo($requestObj);
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nBINLookupWithTMSPaymentInstrument Sample Code is Running..." . PHP_EOL;
    BINLookupWithTMSPaymentInstrument();
}
?>