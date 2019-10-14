<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function DownloadXSDForReport($reportDefinitionNameVersion)
{

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\DownloadXSDApi($api_client);

	try {
		$apiResponse = $api_instance->getXSDV2($reportDefinitionNameVersion);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nDownloadXSDForReport Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing path parameter <reportDefinitionNameVersion>: ";
	$reportDefinitionNameVersion = trim(fgets(STDIN));
	DownloadXSDForReport($reportDefinitionNameVersion);
}
?>
