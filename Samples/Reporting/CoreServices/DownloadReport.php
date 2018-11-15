<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function DownloadReport()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportDownloadsApi($apiclient);
	
	$api_response = list($response,$statusCode,$httpHeader)=null;
	$reportDate="2018-09-02";
	$reportName="testrest_v2";
	try {
		$api_response = $api_instance->downloadReport($reportDate, $reportName, $organizationId = null);
		$downloadData = $api_response[0];
        $filePath = $commonElement->downloadReport($downloadData, "DownloadReport.csv");
		print_r($api_response);
        echo "File has been downloaded in below path: \n".$filePath."\n";

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}	

} 


// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "DownloadReport Samplecode is Running.. \n";
	DownloadReport();

}
?>	
