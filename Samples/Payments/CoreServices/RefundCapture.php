<?php
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function RefundCapture()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\RefundApi($apiclient);
  include_once '../cybersource-rest-samples-php/Samples/Payments/CoreServices/CapturePayment.php';
  $id = CapturePayment(true);
	$cliRefInfoArr = [
    "code" => "test_refund_capture"
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);
  $amountDetailsArr = [
      "totalAmount" => "10",
      "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\V2paymentsOrderInformationAmountDetails($amountDetailsArr);
  
  $orderInfoArry = [
    "amountDetails" => $amountDetInfo
  ];

  $order_information = new CyberSource\Model\V2paymentsOrderInformation($orderInfoArry);
  

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information
  ];

  $paymentRequest = new CyberSource\Model\RefundCaptureRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->refundCapture($paymentRequest, $id);
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "RefundCapture Sample code is Running..\n";
	RefundCapture();

}

?>	
