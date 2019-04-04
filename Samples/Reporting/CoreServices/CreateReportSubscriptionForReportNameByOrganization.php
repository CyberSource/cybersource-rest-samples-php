<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateReportSubscriptionForReportNameByOrganization()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportSubscriptionsApi($apiclient);
	
  	$createReportRequestArr = [
		'reportDefinitionName' => 'TransactionRequestClass',
        'reportFields' => ["Request.RequestID",
                    "Request.TransactionDate",
                    "Request.MerchantID"],
        'reportMimeType' => 'application/xml',
        'reportFrequency' => 'MONTHLY',
        'reportName' => 'testrests_subcription_v1',
        'timezone' => 'GMT',
        'startTime' => '1300',
        'startDay' => "3"      
	];
	$reportRequest = new CyberSource\Model\RequestBody1($createReportRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->createSubscription($reportRequest,null);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
    	print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "CreateReportSubscriptionForReportNameByOrganization Samplecode is Running.. \n";
	CreateReportSubscriptionForReportNameByOrganization();

}
?>	
