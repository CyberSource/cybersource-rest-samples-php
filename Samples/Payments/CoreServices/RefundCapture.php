<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function RefundCapture()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\RefundApi($apiclient);
  require_once __DIR__. DIRECTORY_SEPARATOR .'CapturePayment.php';
  $id = CapturePayment(true);
	$cliRefInfoArr = [
    "code" => "test_refund_capture"
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);
  $amountDetailsArr = [
      "totalAmount" => "10",
      "currency" => "USD"
  ];
  $amountDetInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($amountDetailsArr);
  
  $orderInfoArry = [
    "amountDetails" => $amountDetInfo
  ];

  $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArry);
  

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information,
    "orderInformation" => $order_information
  ];

  $paymentRequest = new CyberSource\Model\RefundCaptureRequest($paymentRequestArr);
  $requestArr = json_decode($paymentRequest);
  $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  echo "The Api Request Body: \n". $requestBody."\n\n";
 	$api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->refundCapture($paymentRequest, $id);
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
    $resBodyArr= json_decode($api_response[0]);
    echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
    echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
    echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";

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
  echo "[BEGIN] EXECUTION OF SAMPLE CODE:  RefundCapture\n\n";
	RefundCapture();

}

?>	
