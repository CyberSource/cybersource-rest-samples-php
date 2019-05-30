<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function VoidEcheckCredit()
{
  $commonElement = new CyberSource\ExternalConfiguration();
  $config = $commonElement->ConnectionHost();
  
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
  $api_instance = new CyberSource\Api\VoidApi($apiclient);
  
  require_once __DIR__. DIRECTORY_SEPARATOR .'../ElectronicCheck/ProcessEcheckCredit.php';
  $id = ProcessEcheckCredit(true);
  
  $clientRefInfoArr = [
    'code' => 'test_void'
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientRefInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information
  ];

  $paymentRequest = new CyberSource\Model\VoidCreditRequest($paymentRequestArr);
  
  $api_response = list($response,$statusCode,$httpHeader) = null;
  
  try {
    $api_response = $api_instance->voidCredit($paymentRequest, $id);
	
	print_r($api_response);
  } 
  catch (Cybersource\ApiException $e) {
    print_r($e->getResponseBody());
    print_r($e->getMessage());
  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Void EcheckCredit Sample code is Running.. \n";
    VoidEcheckCredit();
}
?>	
