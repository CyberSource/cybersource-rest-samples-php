<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ListPaymentInstrumentsForCustomer()
{
	$customerTokenId = 'AB695DA801DD1BB6E05341588E0A3BDC';
	$profileid = null;
	$offset = null;
	$limit = null;

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\CustomerPaymentInstrumentApi($api_client);

	try {
		$apiResponse = $api_instance->getCustomerPaymentInstrumentsList($customerTokenId, $profileid, $offset, $limit);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	ListPaymentInstrumentsForCustomer();
}
?>
