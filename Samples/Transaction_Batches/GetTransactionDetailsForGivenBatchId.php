<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetTransactionDetailsForGivenBatchId($id)
{

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\TransactionBatchesApi($api_client);

	try {
		$apiResponse = $api_instance->getTransactionBatchDetails($id);
		$downloadData = $apiResponse[0];
		$file_extension = substr($apiResponse[2]["Content-Type"], -3, 3);
		$filePath = $commonElement->downloadReport($downloadData, "BatchDetailsReport." . $file_extension);
		print_r(PHP_EOL);
		print_r($apiResponse);
		echo "Response downloaded in the location: \n" . $filePath . "\n";
		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetTransactionDetailsForGivenBatchId Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing path parameter <id>: ";
	$id = trim(fgets(STDIN));
	GetTransactionDetailsForGivenBatchId($id);
}
?>
