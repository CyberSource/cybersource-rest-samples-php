<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetReportBasedOnReportId($reportId)
{
	$organizationId = "testrest";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportsApi($api_client);

	try {
		$apiResponse = $api_instance->getReportByReportId($reportId, $organizationId);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetReportBasedOnReportId Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing path parameter <reportId>: ";
	$reportId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <organizationId>: ";
	$organizationId = trim(fgets(STDIN));
	GetReportBasedOnReportId($reportId, $organizationId);
}
?>
