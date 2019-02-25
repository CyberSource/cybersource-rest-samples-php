<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateSearchRequest()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\SearchTransactionsApi($apiclient);
	$createSearchRequestArr = [
		"save"=> "false",
		"name"=> "TSS search",
		"timezone"=> "America/Chicago",
		"query"=> "clientReferenceInformation.code:12345",
		"offset"=> 0,
		"limit"=> 100,
		"sort"=> "id:asc, submitTimeUtc:asc"
	];
	$createSearchRequest = new CyberSource\Model\TssV2TransactionsPostResponse($createSearchRequestArr);
  	$requestArr = json_decode($createSearchRequest);
    $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  	echo "The Request Payload : \n".$requestBody."\n\n";
	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		
		$api_response = $api_instance->createSearch($createSearchRequest);
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
		echo "The Api Response Body: \n"; print_r($api_response[0]);echo "\n\n";
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
    echo "[BEGIN] EXECUTION OF SAMPLE CODE: CreateSearchRequest  \n\n";
	CreateSearchRequest();

}
?>	
