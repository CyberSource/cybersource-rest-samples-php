<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function RetrieveInstrumentIdentifier($profileid, $tokenId)
{

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($api_client);

	try {
		$apiResponse = $api_instance->getInstrumentIdentifier($profileid, $tokenId);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nRetrieveInstrumentIdentifier Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing header parameter <profile-id>: ";
	$profileid = trim(fgets(STDIN));
	echo "\nInput missing path parameter <tokenId>: ";
	$tokenId = trim(fgets(STDIN));
	RetrieveInstrumentIdentifier($profileid, $tokenId);
}
?>
