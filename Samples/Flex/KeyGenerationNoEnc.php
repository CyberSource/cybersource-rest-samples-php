<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./ExternalConfig.php');

function KeyGenerationNoEnc($flag)
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\KeyGenerationApi($apiclient);
	$flexRequestArr = [
		'encryptionType' => "None",
	];
	$flexRequest = new CyberSource\Model\KeyParameters($flexRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->generatePublicKey($flexRequest);
		$keyId = $api_response[0]['keyId'];
		$publicKey = $api_response[0]['der']['publicKey'];
		if($flag == true){
			$returnData = [$keyId, $publicKey];
			return $returnData;
		}else {
			print_r($api_response);
			include_once '../cybersource-rest-samples-php/Samples/Flex/CoreServices/TokenizeCard.php';
	  		$id = TokenizeCard($keyId, $publicKey);
		}
		

	} catch (Exception $e) {
		print_r($e->getresponseBody());
		print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "KeyGenerationNoEnc Sample Code is Processing\n";
	KeyGenerationNoEnc(false);
}

?>	
