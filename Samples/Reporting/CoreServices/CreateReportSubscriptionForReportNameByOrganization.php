<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateReportSubscriptionForReportNameByOrganization()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportSubscriptionsApi($apiclient);
	
  	$createReportRequestArr = [
		'reportDefinitionName' => 'TransactionRequestClass',
        'reportFields' => ["Request.RequestID",
                    "Request.TransactionDate",
                    "Request.MerchantID"],
        'reportMimeType' => 'application/xml',
        'reportFrequency' => 'WEEKLY',
        'reportName' => 'testrestsa_subcription_v1',
        'timezone' => 'GMT',
        'startTime' => '0901',
        'startDay' => "3"      
	];
	$reportRequest = new CyberSource\Model\RequestBody($createReportRequestArr);
	$requestArr = json_decode($reportRequest);
  	$requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  	echo "The Request Payload : \n".$requestBody."\n\n";
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		
		$api_response = $api_instance->createSubscription(null,$reportRequest);
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
    echo "[BEGIN] EXECUTION OF SAMPLE CODE: CreateReportSubscriptionForReportNameByOrganization  \n\n";
	CreateReportSubscriptionForReportNameByOrganization();

}
?>	
