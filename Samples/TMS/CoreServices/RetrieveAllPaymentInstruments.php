<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function RetrieveAllPaymentInstruments()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  	$tokenId = "7020000000000137654";
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->instrumentidentifiersTokenIdPaymentinstrumentsGet($profileId, $tokenId);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Samplecode is Running..";
	RetrieveAllPaymentInstruments();

}
?>	
