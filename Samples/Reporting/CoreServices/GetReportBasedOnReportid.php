<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function GetReportBasedOnReportid()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportsApi($apiclient);
	$reportId = "79642c43-2368-0cd5-e053-a2588e0a7b3c";
	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getReportByReportId($reportId);
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
    echo "[BEGIN] EXECUTION OF SAMPLE CODE: GetReportBasedOnReportid  \n\n";
	GetReportBasedOnReportid();

}
?>	
