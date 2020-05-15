<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function RestaurantAuthorization()
{
	$clientReferenceInformationPartnerArr = [
			"thirdPartyCertificationNumber" => "123456789012"
	];
	$clientReferenceInformationPartner = new CyberSource\Model\Ptsv2paymentsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

	$clientReferenceInformationArr = [
			"code" => "demomerchant",
			"partner" => $clientReferenceInformationPartner
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$processingInformationAuthorizationOptionsArr = [
			"partialAuthIndicator" => true,
			"ignoreAvsResult" => false,
			"ignoreCvResult" => false
	];
	$processingInformationAuthorizationOptions = new CyberSource\Model\Ptsv2paymentsProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

	$processingInformationArr = [
			"capture" => false,
			"commerceIndicator" => "retail",
			"authorizationOptions" => $processingInformationAuthorizationOptions
	];
	$processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "100.00",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

	$pointOfSaleInformationArr = [
			"entryMode" => "swiped",
			"terminalCapability" => 2,
			"trackData" => "%B38000000000006^TEST/CYBS         ^2012121019761100      00868000000?"
	];
	$pointOfSaleInformation = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"processingInformation" => $processingInformation,
			"orderInformation" => $orderInformation,
			"pointOfSaleInformation" => $pointOfSaleInformation
	];
	$requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentsApi($api_client);

	try {
		$apiResponse = $api_instance->createPayment($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nRestaurantAuthorization Sample Code is Running..." . PHP_EOL;
	RestaurantAuthorization();
}
?>
