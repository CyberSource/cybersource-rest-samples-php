<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function ProcessAuthorizationReversal()
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReversalApi($apiclient);

  $id = '5395980787496554703002';
	$cliRefInfoArr = [
    'code' => 'TC50171_3'
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);

  $amountDetailsArr = [
    "totalAmount" => "102.21"
  ];
  $amountDetInfo = new CyberSource\Model\V2paymentsidreversalsReversalInformationAmountDetails($amountDetailsArr);
  $reversalInformationArr = [
    "amountDetails" => $amountDetInfo,
    "reason" => "testing"
  ];
  $reversalInformation = new CyberSource\Model\V2paymentsidreversalsReversalInformation($reversalInformationArr);
  
  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "reversalInformation" => $reversalInformation
  ];

  $paymentRequest = new CyberSource\Model\AuthReversalRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->authReversal($id, $paymentRequest);
		print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	ProcessAuthorizationReversal();

}

?>	
