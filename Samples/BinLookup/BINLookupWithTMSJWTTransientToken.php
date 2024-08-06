<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function BINLookupWithTMSJWTTransientToken()
{
    $tokenInformationArr = [
            "transientTokenJwt" => "eyJraWQiOiIwODd0bk1DNU04bXJHR3JHMVJQTkwzZ2VyRUh5VWV1ciIsImFsZyI6IlJTMjU2In0.eyJpc3MiOiJGbGV4LzA4IiwiZXhwIjoxNjYwMTk1ODcwLCJ0eXBlIjoiYXBpLTAuMS4wIiwiaWF0IjoxNjYwMTk0OTcwLCJqdGkiOiIxRTBXQzFHTzg3SkcxQkRQMENROFNDUjFUVEs4NlU5Tjk4SDNXSDhJRk05TVZFV1RJWUZJNjJGNDk0MUU3QTkyIiwiY29udGVudCI6eyJwYXltZW50SW5mb3JtYXRpb24iOnsiY2FyZCI6eyJudW1iZXIiOnsibWFza2VkVmFsdWUiOiJYWFhYWFhYWFhYWFgxMTExIiwiYmluIjoiNDExMTExIn0sInR5cGUiOnsidmFsdWUiOiIwMDEifX19fX0.MkCLbyvufN4prGRvHJcqCu1WceDVlgubZVpShNWQVjpuFQUuqwrKg284sC7ucVKuIsOU0DTN8_OoxDLduvZhS7X_5TnO0QjyA_aFxbRBvU_bEz1l9V99VPADG89T-fox_L6sLUaoTJ8T4PyD7rkPHEA0nmXbqQCVqw4Czc5TqlKCwmL-Fe0NBR2HlOFI1PrSXT-7_wI-JTgXI0dQzb8Ub20erHwOLwu3oni4_ZmS3rGI_gxq2MHi8pO-ZOgA597be4WfVFAx1wnMbareqR72a0QM4DefeoltrpNqXSaASVyb5G0zuqg-BOjWJbawmg2QgcZ_vE3rJ6PDgWROvp9Tbw"
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
    echo "\nBINLookupWithTMSJWTTransientToken Sample Code is Running..." . PHP_EOL;
    BINLookupWithTMSJWTTransientToken();
}
?>