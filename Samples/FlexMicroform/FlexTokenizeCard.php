<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './GenerateKeyLegacyTokenFormat.php';

function FlexTokenizeCard()
{
	$generatedKey = GenerateKeyLegacyTokenFormat();
	$keyId = $generatedKey[0]['keyId'];
	$publicKey = $generatedKey[0]['der']['publicKey'];
	$publicKey = "-----BEGIN PUBLIC KEY-----\n" . $publicKey . "\n-----END PUBLIC KEY-----";

	$cardInfoArr = [
			"cardNumber" => "4111111111111111",
			"cardExpirationMonth" => "12",
			"cardExpirationYear" => "2031",
			"cardType" => "001"
	];
	$cardInfo = new CyberSource\Model\Flexv1tokensCardInfo($cardInfoArr);

	$requestObjArr = [
		"keyId" => $keyId,
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

		$tokenVerifier = new CyberSource\Utilities\Flex\TokenVerification();
		print_r("TOKEN VERIFICATION : " . $tokenVerifier->verifyToken($publicKey, $apiResponse));
		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nFlexTokenizeCard Sample Code is Running..." . PHP_EOL;
	FlexTokenizeCard();
}
?>
