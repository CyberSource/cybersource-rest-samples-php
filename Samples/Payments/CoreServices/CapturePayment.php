<?php

require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CapturePayment($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\CaptureApi($apiclient);
  require_once __DIR__. DIRECTORY_SEPARATOR .'ProcessPayment.php';
  $id = ProcessPayment("true");
	$cliRefInfoArr = [
    "code" => "test_capture"
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);
  $amountDetailsArr = [
      "totalAmount" => "102.21",
      "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($amountDetailsArr);

  $orderInfoArry = [
    "amountDetails" => $amountDetInfo
  ];

  $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArry);
  $requestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information
  ];
  //Creating model
  $request = new CyberSource\Model\CapturePaymentRequest($requestArr);
  $requestArr = json_decode($request);
  $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  echo "The Request Payload : \n".$requestBody."\n\n";
  
 	$api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->capturePayment($request, $id);
    
    if($flag == true){
      //Returning the ID
		  echo "Fetching Capture ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }else{
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
  echo "[BEGIN] EXECUTION OF SAMPLE CODE: CapturePayment  \n\n";
  CapturePayment(false);

}


?>	
