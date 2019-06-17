<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function EnrollWithPendingAuthentication($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($apiclient);
	$cliRefInfoArr = [
    "code" => "cybs_test"
  ];
  $client_reference_information = new CyberSource\Model\Riskv1authenticationsClientReferenceInformation($cliRefInfoArr);
  
  $amountDetailsArr = [
    "totalAmount" => "10.99",
    "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\Riskv1decisionsOrderInformationAmountDetails($amountDetailsArr);

  $billtoArr = [
    "firstName" => "John",
    "lastName" => "Doe",
    "address1" => "1 Market St",
    "address2" => "Address 2",
    "postalCode" => "94105",
    "locality" => "san francisco",
    "administrativeArea" => "CA",
    "country" => "US",
    "phoneNumber" => "4158880000",
    "email" => "test@cybs.com"
  ];
  $billto = new CyberSource\Model\Riskv1authenticationsOrderInformationBillTo($billtoArr);

  $orderInfoArry = [
    "amountDetails" => $amountDetInfo,
    "billTo" => $billto
  ];
  $order_information = new CyberSource\Model\Riskv1authenticationsOrderInformation($orderInfoArry);

  $paymentCardInfo = [
    "expirationYear" => "2031",
    "number" => "4111111111111111",
    "expirationMonth" => "12"
  ];
  $card = new CyberSource\Model\Riskv1authenticationsPaymentInformationCard($paymentCardInfo);

  $paymentInfoArr = [
      "card" => $card
  ];
  $payment_information = new CyberSource\Model\Riskv1authenticationsPaymentInformation($paymentInfoArr);

  $buyerInfoArr = [
      "mobilePhone" => "1245789632"
  ];
  $buyer_information = new CyberSource\Model\Riskv1authenticationsBuyerInformation($buyerInfoArr);

  $consumerAuthInfoArr = [
      "transactionMode" => "MOTO"
  ];
  $consumer_authentication_information = new CyberSource\Model\Riskv1authenticationsConsumerAuthenticationInformation($consumerAuthInfoArr);
  
  $checkPayerAuthEnrollmentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "buyerInformation" => $buyer_information,
    "consumerAuthenticationInformation" => $consumer_authentication_information
  ];
  //Creating model
  $checkPayerAuthEnrollmentRequest = new CyberSource\Model\CheckPayerAuthEnrollmentRequest($checkPayerAuthEnrollmentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    //Calling the Api
    $api_response = $api_instance->checkPayerAuthEnrollment($checkPayerAuthEnrollmentRequest);
    
    if($flag =="true" || $flag =="notallow"){
      //Returning the ID
      echo "Fetching ID: ".$api_response[0]['id']."\n";
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
if(!defined('DO_NOT_RUN_SAMPLES')){
  echo "Process PayerAuthEnrollment Samplecode is Running.. \n";
  EnrollWithPendingAuthentication(false);

}
  
?>	
