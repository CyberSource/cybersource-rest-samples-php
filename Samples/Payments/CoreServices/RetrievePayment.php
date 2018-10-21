<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function RetrievePayment()
{
	$commonElement = new CyberSource\ExternalConfig();
  $config = $commonElement->ConnectionHost();
  $apiclient = new CyberSource\ApiClient($config);
  $api_instance = new CyberSource\Api\PaymentApi($apiclient);
  $id = '5395968926396448503003';
  $api_response = list($response,$statusCode,$httpHeader)=null;
  try {
    $api_response = $api_instance->getPayment($id);
    echo "<pre>";print_r($api_response);

  } catch (Exception $e) {
    print_r($e->getmessage());
  }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	RetrievePayment();

}

?>	
