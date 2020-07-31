<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateCustomer()
{
	$buyerInformationArr = [
			"merchantCustomerID" => "Your customer identifier",
			"email" => "test@cybs.com"
	];
	$buyerInformation = new CyberSource\Model\Tmsv2customersBuyerInformation($buyerInformationArr);

	$clientReferenceInformationArr = [
			"code" => "TC50171_3"
	];
	$clientReferenceInformation = new CyberSource\Model\Tmsv2customersClientReferenceInformation($clientReferenceInformationArr);

	$merchantDefinedInformation = array();
	$merchantDefinedInformation_0 = [
			"name" => "data1",
			"value" => "Your customer data"
	];
	$merchantDefinedInformation[0] = new CyberSource\Model\Tmsv2customersMerchantDefinedInformation($merchantDefinedInformation_0);

	$requestObjArr = [
			"buyerInformation" => $buyerInformation,
			"clientReferenceInformation" => $clientReferenceInformation,
			"merchantDefinedInformation" => $merchantDefinedInformation
	];
	$requestObj = new CyberSource\Model\PostCustomerRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\CustomerApi($api_client);

	try {
		$apiResponse = $api_instance->postCustomer($requestObj, null);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	CreateCustomer();
}
?>
