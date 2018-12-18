<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function RetrieveTransaction()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\TransactionDetailsApi($apiclient);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$id="5408386919326811103004";
	try {
		$api_response = $api_instance->getTransaction($id);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "RetrieveTransaction Samplecode is Running.. \n";
	RetrieveTransaction();

}
?>	
