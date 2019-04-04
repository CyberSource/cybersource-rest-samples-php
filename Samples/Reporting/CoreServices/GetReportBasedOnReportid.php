<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetReportBasedOnReportid()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportsApi($apiclient);
	$reportId = "79642c43-2368-0cd5-e053-a2588e0a7b3c";
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getReportByReportId($reportId);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GetReportBasedOnReportid Samplecode is Running.. \n";
	GetReportBasedOnReportid();

}
?>	
