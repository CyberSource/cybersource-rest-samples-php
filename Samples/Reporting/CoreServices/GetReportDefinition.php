<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function GetReportDefinition()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportDefinitionsApi($apiclient);
	$reportDefinitionName = "AcquirerExceptionDetailClass";
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getResourceInfoByReportDefinition($reportDefinitionName, $organizationId = null);
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    	print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GetReportDefinition Samplecode is Running.. \n";
	GetReportDefinition();

}
?>	
