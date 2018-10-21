<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');
require_once('Samples/Flex/Verifier.php');


function TokenizeCard()
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\TokenizationApi($apiclient);
	$str = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAirV8NdP1saW5YpSwcWc4EKccLr6uGJFqIbvX06gyCYdHBeqXPQ7DbetW+rrCxAWhePkQbiLW7LMQrOtohvyS8ZASItDQjr00rTYuvBiqKq7f3GYM9aSTG+ncCpcnK5jvP09+J5170yx+Jb8UIm+CN5KWrt8V6EVs/E9bvBGINr4RpokMpqfWcrUCEN/AdmNbcQZ2ImUckcdT7uNmwrvSUhWf20sgysh3NJDVqd2Rf5D3FnyZUc3dbzMd82T56ug1Xs46PQ6bFCCJeYmTLvMtzEqD317PNcRyJL73XCHSZSTCKoaaVVXNAJo/zQOb2JLgwJEyST3VFbcZvWx/m1tTIwIDAQAB';
	$publicKey = "-----BEGIN PUBLIC KEY-----\n".$str."\n-----END PUBLIC KEY-----";
	 
	$cardInfoArr = [
	'cardNumber' => "5555555555554444",
	'cardExpirationMonth' => "03",
	'cardExpirationYear' => "2031",
	'cardType' => "002"
	];
	$card_information = new CyberSource\Model\Paymentsflexv1tokensCardInfo($cardInfoArr);
	$flexRequestArr = [
	'keyId' => "08IIIeuCJiOffZuVwT4FfccSTYwn85B7",
	'cardInfo' => $card_information
	];
	$flexRequest = new CyberSource\Model\TokenizeRequest($flexRequestArr);
	//print_r($flexRequest);die;
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tokenize($flexRequest);
		echo "<pre>";print_r($api_response);

		$verifyObj = new Verifier();
		$return = $verifyObj->verifySignature($publicKey, $api_response);
		

	} catch (Exception $e) {
		print_r($e->getresponseBody());
		print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Get Customer Sample Code\n";
	TokenizeCard();
}

?>	
