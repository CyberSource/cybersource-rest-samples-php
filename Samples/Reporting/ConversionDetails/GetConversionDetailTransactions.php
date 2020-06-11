<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetConversionDetailTransactions()
{
	$startTime = "2019-03-21T00:00:00Z";
	$endTime = "2019-03-21T23:00:00Z";
	$organizationId = "testrest";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ConversionDetailsApi($api_client);

	try {
		$apiResponse = $api_instance->getConversionDetail($startTime, $endTime, $organizationId);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetConversionDetailTransactions Sample Code is Running..." . PHP_EOL;
	GetConversionDetailTransactions();
}
?>
