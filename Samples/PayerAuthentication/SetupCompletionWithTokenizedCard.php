<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithTokenizedCard()
{
    $clientReferenceInformationArr = [
            "code" => "cybs_test"
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationTokenizedCardArr = [
            "transactionType" => "1",
            "type" => "001",
            "expirationMonth" => "11",
            "expirationYear" => "2025",
            "number" => "4111111111111111"
    ];
    $paymentInformationTokenizedCard = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformationTokenizedCard($paymentInformationTokenizedCardArr);

    $paymentInformationArr = [
            "tokenizedCard" => $paymentInformationTokenizedCard
    ];
    $paymentInformation = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSource\Model\PayerAuthSetupRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->payerAuthSetup($requestObj);
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
    echo "\nSetupCompletionWithTokenizedCard Sample Code is Running..." . PHP_EOL;
    SetupCompletionWithTokenizedCard();
}
?>
