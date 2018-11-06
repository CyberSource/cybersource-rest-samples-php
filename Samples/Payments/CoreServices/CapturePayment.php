<?php

require_once('vendor/autoload.php');
require_once('./Resources/Configuration.php');

function CapturePayment($flag)
{
	$commonElement = new CyberSource\Configuration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\CaptureApi($apiclient);
  include_once '../cybersource-rest-samples-php/Samples/Payments/CoreServices/ProcessPayment.php';
  $id = ProcessPayment(true);
	$cliRefInfoArr = [
    "code" => "test_capture"
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);
  $amountDetailsArr = [
      "totalAmount" => "102.21",
      "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\V2paymentsOrderInformationAmountDetails($amountDetailsArr);

  $orderInfoArry = [
    "amountDetails" => $amountDetInfo
  ];

  $order_information = new CyberSource\Model\V2paymentsOrderInformation($orderInfoArry);
  $requestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information
  ];
  //Creating model
  $request = new CyberSource\Model\CapturePaymentRequest($requestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    //Calling the Api
    $api_response = $api_instance->capturePayment($request, $id);
    
    if($flag == true){
      //Returning the ID
		  echo "Fetching Capture ID: ".$api_response[0]['id']."\n";
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
if(!defined('DO NOT RUN SAMPLE')){
  echo "Capture payment Samplecode is Running..\n";
  CapturePayment(false);

}


?>	
