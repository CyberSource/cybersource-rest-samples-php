<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function DownloadReport()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\ReportDownloadsApi($apiclient);	
	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	$reportDate="2018-09-02";
	$reportName="testrest v2";
	try {
		$api_response = $api_instance->downloadReport($reportDate, $reportName, $organizationId = null);
		$downloadData = $api_response[0];
        $filePath = $commonElement->downloadReport($downloadData, "DownloadReport.xml");
		echo "The Api Response Body: \n";
		print_r($downloadData);echo "\n\n";
	    echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
	    echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";
        echo "File has been downloaded in the location: \n".$filePath."\n";

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
    echo "[BEGIN] EXECUTION OF SAMPLE CODE: DownloadReport  \n\n";
	DownloadReport();

}
?>	
