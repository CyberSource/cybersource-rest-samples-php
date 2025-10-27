<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/BankAccountValidationConfiguration.php';

function BankAccountValidation()
{
    if (isset($flag) && $flag == "true") {
        $capture = true;
    } else {
        $capture = false;
    }
    
    $clientReferenceInformationArr = [
            "code" => "TC50171_100"
    ];
    $clientReferenceInformation = new CyberSource\Model\Bavsv1accountvalidationsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationArr = [
            "validationLevel" => 1
    ];
    $processingInformation = new CyberSource\Model\Bavsv1accountvalidationsProcessingInformation($processingInformationArr);

    $paymentInformationBankAccountArr = [
            "number" => "99970"
    ];
    $paymentInformationBankAccount = new CyberSource\Model\Bavsv1accountvalidationsPaymentInformationBankAccount($paymentInformationBankAccountArr);

    $paymentInformationBankArr = [
            "routingNumber" => "041210163",
            "account" => $paymentInformationBankAccount
    ];
    $paymentInformationBank = new CyberSource\Model\Bavsv1accountvalidationsPaymentInformationBank($paymentInformationBankArr);

    $paymentInformationArr = [
            "bank" => $paymentInformationBank
    ];
    $paymentInformation = new CyberSource\Model\Bavsv1accountvalidationsPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSource\Model\AccountValidationsRequest($requestObjArr);


    $commonElement = new CyberSource\BankAccountValidationConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->bankAccountValidationConfiguration();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\BankAccountValidationApi($api_client);

    try {
        $apiResponse = $api_instance->bankAccountValidationRequest($requestObj);
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
    echo "\nBankAccountValidation Sample Code is Running..." . PHP_EOL;
    BankAccountValidation();
}
?>