<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateAdhocReport()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportsApi($apiclient);
	$createReportRequestArr =[
		"reportDefinitionName"=> "TransactionRequestClass",
		"timezone"=> "GMT",
		"reportMimeType"=> "text/csv",
		"reportName"=> "testrest_v57",
		"reportStartTime"=> "2018-09-02T12:00:00+05:00",
		"reportEndTime"=> "2018-09-03T12:00:00+05:00",
		"reportPreferences"=> ["signedAmounts"=>"true","fieldNameConvention"=>"SOAPI"],
		"reportFields"=>["Request.RequestID","Request.TransactionDate","Request.MerchantID"]
	];
	  
	  
	$reportRequest = new CyberSource\Model\RequestBody1($createReportRequestArr);
	$requestArr = json_decode($reportRequest);
  	$requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  	echo "The Request Payload : \n".$requestBody."\n\n";
	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		
		$api_response = $api_instance->createReport($reportRequest);
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
		$resBodyArr= json_decode($api_response[0]);
		echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
	    echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
	    echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";

	} catch (Exception $e) {
		
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
    echo "[BEGIN] EXECUTION OF SAMPLE CODE: CreateAdhocReport  \n\n";
	CreateAdhocReport();

}
?>	
