<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/controller/apiController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/PayloadDigest/PayloadDigest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/Util/GlobalParameter.php';

use CyberSource\Authentication\Util\GlobalParameter as GlobalParameter;

class PutMethod
{
    public function putToServerMethod()
    {
        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $requestJsonPath = __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/TRRReport.json';

        $payload     = new CyberSource\Authentication\PayloadDigest\PayloadDigest();
        $payloadData = $payload->getPayloadDigest($requestJsonPath, $merchantConfigObj);

        $requestTarget = "/reporting/v2/reportSubscriptions/TRRReport?organizationId=testrest";

        $api_response = list($response, $statusCode, $httpHeader) = null;
        try {
            $api_instance = new CybSource\ApiController();
            $api_response = $api_instance->apiController(GlobalParameter::PUT, $payloadData, $requestTarget, $merchantConfigObj);

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

$obj = new PutMethod();
$obj->putToServerMethod();

?>