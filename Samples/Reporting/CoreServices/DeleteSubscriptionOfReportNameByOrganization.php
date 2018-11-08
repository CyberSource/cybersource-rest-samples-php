<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function DeleteSubscriptionOfReportNameByOrganization()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportSubscriptionsApi($apiclient);
	
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->deleteSubscription("testrest_subcription_v123");
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "DeleteSubscriptionOfReportNameByOrganization Samplecode is Running.. \n";
	DeleteSubscriptionOfReportNameByOrganization();

}
?>	
