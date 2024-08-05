<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function BINLookupWithTMSJtiTransientToken()
{
    $tokenInformationArr = [
            "jti" => "1E0WC1GO87JG1BDP0CQ8SCR1TTK86U9N98H3WH8IFM9MVEWTIYFI62F4941E7A92"
    ];
    $tokenInformation = new CyberSource\Model\Binv1binlookupTokenInformation($tokenInformationArr);

    $requestObjArr = [
            "tokenInformation" => $tokenInformation
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
    echo "\nBINLookupWithTMSJtiTransientToken Sample Code is Running..." . PHP_EOL;
    BINLookupWithTMSJtiTransientToken();
}
?>