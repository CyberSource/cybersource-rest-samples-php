<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function CreateReportSubscriptionForReportNameByOrganization()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportSubscriptionsApi($apiclient);
	
  	$createReportRequestArr = [
		'reportDefinitionName' => 'TransactionRequestClass',
        'reportFields' => ["Request.RequestID",
                    "Request.TransactionDate",
                    "Request.MerchantID"],
        'reportMimeType' => 'application/xml',
        'reportFrequency' => 'WEEKLY',
        'reportName' => 'test_v459',
        'timezone' => 'GMT',
        'startTime' => '0900',
        'startDay' => "1"      
	];
	$reportRequest = new CyberSource\Model\RequestBody($createReportRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->createSubscription(null,$reportRequest);
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
