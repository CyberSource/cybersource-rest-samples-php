<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function ValidateAuthenticationResults($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($apiclient);
	$cliRefInfoArr = [
    "code" => "pavalidatecheck"
  ];
  $client_reference_information = new CyberSource\Model\Riskv1authenticationsClientReferenceInformation($cliRefInfoArr);
  
  $amountDetailsArr = [
    "totalAmount" => "200.00",
    "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\Riskv1decisionsOrderInformationAmountDetails($amountDetailsArr);

  $lineItemsArr = [
      "unitPrice" => "10",
      "quantity" => "2",
      "taxAmount" => "32.40"
  ];
  $line_items = new CyberSource\Model\Riskv1authenticationresultsOrderInformationLineItems($lineItemsArr);

  $orderInfoArry = [
    "amountDetails" => $amountDetInfo,
    "lineItems" => $line_items
  ];
  $order_information = new CyberSource\Model\Riskv1authenticationresultsOrderInformation($orderInfoArry);

  $paymentCardInfo = [
    "expirationYear" => "2025",
    "number" => "5200000000000007",
    "expirationMonth" => "12"
  ];
  $card = new CyberSource\Model\Riskv1authenticationresultsPaymentInformationCard($paymentCardInfo);

  $paymentInfoArr = [
      "card" => $card
  ];
  $payment_information = new CyberSource\Model\Riskv1authenticationsPaymentInformation($paymentInfoArr);
  
  $consumerAuthArr = [
      "authenticationTransactionId" => "PYffv9G3sa1e0CQr5fV0",
      "signedPares" => "eNqdmFmT4jgSgN+J4D90zD4yMz45PEFVhHzgA2zwjXnzhQ984Nvw61dAV1"
  ];
  $consumer_authentication_information = new CyberSource\Model\Riskv1authenticationresultsConsumerAuthenticationInformation($consumerAuthArr);
  
  $validateAuthenticationResultsRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "consumerAuthenticationInformation" => $consumer_authentication_information
  ];
  
  //Creating model
  $validateAuthenticationResultsRequest = new CyberSource\Model\Request($validateAuthenticationResultsRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    //Calling the Api
    $api_response = $api_instance->validateAuthenticationResults($validateAuthenticationResultsRequest);
    
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
  echo "Process ValidateAuthenticationResults Samplecode is Running.. \n";
  ValidateAuthenticationResults(false);
}
?>	
