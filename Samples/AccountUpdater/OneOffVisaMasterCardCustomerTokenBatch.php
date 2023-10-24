<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function OneOffVisaMasterCardCustomerTokenBatch()
{
    $includedTokens = array();
    $includedTokens_0 = [
            "id" => "C064DE56200B0DB0E053AF598E0A52AA"
    ];
    $includedTokens[0] = new CyberSource\Model\Accountupdaterv1batchesIncludedTokens($includedTokens_0);

    $includedTokens_1 = [
            "id" => "C064DE56213D0DB0E053AF598E0A52AA"
    ];
    $includedTokens[1] = new CyberSource\Model\Accountupdaterv1batchesIncludedTokens($includedTokens_1);

    $includedArr = [
            "tokens" => $includedTokens
    ];
    $included = new CyberSource\Model\Accountupdaterv1batchesIncluded($includedArr);

    $requestObjArr = [
            "type" => "oneOff",
            "included" => $included,
            "merchantReference" => "TC50171_3",
            "notificationEmail" => "test@cybs.com"
    ];
    $requestObj = new CyberSource\Model\Body($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\BatchesApi($api_client);

    try {
        $apiResponse = $api_instance->postBatch($requestObj);
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
    echo "\nOneOffVisaMasterCardCustomerTokenBatch Sample Code is Running..." . PHP_EOL;
    OneOffVisaMasterCardCustomerTokenBatch();
}
?>
