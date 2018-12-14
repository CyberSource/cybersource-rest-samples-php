<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function RetrievePaymentInstrument($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentInstrumentsApi($apiclient);
	require_once __DIR__. DIRECTORY_SEPARATOR .'CreatePaymentInstrument.php';
  	$tokenId = CreatePaymentInstrument(true);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tmsV1PaymentinstrumentsTokenIdGet($profileId, $tokenId);
		if($flag == true){
			//Returning the ID
		  	echo "Fetching RetrievePaymentInstrument ID: ".$api_response[0]['id']."\n";
			return $api_response[0]['id'];
		}else{
			print_r($api_response);
		}

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "RetrievePaymentInstrument Samplecode is Running.. \n";
	RetrievePaymentInstrument(false);

}
?>	
