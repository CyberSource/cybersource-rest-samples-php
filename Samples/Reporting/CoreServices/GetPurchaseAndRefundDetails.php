<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetPurchaseAndRefundDetails()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PurchaseAndRefundDetailsApi($apiclient);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$startTime="2018-05-01T12:00:00-05:00";
	$endTime="2018-05-30T12:00:00-05:00";

	try {
		$api_response = $api_instance->getPurchaseAndRefundDetails($startTime, $endTime, $organizationId = null, $paymentSubtype = 'ALL', $viewBy = 'requestDate', $groupName = null, $offset = null, $limit = '2000');
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    	print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "GetPurchaseAndRefundDetails Samplecode is Running.. \n";
	GetPurchaseAndRefundDetails();

}
?>	
