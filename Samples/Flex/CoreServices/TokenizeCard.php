<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');
require_once('Samples/Flex/Verifier.php');


function TokenizeCard($keyId, $publicKey)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\TokenizationApi($apiclient);
	$publicKey = "-----BEGIN PUBLIC KEY-----\n".$publicKey."\n-----END PUBLIC KEY-----";
	 
	$cardInfoArr = [
	'cardNumber' => "5555555555554444",
	'cardExpirationMonth' => "03",
	'cardExpirationYear' => "2031",
	'cardType' => "002"
	];
	$card_information = new CyberSource\Model\Paymentsflexv1tokensCardInfo($cardInfoArr);
	$flexRequestArr = [
	'keyId' => $keyId,
	'cardInfo' => $card_information
	];
	$flexRequest = new CyberSource\Model\TokenizeRequest($flexRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tokenize($flexRequest);
		print_r($api_response);
		$verifyObj = new Verifier();
		return $verifyObj->verifySignature($publicKey, $api_response);
		

	} catch (Cybersource\ApiException $e) {
		print_r($e->getresponseBody());
		print_r($e->getMessage());
	}
}    
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "TokenizeCard Sample Code is Processing\n";
    include_once './Samples/Flex/KeyGenerationNoEnc.php';
  	$data = KeyGenerationNoEnc(true);
	TokenizeCard($data[0], $data[1]);
}
?>	
