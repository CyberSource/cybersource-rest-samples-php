<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateAdhocReport()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReportsApi($apiclient);
	$createReportRequestArr =[
		"reportDefinitionName"=> "TransactionRequestClass",
		"timezone"=> "GMT",
		"reportMimeType"=> "text/csv",
		"reportName"=> "testrest_v57",
		"reportStartTime"=> "2019-01-02T12:00:00+05:00",
		"reportEndTime"=> "2019-01-03T12:00:00+05:00",
		"reportPreferences"=> ["signedAmounts"=>"true","fieldNameConvention"=>"SOAPI"],
		"reportFields"=>["Request.RequestID","Request.TransactionDate","Request.MerchantID"]
	];
	  
	  
	$reportRequest = new CyberSource\Model\CreateAdhocReportRequest($createReportRequestArr);
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->createReport($reportRequest);
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
		print_r($e->getresponseBody());
    	print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "CreateAdhocReport Samplecode is Running.. \n";
	CreateAdhocReport();

}
?>	
