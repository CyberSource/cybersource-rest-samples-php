<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function RemoveInstrumentIdentifier()
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  	$tokenId = "7020000000000137654";
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->instrumentidentifiersTokenIdDelete($profileId, $tokenId);
		echo "<pre>";print_r($api_response);
	} catch (Exception $e) {
    	print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	RemoveInstrumentIdentifier();

}
?>	
