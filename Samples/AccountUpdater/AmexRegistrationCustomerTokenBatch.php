<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function AmexRegistrationCustomerTokenBatch()
{
    $includedTokens = array();
    $includedTokens_0 = [
            "id" => "C06977C0EDC0E985E053AF598E0A3326"
    ];
    $includedTokens[0] = new CyberSource\Model\Accountupdaterv1batchesIncludedTokens($includedTokens_0);

    $includedTokens_1 = [
            "id" => "C069A534044F6140E053AF598E0AD492"
    ];
    $includedTokens[1] = new CyberSource\Model\Accountupdaterv1batchesIncludedTokens($includedTokens_1);

    $includedArr = [
            "tokens" => $includedTokens
    ];
    $included = new CyberSource\Model\Accountupdaterv1batchesIncluded($includedArr);

    $requestObjArr = [
            "type" => "amexRegistration",
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
    echo "\nAmexRegistrationCustomerTokenBatch Sample Code is Running..." . PHP_EOL;
    AmexRegistrationCustomerTokenBatch();
}
?>
