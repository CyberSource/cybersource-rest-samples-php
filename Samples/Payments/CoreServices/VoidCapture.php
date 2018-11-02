<?php
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function VoidCapture()
{
	$commonElement = new CyberSource\ExternalConfiguration();
  $config = $commonElement->ConnectionHost();
  $apiclient = new CyberSource\ApiClient($config);
  $api_instance = new CyberSource\Api\VoidApi($apiclient);
  include_once '../cybersource-rest-samples-php/Samples/Payments/CoreServices/CapturePayment.php';
  $id = CapturePayment(true);
  $cliRefInfoArr = [
    'code' => 'test_void'
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information
  ];

  $paymentRequest = new CyberSource\Model\VoidCaptureRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->voidCapture($paymentRequest, $id);
    echo "<pre>";print_r($api_response);

  } catch (Exception $e) {
    print_r($e->getresponseBody());
    print_r($e->getmessage());
  }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "VoidCapture Samplecode is Running..\n";
	VoidCapture();

}

?>	
