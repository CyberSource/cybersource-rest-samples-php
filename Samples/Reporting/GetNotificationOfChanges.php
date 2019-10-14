<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetNotificationOfChanges()
{
	$startTime = "2019-09-01T12:00:00-05:00";
	$endTime = "2019-09-10T12:00:00-05:00";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\NotificationOfChangesApi($api_client);

	try {
		$apiResponse = $api_instance->getNotificationOfChangeReport($startTime, $endTime);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetNotificationOfChanges Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing query parameter <startTime>: ";
	$startTime = trim(fgets(STDIN));
	echo "\nInput missing query parameter <endTime>: ";
	$endTime = trim(fgets(STDIN));
	GetNotificationOfChanges($startTime, $endTime);
}
?>
