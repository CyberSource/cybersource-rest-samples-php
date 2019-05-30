<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetListOfBatchFiles()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\TransactionBatchesApi($apiclient);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$startTime='2018-10-01T00:00:00.00Z';
	$endTime='2018-10-31T23:59:59.59Z';
	try {
		$api_response = $api_instance->getTransactionBatches($startTime, $endTime);
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
