<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateAsymmetricKey($vCcorrelationId, $vCsenderOrganizationId, $vCpermissions)
{
    $keyInformationArr = [
            "provider" => "merchantName",
            "tenant" => "nrtd",
            "keyType" => "publickey",
            "organizationId" => "merchantName",
            "pub" => "MIIDbDCCAlQCCQD4lcSlmasmCTANBgkqhkiG9w0BAQsFADB4MQswCQYDVQQGEwJVUzELMAkGA1UECAwCVFgxDzANBgNVBAcMBkF1c3RpbjENMAsGA1UECgwEVGVzdDEOMAwGA1UECwwFVGVzdDIxDjAMBgNVBAMMBVRlc3QzMRwwGgYJKoZIhvcNAQkBFg10ZXN0QHRlc3QuY29tMB4XDTIxMDgwOTE0MTcxNFoXDTIyMDgwOTE0MTcxNFoweDELMAkGA1UEBhMCVVMxCzAJBgNVBAgMAlRYMQ8wDQYDVQQHDAZBdXN0aW4xDTALBgNVBAoMBFRlc3QxDjAMBgNVBAsMBVRlc3QyMQ4wDAYDVQQDDAVUZXN0MzEcMBoGCSqGSIb3DQEJARYNdGVzdEB0ZXN0LmNvbTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMcHQWZRETqim3XzUQlAiujFEvsHIi1uJZKj+1lvPH36Ucqo3ORcoh/MM/zxVdahjhSyyp7MHuKBWnzft6bFeDEul6qKWGPAAzaxG/2xZSV3FggA9SyAZEDUpJ6mblwqm/EY4KmZi1FrNBUHfW2wwaqDexHPRDesRG6aI7Wuu4GdQUUqoTa2+Nv7kVgEDmGcfIjoWkGKHe+Yan95EITrq4jEFCE5Tg/vERnMvHfK2SovENZ13/pnwFYbeh1kfJSBzWW7yq8AyQAgAE9iqJXbJ/MAasir2vjUQ2+Hcl7WbkpoVjLqDt3rzV1T0Bsd4T9SC3wij9qjJSxa6vAgV4xn6bECAwEAATANBgkqhkiG9w0BAQsFAAOCAQEADuMrtYW1Sf0IsZ4ZD9ipjUrFuTxqh+0M5Jk8h0QqAXEHA/MawedlU3JmE3NB/UR82/XUwdmtObGnFANuUQQ+8WMFpcNo/Sq2kg7juneHZroRh72o73UUMtHWHzo8s0fXElNal8h3SaAAnjMblCiN+gM1RvWMvhGrMTXp2XAcdIezXf8/FOZLlzOF9QylbSk1U4ayWBag6MydkxgHjkPKdShZROEm0oz/O7J/gNp/r7J8F42Rw9MmJh9qH3SFre13nQa8V7Kg+dJHZ/jpGtSlDHAxO0SSTrPXkwB+iBJ6hSkiL/J2Ep+lYHqVe3p5NXMOlTtJdbU4enHeLkD6PazKTw",
            "expiryDuration" => "365"
    ];
    $keyInformation = new CyberSource\Model\Kmsegressv2keysasymKeyInformation($keyInformationArr);

    $requestObjArr = [
            "clientRequestAction" => "STORE",
            "keyInformation" => $keyInformation
    ];
    $requestObj = new CyberSource\Model\SaveAsymEgressKey($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\ManageWebhooksApi($api_client);

    try {
        $apiResponse = $api_instance->saveAsymEgressKey($vC-senderOrganizationId, $vC-permissions, $requestObj, $vC-correlationId);
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
    echo "\nCreateAsymmetricKey Sample Code is Running..." . PHP_EOL;
    CreateAsymmetricKey($vC-correlationId, $vC-senderOrganizationId, $vC-permissions);
}
?>