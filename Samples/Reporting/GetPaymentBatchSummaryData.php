<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetPaymentBatchSummaryData()
{
	$startTime = "2019-05-01T12:00:00-05:00";
	$endTime = "2019-08-30T12:00:00-05:00";
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
	echo "\nInput missing query parameter <startTime>: ";
	$startTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <endTime>: ";
	$endTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <organizationId>: ";
	$organizationId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <rollUp>: ";
	$rollUp = trim(fgets(STDIN));
	echo "\nInput missing query parameter <breakdown>: ";
	$breakdown = trim(fgets(STDIN));
	echo "\nInput missing query parameter <startDayOfWeek>: ";
	$startDayOfWeek = trim(fgets(STDIN));
	GetPaymentBatchSummaryData($startTime, $endTime, $organizationId, $rollUp, $breakdown, $startDayOfWeek);
}
?>
