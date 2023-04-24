<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/PayloadDigest/PayloadDigest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/Core/Authentication.php';

class PutGeneratorHeader
{
    public function putMethod($paymentId)
    {
        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $requestJsonPath   = __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/authRequest.json';

        $payload           = new CyberSource\Authentication\PayloadDigest\PayloadDigest();
        $payloadData       = $payload->getPayloadDigest($requestJsonPath, $merchantConfigObj);

        $requestTarget     = "/pts/v2/payments" . $paymentId;

        $api_response      = list($response, $statusCode, $httpHeader) = null;
        try {
            $auth         = new CyberSource\Authentication\Core\Authentication();
            $authResponse = $auth->generateToken($requestTarget, $payloadData, "GET", $merchantConfigObj);

            if ($merchantConfigObj->getLogConfiguration()->getEnableLogging()) {
                error_log(    "[DEBUG] HTTP Response body  ~BEGIN~" . PHP_EOL . "Request Target GET: " . $requestTarget . PHP_EOL . "~END~" . PHP_EOL,
                            3,
                            $merchantConfigObj->getLogConfiguration()->getDebugLogFile()
                        );
            }

            print_r($authResponse);
            WriteLogAudit(200);
        }
        catch (Exception $e) {
            print_r($e->getresponseBody()->details[0]);
            WriteLogAudit(400);
        }
    }
}

$paymentId = "5408386919326811103004";

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status\n");
    }
}

$obj        = new PutGeneratorHeader();
$obj->putMethod($paymentId);

?>