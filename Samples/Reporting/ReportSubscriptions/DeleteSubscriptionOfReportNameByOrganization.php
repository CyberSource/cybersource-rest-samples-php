<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function DeleteSubscriptionOfReportNameByOrganization()
{
	$reportName = "testrests_subcription_v1";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportSubscriptionsApi($api_client);

	try {
		$apiResponse = $api_instance->deleteSubscription($reportName);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nDeleteSubscriptionOfReportNameByOrganization Sample Code is Running..." . PHP_EOL;
	DeleteSubscriptionOfReportNameByOrganization();
}
?>
