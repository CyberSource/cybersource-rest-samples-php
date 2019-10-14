<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function RetrieveAvailableReports()
{
	$organizationId = null;
	$startTime = "2018-10-01T00:00:00.0Z";
	$endTime = "2018-10-30T23:59:59.0Z";
	$timeQueryType = "executedTime";
	$reportMimeType = "application/xml";
	$reportFrequency = null;
	$reportName = null;
	$reportDefinitionId = null;
	$reportStatus = null;

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportsApi($api_client);

	try {
		$apiResponse = $api_instance->searchReports($startTime, $endTime, $timeQueryType, $organizationId, $reportMimeType, $reportFrequency, $reportName, $reportDefinitionId, $reportStatus);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nRetrieveAvailableReports Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing query parameter <organizationId>: ";
	$organizationId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <startTime>: ";
	$startTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <endTime>: ";
	$endTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <timeQueryType>: ";
	$timeQueryType = trim(fgets(STDIN));
	echo "\nInput missing query parameter <reportMimeType>: ";
	$reportMimeType = trim(fgets(STDIN));
	echo "\nInput missing query parameter <reportFrequency>: ";
	$reportFrequency = trim(fgets(STDIN));
	echo "\nInput missing query parameter <reportName>: ";
	$reportName = trim(fgets(STDIN));
	echo "\nInput missing query parameter <reportDefinitionId>: ";
	$reportDefinitionId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <reportStatus>: ";
	$reportStatus = trim(fgets(STDIN));
	RetrieveAvailableReports($organizationId, $startTime, $endTime, $timeQueryType, $reportMimeType, $reportFrequency, $reportName, $reportDefinitionId, $reportStatus);
}
?>
