<?php
//echo "Inside php functionality"
error_reporting(E_ALL);
require_once __DIR__. DIRECTORY_SEPARATOR .'../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../Resources/ExternalConfiguration.php';

function KeyGenerationNoEnc($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
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
			include_once __DIR__. DIRECTORY_SEPARATOR . 'CoreServices/TokenizeCard.php';
	  		$id = TokenizeCard($keyId, $publicKey);
		}
		

	} catch (Cybersource\ApiException $e) {
		print_r($e->getresponseBody());
		print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "KeyGenerationNoEnc Sample Code is Processing\n";
	KeyGenerationNoEnc(false);
}

?>	
