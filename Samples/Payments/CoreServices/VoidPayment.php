<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function VoidPayment()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\VoidApi($apiclient);
  require_once __DIR__. DIRECTORY_SEPARATOR .'ProcessPayment.php';
  $id = ProcessPayment("true");
	$cliRefInfoArr = [
    'code' => 'test_void'
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information
  ];

  $paymentRequest = new CyberSource\Model\VoidPaymentRequest($paymentRequestArr);
  $requestArr = json_decode($paymentRequest);
  $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  echo "The Api Request Body: \n". $requestBody."\n\n";
 	$api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->voidPayment($paymentRequest, $id);
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
  echo "[BEGIN] EXECUTION OF SAMPLE CODE:  VoidPayment\n\n";
	VoidPayment();

}

?>	
