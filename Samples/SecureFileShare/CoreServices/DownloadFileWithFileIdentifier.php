<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function DownloadFileWithFileIdentifier()
{
    $commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();
    $apiclient = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\SecureFileShareApi($apiclient);
    $fileId = "dGVzdHJlc3Rfc3ViY3JpcHRpb25fdjI5ODktYTM3ZmI2ZjUtM2QzYi0wOGVhLWUwNTMtYTI1ODhlMGFkOTJjLnhtbC0yMDIwLTA0LTMw";

    $api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->getFile($fileId, $organizationId = "testrest");
        $downloadData = $api_response[0];
        $filePath = $commonElement->downloadReport($downloadData, "DownloadFileWithFileIdentifier.csv");
		print_r($api_response);
        echo "File has been downloaded in the location: \n".$filePath."\n";


	} catch (Cybersource\ApiException $e) {
		print_r($e);
        print_r($e->getMessage());
    }
}

    // Call Sample Code
    if(!defined('DO_NOT_RUN_SAMPLES')){
         echo "DownloadFileWithFileIdentifier Samplecode is Running.. \n";
         DownloadFileWithFileIdentifier();
    }

?>