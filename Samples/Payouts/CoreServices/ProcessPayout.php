<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function ProcessAPayout()
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\CaptureApi($apiclient);
	$cliRefInfoArr = [
    'code' => '1234567890'
  ];
  $client_reference_information = new CyberSource\Model\V2paymentsClientReferenceInformation($cliRefInfoArr);

  $deviceInformationArr = [
    "ipAddress" => "66.185.179.2"
  ];
  $deviceInformation = new CyberSource\Model\V2paymentsDeviceInformation($deviceInformationArr);
  $processingInformationArr = [
    "capture" => "true"
  ];
  $processingInformation = new CyberSource\Model\V2paymentsProcessingInformation($processingInformationArr);

  $amountDetailsArr = [
      "totalAmount" => "2201",
      "currency" => "USD"
    ];
  $amountDetInfo = new CyberSource\Model\V2paymentsOrderInformationAmountDetails($amountDetailsArr);
  $billtoArr = [
    "country" => "US",
    "firstName" => "John",
    "lastName" => "Deo",
    "phoneNumber" => "6504327113",
    "address2" => "Desk M3-5573",
    "address1" => "901 Metro Center Blvd",
    "postalCode" => "94404",
    "locality" => "Foster City",
    "company" => "Visa",
    "administrativeArea" => "CA",
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
    "deviceInformation" => $deviceInformation,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "processingInformation" => $processingInformation
  ];

  $paymentRequest = new CyberSource\Model\CreatePaymentRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->createPayment($paymentRequest);
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	ProcessAPayout();

}

?>	
