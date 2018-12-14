<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function RetrieveAvailableReports()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportsApi($apiclient);
	$startTime="2018-10-01T00:00:00.0Z";
	$endTime="2018-10-30T23:59:59.0Z";
	$timeQueryType="executedTime";
  
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->searchReports($startTime, $endTime, $timeQueryType);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
    	print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "RetrieveAvailableReports Samplecode is Running.. \n";
	RetrieveAvailableReports();

}
?>	
