<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function RetrievePaymentInstrument($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentInstrumentApi($apiclient);
  	include_once '../cybersource-rest-samples-php/Samples/TMS/CoreServices/CreatePaymentInstrument.php';
  	$tokenId = CreatePaymentInstrument(true);
  	$profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->paymentinstrumentsTokenIdGet($profileId, $tokenId);
		if($flag == true){
			//Returning the ID
		  	echo "Fetching RetrievePaymentInstrument ID: ".$api_response[0]['id']."\n";
			return $api_response[0]['id'];
		}else{
			print_r($api_response);
		}

	} catch (Cybersource\ApiException $e) {
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "RetrievePaymentInstrument Samplecode is Running..";
	RetrievePaymentInstrument(false);

}
?>	
