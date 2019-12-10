<?php

require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';


function TokenizeCard($keyId, $publicKey)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\TokenizationApi($apiclient);
	$publicKey = "-----BEGIN PUBLIC KEY-----\n".$publicKey."\n-----END PUBLIC KEY-----";
	 
	$cardInfoArr = [
	'cardNumber' => "5555555555554444",
	'cardExpirationMonth' => "03",
	'cardExpirationYear' => "2031",
	'cardType' => "002"
	];
	$card_information = new CyberSource\Model\Flexv1tokensCardInfo($cardInfoArr);
	$flexRequestArr = [
	'keyId' => $keyId,
	'cardInfo' => $card_information
	];
	$flexRequest = new CyberSource\Model\TokenizeRequest($flexRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tokenize($flexRequest);
		print_r($api_response);
		$tokenVerifier = new CyberSource\Utilities\Flex\TokenVerification();
		print_r("TOKEN VERIFICATION : " . $tokenVerifier->verifyToken($publicKey, $api_response));
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}    
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "TokenizeCard Samplecode is Processing\n";
    include_once __DIR__. DIRECTORY_SEPARATOR .'../KeyGenerationNoEnc.php';
  	$data = KeyGenerationNoEnc(true);
	TokenizeCard($data[0], $data[1]);
}
?>	
