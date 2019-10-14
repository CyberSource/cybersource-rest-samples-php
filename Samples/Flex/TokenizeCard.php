<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function TokenizeCard()
{
	$cardInfoArr = [
			"cardNumber" => "4111111111111111",
			"cardExpirationMonth" => "12",
			"cardExpirationYear" => "2031",
			"cardType" => "001"
	];
	$cardInfo = new CyberSource\Model\Flexv1tokensCardInfo($cardInfoArr);

	$requestObjArr = [
			"keyId" => "08z9hCmn4pRpdNhPJBEYR3Mc2DGLWq5j",
			"cardInfo" => $cardInfo
	];
	$requestObj = new CyberSource\Model\TokenizeRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\TokenizationApi($api_client);

	try {
		$apiResponse = $api_instance->tokenize($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nTokenizeCard Sample Code is Running..." . PHP_EOL;
	TokenizeCard();
}
?>
