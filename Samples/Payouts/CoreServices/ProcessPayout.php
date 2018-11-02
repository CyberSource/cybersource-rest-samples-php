<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../cybersource-rest-client-php/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function ProcessPayout()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\DefaultApi($apiclient);
	$cliRefInfoArr = [
    "code" => "33557799"
  ];
  $client_reference_information = new CyberSource\Model\InlineResponse201ClientReferenceInformation($cliRefInfoArr);

  $recipientInformationArr = [
    "firstName" => "John",
    "lastName" => "Doe",
    "address1" => "Paseo Padre Boulevard",
    "locality" => "Foster City",
    "administrativeArea" => "CA",
    "country" => "US",
    "postalCode" => "94400",
    "phoneNumber" => "6504320556"
  ];
  $recipientInformation = new CyberSource\Model\V2payoutsRecipientInformation($recipientInformationArr);
  $accountArr = [
    "fundsSource" => "01",
    "number" => "1234567890123456789012345678901234"
  ];
  $account = new CyberSource\Model\V2payoutsSenderInformationAccount($accountArr);
  $senderInformationArr = [
    "referenceNumber" => "1234567890",
    "account" => $account,
    "name" => "Company Name",
    "address1" => "900 Metro Center Blvd",
    "locality" => "Foster City",
    "administrativeArea" => "CA",
    "countryCode" => "US"
  ];
  $senderInformation = new CyberSource\Model\V2payoutsSenderInformation($senderInformationArr);

  $processingInformationArr = [
    "businessApplicationId" => "FD",
    "commerceIndicator" => "internet"
  ];
  $processingInformation = new CyberSource\Model\V2payoutsProcessingInformation($processingInformationArr);

  $amountDetailsArr = [
    "totalAmount" => "100.00",
    "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\V2payoutsOrderInformationAmountDetails($amountDetailsArr);
  
  $orderInfoArry = [
    "amountDetails" => $amountDetInfo
  ];

  $order_information = new CyberSource\Model\V2payoutsOrderInformation($orderInfoArry);

  $merchantDescriptorArr = [
    "name" => "Sending Company Name",
    "locality" => "FC",
    "country" => "US",
    "administrativeArea" => "CA",
    "postalCode" => "94440"
    
  ];
  $merchantDescriptor = new CyberSource\Model\V2payoutsMerchantInformationMerchantDescriptor($merchantDescriptorArr);
  $merchantInformationArr = [
    "merchantDescriptor" => $merchantDescriptor
    
  ];
  $merchantInformation = new CyberSource\Model\V2payoutsMerchantInformation($merchantInformationArr);

  $paymentCardInfo = [
    "type" => "001",
    "number" => "4111111111111111",
    "expirationMonth" => "12",
    "expirationYear" => "2025",
    "sourceAccountType" => "CH"
  ];
  $card = new CyberSource\Model\V2payoutsPaymentInformationCard($paymentCardInfo);
  $paymentInfoArr = [
      "card" => $card
      
  ];
  $payment_information = new CyberSource\Model\V2payoutsPaymentInformation($paymentInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "recipientInformation" => $recipientInformation,
    "senderInformation" => $senderInformation,
    "merchantInformation" => $merchantInformation,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "processingInformation" => $processingInformation
  ];

  $paymentRequest = new CyberSource\Model\OctCreatePaymentRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->octCreatePayment($paymentRequest);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getresponseBody());
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "ProcessPayout Samplecode is Running..";
	ProcessPayout();

}

?>	
