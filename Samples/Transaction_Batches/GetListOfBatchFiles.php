<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetListOfBatchFiles()
{
	$startTime = "2019-05-22T01:47:57.000Z";
	$endTime = "2019-07-22T22:47:57.000Z";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\TransactionBatchesApi($api_client);

	try {
		$apiResponse = $api_instance->getTransactionBatches($startTime, $endTime);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetListOfBatchFiles Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing query parameter <startTime>: ";
	$startTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <endTime>: ";
	$endTime = trim(fgets(STDIN));
	GetListOfBatchFiles($startTime, $endTime);
}
?>
