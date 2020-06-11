<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/AuthorizationForTimeoutReversalFlow.php';

function TimeoutReversal()
{
	$clientReferenceInformationArr = [
			"code" => "TC50171_3",
			"transactionId" => "313461984879"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$reversalInformationAmountDetailsArr = [
			"totalAmount" => "102.21"
	];
	$reversalInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($reversalInformationAmountDetailsArr);

	$reversalInformationArr = [
			"amountDetails" => $reversalInformationAmountDetails,
			"reason" => "testing"
	];
	$reversalInformation = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformation($reversalInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"reversalInformation" => $reversalInformation
	];
	$requestObj = new CyberSource\Model\MitReversalRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\ReversalApi($api_client);

	try {
		$apiResponse = $api_instance->mitReversal($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nTimeoutReversal Sample Code is Running..." . PHP_EOL;
	TimeoutReversal();
}
?>
