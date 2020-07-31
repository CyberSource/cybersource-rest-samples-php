<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function DMWithMerchantDefinedInformation()
{
	$clientReferenceInformationArr = [
			"code" => "54323007"
	];
	$clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

	$paymentInformationCardArr = [
			"number" => "4444444444444448",
			"expirationMonth" => "12",
			"expirationYear" => "2020"
	];
	$paymentInformationCard = new CyberSource\Model\Riskv1decisionsPaymentInformationCard($paymentInformationCardArr);

	$paymentInformationArr = [
			"card" => $paymentInformationCard
	];
	$paymentInformation = new CyberSource\Model\Riskv1decisionsPaymentInformation($paymentInformationArr);

	$orderInformationAmountDetailsArr = [
			"currency" => "USD",
			"totalAmount" => "144.14"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Riskv1decisionsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationBillToArr = [
			"address1" => "96, powers street",
			"administrativeArea" => "NH",
			"country" => "US",
			"locality" => "Clearwater milford",
			"firstName" => "James",
			"lastName" => "Smith",
			"phoneNumber" => "7606160717",
			"email" => "test@visa.com",
			"postalCode" => "03055"
	];
	$orderInformationBillTo = new CyberSource\Model\Riskv1decisionsOrderInformationBillTo($orderInformationBillToArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails,
			"billTo" => $orderInformationBillTo
	];
	$orderInformation = new CyberSource\Model\Riskv1decisionsOrderInformation($orderInformationArr);

	$merchantDefinedInformation = array();
	$merchantDefinedInformation_0 = [
			"key" => "1",
			"value" => "Test"
	];
	$merchantDefinedInformation[0] = new CyberSource\Model\Riskv1decisionsMerchantDefinedInformation($merchantDefinedInformation_0);

	$merchantDefinedInformation_1 = [
			"key" => "2",
			"value" => "Test2"
	];
	$merchantDefinedInformation[1] = new CyberSource\Model\Riskv1decisionsMerchantDefinedInformation($merchantDefinedInformation_1);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"paymentInformation" => $paymentInformation,
			"orderInformation" => $orderInformation,
			"merchantDefinedInformation" => $merchantDefinedInformation
	];
	$requestObj = new CyberSource\Model\CreateBundledDecisionManagerCaseRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\DecisionManagerApi($api_client);

	try {
		$apiResponse = $api_instance->createBundledDecisionManagerCase($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nDMWithMerchantDefinedInformation Sample Code is Running..." . PHP_EOL;
	DMWithMerchantDefinedInformation();
}
?>
