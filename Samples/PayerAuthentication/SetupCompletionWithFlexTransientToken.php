<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithFlexTransientToken()
{
    $clientReferenceInformationArr = [
            "code" => "cybs_test"
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $tokenInformationArr = [
            "transientToken" => "1D5ZX4HMOV20FKEBE3IO240JWYJ0NJ90B4V9XQ6SCK4BDN0W96E65E2A39052056"
    ];
    $tokenInformation = new CyberSource\Model\Riskv1authenticationsetupsTokenInformation($tokenInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "tokenInformation" => $tokenInformation
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
    echo "\nSetupCompletionWithFlexTransientToken Sample Code is Running..." . PHP_EOL;
    SetupCompletionWithFlexTransientToken();
}
?>
