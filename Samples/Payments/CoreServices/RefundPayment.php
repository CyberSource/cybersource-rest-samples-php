<?php
error_reporting(E_ALL);
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function RefundPayment($flag)
{
  $commonElement = new CyberSource\ExternalConfiguration();
  $config = $commonElement->ConnectionHost();
  $apiclient = new CyberSource\ApiClient($config);
  $api_instance = new CyberSource\Api\RefundApi($apiclient);
  include_once '../cybersource-rest-samples-php/Samples/Payments/CoreServices/ProcessPayment.php';
  $id = ProcessPayment(true);
  $cliRefInfoArr = [
    "code" => "test_refund_payment"
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
  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information
  ];

  $paymentRequest = new CyberSource\Model\RefundPaymentRequest($paymentRequestArr);

  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->refundPayment($paymentRequest, $id);
    if($flag ==true){
      //Returning the ID
      echo "Fetching Refund Payment ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }
    else {
      print_r($api_response);
    }

  } catch (Cybersource\ApiException $e) {
    print_r($e->getresponseBody());
    print_r($e->getMessage());
  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Refund Payment Samplecode is Running..\n";
  RefundPayment(false);

}

?>  
