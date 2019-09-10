<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetPaymentBatchSummaryData()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiClient = new CyberSource\ApiClient($config, $merchantConfig);
	$apiInstance = new CyberSource\Api\PaymentBatchSummariesApi($apiClient);
	
	$startTime = "2019-05-01T12:00:00Z";
	$endTime = "2019-08-30T12:00:00Z";
	$organizationId = "testrest";

	try {
		$apiResponse = $apiInstance->getPaymentBatchSummary($startTime, $endTime, $organizationId);
		print_r($apiResponse);
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}
if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "Get Payment Batch Summary Samplecode is Running.. \n";
	GetPaymentBatchSummaryData( );
}
?>
