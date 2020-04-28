<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetListOfFiles()
{
    $commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SecureFileShareApi($apiclient);
    $startDate = "2020-03-20";
    $endDate = "2020-03-30";


    $api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getFileDetail($startDate, $endDate, $organizationId = "testrest");
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