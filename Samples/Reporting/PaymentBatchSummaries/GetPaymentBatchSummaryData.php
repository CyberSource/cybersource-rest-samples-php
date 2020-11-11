<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetPaymentBatchSummaryData()
{
	$startTime = "2020-09-01T12:00:00Z";
	$endTime = "2020-09-30T12:00:00Z";
	$organizationId = "testrest";
	$rollUp = null;
	$breakdown = null;
	$startDayOfWeek = null;

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentBatchSummariesApi($api_client);

	try {
		$apiResponse = $api_instance->getPaymentBatchSummary($startTime, $endTime, $organizationId, $rollUp, $breakdown, $startDayOfWeek);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetPaymentBatchSummaryData Sample Code is Running..." . PHP_EOL;
	GetPaymentBatchSummaryData();
}
?>
