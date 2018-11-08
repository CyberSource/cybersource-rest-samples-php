<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function DeletePaymentsInstruments()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentInstrumentsApi($apiclient);
	include_once 'Samples/TMS/CoreServices/RetrievePaymentInstrument.php';
  	$tokenId = RetrievePaymentInstrument(true);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tmsV1PaymentinstrumentsTokenIdDelete($profileId, $tokenId);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "DeletePaymentsInstruments Samplecode is Running.. \n";
	DeletePaymentsInstruments();

}
?>	
