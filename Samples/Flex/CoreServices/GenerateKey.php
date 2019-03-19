<?php

require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GenerateKey()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\KeyGenerationApi($apiclient);
	$flexRequestArr = [
	'encryptionType' => "None",
	];
	$flexRequest = new CyberSource\Model\KeyParameters($flexRequestArr);
	$api_response = list($response, $statusCode, $httpHeader)=null;
	try {
		$api_response = $api_instance->generatePublicKey($flexRequest);
		print_r($api_response);
		

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
        print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GenerateKey Samplecode is Running.. \n";
	GenerateKey();
}

?>	
