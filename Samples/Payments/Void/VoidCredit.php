<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Credit/Credit.php';

function VoidCredit()
{
	$id = Credit()[0]['id'];

	$clientReferenceInformationArr = [
			"code" => "test_void"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation
	];
	$requestObj = new CyberSource\Model\VoidCreditRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\VoidApi($api_client);

	try {
		$apiResponse = $api_instance->voidCredit($requestObj, $id);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nVoidCredit Sample Code is Running..." . PHP_EOL;
	VoidCredit();
}
?>
