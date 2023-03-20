<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/PayloadDigest/PayloadDigest.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/Util/PropertiesUtil.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/Core/Authentication.php';

class GetGeneratorHeader
{
    public function getMethod()
    {
        $paymentID = "5246387105766473203529";

        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $requestTarget     = "/pts/v2/payments/" . $paymentID;

        if ($merchantConfigObj->getLogConfiguration()->getEnableLogging()) {
                error_log(    "[DEBUG] HTTP Response body  ~BEGIN~" . PHP_EOL . "Request Target GET: " . $requestTarget . PHP_EOL . "~END~" . PHP_EOL,
                            3,
                            $merchantConfigObj->getLogConfiguration()->getDebugLogFile()
                        );
        }

        $api_response = list($response, $statusCode, $httpHeader) = null;
        try {
            $auth         = new CyberSource\Authentication\Core\Authentication();
            $authResponse = $auth->generateToken($requestTarget, "", "GET", $merchantConfigObj);

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

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status\n");
    }
}

$obj = new GetGeneratorHeader();
$obj->getMethod();

?>