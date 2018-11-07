<?php

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function ProcessPayment($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentApi($apiclient);
	$cliRefInfoArr = [
    "code" => "test_payment"
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);
  if($flag ==true){
    $processingInformationArr = [
      "capture" => true,
      "commerceIndicator" => "internet"
    ];
  }else{
    $processingInformationArr = [
      "commerceIndicator" => "internet"
    ];
  }
  $processingInformation = new CyberSource\Model\V2paymentsProcessingInformation($processingInformationArr);

  $amountDetailsArr = [
    "totalAmount" => "102.21",
    "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\V2paymentsOrderInformationAmountDetails($amountDetailsArr);
  $billtoArr = [
    "firstName" => "John",
    "lastName" => "Doe",
    "address1" => "1 Market St",
    "postalCode" => "94105",
    "locality" => "san francisco",
    "administrativeArea" => "CA",
    "country" => "US",
    "phoneNumber" => "4158880000",
    "company" => "Visa",
    "email" => "test@cybs.com"
  ];
  $billto = new CyberSource\Model\V2paymentsOrderInformationBillTo($billtoArr);
  $orderInfoArry = [
    "amountDetails" => $amountDetInfo,
    "billTo" => $billto
  ];

  $order_information = new CyberSource\Model\V2paymentsOrderInformation($orderInfoArry);
  $paymentCardInfo = [
    "expirationYear" => "2031",
    "number" => "4111111111111111",
    "securityCode" => "123",
    "expirationMonth" => "12"
  ];
  $card = new CyberSource\Model\V2paymentsPaymentInformationCard($paymentCardInfo);
  $paymentInfoArr = [
      "card" => $card
      
  ];
  $payment_information = new CyberSource\Model\V2paymentsPaymentInformation($paymentInfoArr);
  
  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "processingInformation" => $processingInformation
  ];
  //Creating model
  $paymentRequest = new CyberSource\Model\CreatePaymentRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    //Calling the Api
    $api_response = $api_instance->createPayment($paymentRequest);
    
    if($flag ==true){
      //Returning the ID
      echo "Fetching Payment ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }
    else {
      print_r($api_response);
    }

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
    print_r($e->getMessage());
	}
}


// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
  echo "Process payment Samplecode is Running..\n";
  ProcessPayment(false);

}
  
?>	
