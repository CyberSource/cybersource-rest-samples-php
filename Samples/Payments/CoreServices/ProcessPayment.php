<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function ProcessPayment($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentsApi($apiclient);
	$cliRefInfoArr = [
    "code" => "test_payment"
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);
  if($flag == "true"){
   $processingInformationArr = [
     "capture" => true,
     "commerceIndicator" => "internet"
    ];
  }else{
   $processingInformationArr = [
      "commerceIndicator" => "internet"
   ];
  }
  
  $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

  $amountDetailsArr = [
    "totalAmount" => "102.21",
    "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($amountDetailsArr);
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
  $billto = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($billtoArr);
  $orderInfoArry = [
    "amountDetails" => $amountDetInfo,
    "billTo" => $billto
  ];

  $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArry);
  $paymentCardInfo = [
    "expirationYear" => "2031",
    "number" => "4111111111111111",
    "securityCode" => "123",
    "expirationMonth" => "12"
  ];
  $card = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentCardInfo);
  $paymentInfoArr = [
      "card" => $card
      
  ];
  $payment_information = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInfoArr);
  
  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information,
    "paymentInformation" => $payment_information,
    "processingInformation" => $processingInformation
  ];
  //Creating model
  $paymentRequest = new CyberSource\Model\CreatePaymentRequest($paymentRequestArr);
  $requestArr = json_decode($paymentRequest);
  $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  echo "The Api Request Body: \n". $requestBody."\n\n";
 	$api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    //Calling the Api
    $api_response = $api_instance->createPayment($paymentRequest);
    if($flag =="true" || $flag =="notallow"){
      //Returning the ID
      echo "Fetching Payment ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }
    else {
      echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
      $resBodyArr= json_decode($api_response[0]);
      echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
      echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
      echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";
    }

	} catch (Cybersource\ApiException $e) {
    echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
    echo "The Exception Response Body: \n";
		print_r($e->getResponseBody()); echo "\n\n";
    echo "The Exception Response Header: \n";
    print_r($e->getResponseHeaders()); echo "\n\n";
    echo "The Exception Response Header: \n";
    print_r($e->getMessage());echo "\n\n";
	}
}


// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
  echo "[BEGIN] EXECUTION OF SAMPLE CODE:  ProcessPayment\n\n";
  ProcessPayment("false");

}
  
?>	
