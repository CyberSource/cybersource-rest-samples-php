<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/controller/apiController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/Util/GlobalParameter.php';

use CyberSource\Authentication\Util\GlobalParameter as GlobalParameter;

class DeleteMethod
{    
	public function deleteFromServerMethod()
    {        
        $paymentID = "5293014742106817204104";
		
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $requestTarget = "/reporting/v2/reportSubscriptions/TRRReport?organizationId=testrest";
		
        $api_response  = list($response, $statusCode, $httpHeader) = null;
        try {
            $api_instance = new CybSource\ApiController();
            $api_response = $api_instance->apiController(GlobalParameter::DELETE, "", $requestTarget, $merchantConfigObj);
            
			if (is_array($api_response)) {
                print_r($api_response);
            }
            
        }
        catch (Exception $e) {
            print_r($e->getresponseBody());
        }
    }
}

$obj = new DeleteMethod();
$obj->deleteFromServerMethod();

?>