<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetListOfFiles()
{
    $commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
    $apiclient = new CyberSource\ApiClient($config);
    $api_instance = new CyberSource\Api\SecureFileShareApi($apiclient);
    $startDate = "2018-10-20";
    $endDate = "2018-10-30";


    $api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getFileDetails($startDate, $endDate, $organizationId = "testrest");
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
        print_r($e->getMessage());
    }
}
    // Call Sample Code
    if(!defined('DO_NOT_RUN_SAMPLES')){
         echo "GetListOfFiles Samplecode is Running.. \n";
         GetListOfFiles();
    }

?>