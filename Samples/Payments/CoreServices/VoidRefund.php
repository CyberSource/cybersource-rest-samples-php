<?php
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function VoidRefund()
{
	$commonElement = new CyberSource\ExternalConfiguration();
  $config = $commonElement->ConnectionHost();
  $apiclient = new CyberSource\ApiClient($config);
  $api_instance = new CyberSource\Api\VoidApi($apiclient);
  include_once '../cybersource-rest-samples-php/Samples/Payments/CoreServices/RefundPayment.php';
  $id = RefundPayment(true);
  $cliRefInfoArr = [
    'code' => 'test_refund_void'
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information
  ];

  $paymentRequest = new CyberSource\Model\VoidRefundRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->voidRefund($paymentRequest, $id);
    echo "<pre>";print_r($api_response);

  } catch (Cybersource\ApiException $e) {
    print_r($e->getresponseBody());
    print_r($e->getMessage());
  }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Voidrefund Samplecode is Running..\n";
	VoidRefund();

}

?>	
