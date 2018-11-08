<?php

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function ProcessAuthorizationReversal($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReversalApi($apiclient);
  include_once 'Samples/Payments/CoreServices/ProcessPayment.php';
  $id = ProcessPayment("notallow");
  
  $cliRefInfoArr = [
    'code' => 'TC50171_3'
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);

  $amountDetailsArr = [
    "totalAmount" => "102.21"
  ];
  $amountDetInfo = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($amountDetailsArr);
  $reversalInformationArr = [
    "amountDetails" => $amountDetInfo,
    "reason" => "testing"
  ];
  $reversalInformation = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformation($reversalInformationArr);
  
  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "reversalInformation" => $reversalInformation
  ];

  $paymentRequest = new CyberSource\Model\AuthReversalRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->authReversal($id, $paymentRequest);
    if($flag == true){
      //Returning the ID
		  echo "Fetching Reversal: ".$api_response[0]['id']."\n";
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
    echo "ProcessAuthorizationReversal Samplecode is Running.. \n";
	ProcessAuthorizationReversal(false);

}

?>	
