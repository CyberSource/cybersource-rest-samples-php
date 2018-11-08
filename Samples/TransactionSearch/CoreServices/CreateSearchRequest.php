<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

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
  
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->createSearch($createSearchRequest);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "CreateSearchRequest Samplecode is Running.. \n";
	CreateSearchRequest();

}
?>	
