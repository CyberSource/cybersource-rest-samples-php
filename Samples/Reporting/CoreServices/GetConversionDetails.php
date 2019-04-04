<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetConversionDetails()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$startTime="2019-03-21T00:00:00.0Z";
	$endTime="2019-03-21T23:00:00.0Z";
	$api_instance = new CyberSource\Api\ConversionDetailsApi($apiclient);
	$orgId = "testrest";
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getConversionDetail($startTime,$endTime,$orgId);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Get Conversion Details Samplecode is Running.. \n";
	GetConversionDetails();

}
?>	
