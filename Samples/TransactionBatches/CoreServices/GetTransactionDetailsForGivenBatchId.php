<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function GetTransactionDetailsForGivenBatchId()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiClient = new CyberSource\ApiClient($config, $merchantConfig);
	$apiInstance = new CyberSource\Api\TransactionBatchesApi($apiClient);

	$id = "12345";
	
	try {
		$apiResponse = $apiInstance->getTransactionBatchDetails( $id );
		$downloadData = $apiResponse[0];
		$file_extension = substr($apiResponse[2]["Content-Type"], -3, 3);
        $filePath = $commonElement->downloadReport($downloadData, "BatchDetailsReport." . $file_extension);
		print_r($apiResponse);
		echo "Batch Details has been downloaded in the location: \n".$filePath."\n";
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}
if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "GetTransactionDetailsForGivenBatchId Samplecode is Running.. \n";
	GetTransactionDetailsForGivenBatchId();
}
?>
