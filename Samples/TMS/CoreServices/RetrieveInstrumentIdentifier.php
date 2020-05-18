<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function RetrieveInstrumentIdentifier($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	require_once __DIR__. DIRECTORY_SEPARATOR .'CreateInstrumentIdentifier.php';
		$tokenId = CreateInstrumentIdentifier(true);
		
	sleep(10);

	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getInstrumentIdentifier($profileId, $tokenId);
		if($flag == true){
			//Returning the ID
			echo "Fetching RetrieveInstrumentIdentifier ID: ".$api_response[0]['id']."\n";
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
    echo "RetrieveInstrumentIdentifier Samplecode is Running.. \n";
	RetrieveInstrumentIdentifier(false);

}
?>	
