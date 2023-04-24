<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/controller/apiController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/PayloadDigest/PayloadDigest.php';

class PostMethod
{
    public function postToServerMethod()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $requestJsonPath = __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/authRequest.json';

        $payload     = new CyberSource\Authentication\PayloadDigest\PayloadDigest();
        $payloadData = $payload->getPayloadDigest($requestJsonPath, $merchantConfigObj);

        $requestTarget = "/pts/v2/payments";

        $api_response  = list($response, $statusCode, $httpHeader) = null;
        try {
            $api_instance = new CybSource\ApiController();
            $api_response = $api_instance->apiController("POST", $payloadData, $requestTarget, $merchantConfigObj);

            if (is_array($api_response)) {
                print_r($api_response);
                WriteLogAudit($api_response[1]);
            }
        }
        catch (Exception $e) {
            WriteLogAudit((explode(" ", $e->getresponseHeaders()[0]))[1]);
            print_r($e->getresponseBody());
        }
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status\n");
    }
}

$obj = new PostMethod();
$obj->postToServerMethod();

?>