<?php

require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function ProcessAuthorizationReversalWithServiceFee($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReversalApi($apiclient);
  require_once __DIR__. DIRECTORY_SEPARATOR .'ProcessPaymentWithServiceFee.php';
  $id = ProcessPaymentWithServiceFee("notallow");
  
  $cliRefInfoArr = [
    'code' => 'TC50171_3'
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);

  $amountDetailsArr = [
    "totalAmount" => "2325.00"
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
    echo "Process Authorization Reversal Samplecode is Running.. \n";
    ProcessAuthorizationReversalWithServiceFee(false);
}
?>	
