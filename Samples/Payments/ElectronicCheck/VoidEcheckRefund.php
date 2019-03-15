<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function VoidEcheckRefund()
{
	$commonElement = new CyberSource\ExternalConfiguration();
  $config = $commonElement->ConnectionHost();
  $apiclient = new CyberSource\ApiClient($config);
  $api_instance = new CyberSource\Api\VoidApi($apiclient);
  require_once __DIR__. DIRECTORY_SEPARATOR .'RefundEcheckPayment.php';
  $id = RefundEcheckPayment(true);
  $cliRefInfoArr = [
    'code' => 'test_refund_void'
  ];
  $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);

  $paymentRequestArr = [
    "clientReferenceInformation" => $client_reference_information
  ];

  $paymentRequest = new CyberSource\Model\VoidRefundRequest($paymentRequestArr);
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->voidRefund($paymentRequest, $id);
    echo "<pre>";print_r($api_response);

  } catch (Cybersource\ApiException $e) {
    print_r($e->getResponseBody());
    print_r($e->getMessage());
  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Void Echeck refund Samplecode is Running.. \n";
    VoidEcheckRefund();

}

?>	
