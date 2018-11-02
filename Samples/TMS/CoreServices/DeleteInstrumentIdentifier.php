<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function DeleteInstrumentIdentifier()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  	include_once '../cybersource-rest-samples-php/Samples/TMS/CoreServices/RetrieveInstrumentIdentifier.php';
  	$tokenId = RetrieveInstrumentIdentifier(true);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->instrumentidentifiersTokenIdDelete($profileId, $tokenId);
		echo "<pre>";print_r($api_response);
	} catch (Cybersource\ApiException $e) {
    	print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	DeleteInstrumentIdentifier();

}
?>	
