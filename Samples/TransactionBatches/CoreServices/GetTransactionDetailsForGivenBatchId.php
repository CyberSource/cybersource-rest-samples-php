<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetTransactionDetailsForGivenBatchId()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiClient = new CyberSource\ApiClient($config, $merchantConfig);
	$apiInstance = new CyberSource\Api\TransactionBatchesApi($apiClient);

	$id = "12345";
	$uploadDate = "2019-05-01T12:00:00Z";
	$status = "REJECTED";	
	
	try {
		$apiResponse = $apiInstance->getTransactionBatchDetails( $id, $uploadDate, $status );
		print_r($apiResponse);
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}
if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "GetTransactionDetailsForGivenBatchId Samplecode is Running.. \n";
	GetTransactionDetailsForGivenBatchId();
}
?>
