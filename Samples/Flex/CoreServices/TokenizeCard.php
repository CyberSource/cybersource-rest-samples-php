<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
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
		

	} catch (Exception $e) {
		print_r($e->getresponseBody());
		print_r($e->getmessage());
	}
}    
if(!defined('DO NOT RUN SAMPLE')){
    echo "TokenizeCard Sample Code is Processing\n";
    include_once '../cybersource-rest-samples-php/Samples/Flex/KeyGenerationNoEnc.php';
  	$data = KeyGenerationNoEnc(true);
	TokenizeCard($data[0], $data[1]);
}
?>	
