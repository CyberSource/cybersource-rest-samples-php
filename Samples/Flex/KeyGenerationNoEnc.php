<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function SampleGenerateKeyNoEnc()
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
		print_r($api_response);
		//$publicKey = openssl_pkey_get_public($api_response); 
		//echo "<pre>";print_r($publicKey);
		//$pub = openssl_pkey_get_details($publicKey);
		//echo $pub['key']; 
		//die("success");

	} catch (Exception $e) {
		print_r($e->getresponseBody());
		print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Get Customer Sample Code\n";
	SampleGenerateKeyNoEnc();
}

?>	
