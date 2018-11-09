<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function GetIndividualBatchFile()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\TransactionBatchApi($apiclient);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$Id="Owcyk6pl";
	try {
		$api_response = $api_instance->ptsV1TransactionBatchesIdGet($Id);
		echo "<pre>";print_r($api_response);
		

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GetIndividualBatchFile Samplecode is Running.. \n";
	GetIndividualBatchFile();

}
?>	
