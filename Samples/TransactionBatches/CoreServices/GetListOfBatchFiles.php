<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function GetListOfBatchFiles()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\TransactionBatchesApi($apiclient);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$startTime='2018-10-01T00:00:00.00Z';
	$endTime='2018-10-31T23:59:59.59Z';
	try {
		$api_response = $api_instance->ptsV1TransactionBatchesGet($startTime, $endTime);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GetListOfBatchFiles Samplecode is Running.. \n";
	GetListOfBatchFiles();

}
?>	
