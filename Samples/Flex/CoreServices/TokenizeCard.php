<?php

require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../Verifier.php';


function TokenizeCard($keyId, $publicKey)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\FlexTokenApi($apiclient);
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
	$flexRequestArr = json_decode($flexRequest);
	echo "The Api Request Body: \n". json_encode($flexRequestArr, JSON_UNESCAPED_SLASHES) ."\n\n";
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tokenize($flexRequest);
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
		$resBodyArr= json_decode($api_response[0]);
		echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
		echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
		echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";
		$verifyObj = new Verifier();
		return $verifyObj->verifySignature($publicKey, $api_response);
		

	} catch (Cybersource\ApiException $e) {
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
	    echo "The Exception Response Body: \n";
		print_r($e->getResponseBody()); echo "\n\n";
	    echo "The Exception Response Header: \n";
	    print_r($e->getResponseHeaders()); echo "\n\n";
	    echo "The Exception Response Header: \n";
	    print_r($e->getMessage());echo "\n\n";
	}
}    
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "[BEGIN] EXECUTION OF SAMPLE CODE:  TokenizeCard\n\n";
    include_once __DIR__. DIRECTORY_SEPARATOR .'../KeyGenerationNoEnc.php';
  	$data = KeyGenerationNoEnc(true);
	TokenizeCard($data[0], $data[1]);
}
?>	
