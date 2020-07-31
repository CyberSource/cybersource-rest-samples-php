<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GenerateKey()
{
	$requestObjArr = [
			"encryptionType" => "RsaOaep",
			"targetOrigin" => "https://www.test.com"
	];
	$requestObj = new CyberSource\Model\GeneratePublicKeyRequest($requestObjArr);

	$format = "JWT";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\KeyGenerationApi($api_client);

	try {
		$apiResponse = $api_instance->generatePublicKey($format, $requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGenerateKey Sample Code is Running..." . PHP_EOL;
	GenerateKey();
}
?>
