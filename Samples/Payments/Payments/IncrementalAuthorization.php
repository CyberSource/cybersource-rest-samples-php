<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './AuthorizationForIncrementalAuthorizationFlow.php';

function IncrementalAuthorization()
{
	$id = AuthorizationForIncrementalAuthorizationFlow()[0]['id'];

	$clientReferenceInformationPartnerArr = [
			"originalTransactionId" => "12345",
			"developerId" => "12345",
			"solutionId" => "12345"
	];
	$clientReferenceInformationPartner = new CyberSource\Model\Ptsv2paymentsidClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

	$clientReferenceInformationArr = [
			"partner" => $clientReferenceInformationPartner
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidClientReferenceInformation($clientReferenceInformationArr);

	$processingInformationAuthorizationOptionsInitiatorArr = [
			"storedCredentialUsed" => true
	];
	$processingInformationAuthorizationOptionsInitiator = new CyberSource\Model\Ptsv2paymentsidProcessingInformationAuthorizationOptionsInitiator($processingInformationAuthorizationOptionsInitiatorArr);

	$processingInformationAuthorizationOptionsArr = [
			"initiator" => $processingInformationAuthorizationOptionsInitiator
	];
	$processingInformationAuthorizationOptions = new CyberSource\Model\Ptsv2paymentsidProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

	$processingInformationArr = [
			"authorizationOptions" => $processingInformationAuthorizationOptions
	];
	$processingInformation = new CyberSource\Model\Ptsv2paymentsidProcessingInformation($processingInformationArr);

	$orderInformationAmountDetailsArr = [
			"additionalAmount" => "100",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsidOrderInformation($orderInformationArr);

	$merchantInformationArr = [
	];
	$merchantInformation = new CyberSource\Model\Ptsv2paymentsidMerchantInformation($merchantInformationArr);

	$travelInformationArr = [
			"duration" => "3"
	];
	$travelInformation = new CyberSource\Model\Ptsv2paymentsidTravelInformation($travelInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"processingInformation" => $processingInformation,
			"orderInformation" => $orderInformation,
			"merchantInformation" => $merchantInformation,
			"travelInformation" => $travelInformation
	];
	$requestObj = new CyberSource\Model\IncrementAuthRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentsApi($api_client);

	try {
		$apiResponse = $api_instance->incrementAuth($id, $requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nIncrementalAuthorization Sample Code is Running..." . PHP_EOL;
	IncrementalAuthorization();
}
?>
