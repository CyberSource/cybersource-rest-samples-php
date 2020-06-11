<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetNetfundingInformationForAccountOrMerchant()
{
	$startTime = "2019-08-01T00:00:00Z";
	$endTime = "2019-09-01T23:59:59Z";
	$organizationId = "testrest";
	$groupName = null;

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\NetFundingsApi($api_client);


	try {
		$apiResponse = $api_instance->getNetFundingDetails($startTime, $endTime, $organizationId, $groupName);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetNetfundingInformationForAccountOrMerchant Sample Code is Running..." . PHP_EOL;
	GetNetfundingInformationForAccountOrMerchant();
}
?>
