<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'CreateInstrumentIdentifierCard.php';

function RetrieveInstrumentIdentifier()
{
	$profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$tokenId = CreateInstrumentIdentifierCard()[0]['id'];
	
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
	RetrieveInstrumentIdentifier();
}
?>
