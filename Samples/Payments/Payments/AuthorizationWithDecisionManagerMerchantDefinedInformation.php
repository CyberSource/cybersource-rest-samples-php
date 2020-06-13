<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithDecisionManagerMerchantDefinedInformation()
{
	$clientReferenceInformationArr = [
			"code" => "54323007"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$paymentInformationCardArr = [
			"number" => "4444444444444448",
			"expirationMonth" => "12",
			"expirationYear" => "2020"
	];
	$paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

	$paymentInformationArr = [
			"card" => $paymentInformationCard
	];
	$paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "144.14",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationBillToArr = [
			"firstName" => "James",
			"lastName" => "Smith",
			"address1" => "96, powers street",
			"locality" => "Clearwater milford",
			"administrativeArea" => "NH",
			"postalCode" => "03055",
			"country" => "US",
			"email" => "test@visa.com",
			"phoneNumber" => "7606160717"
	];
	$orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails,
			"billTo" => $orderInformationBillTo
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

	$merchantDefinedInformation = array();
	$merchantDefinedInformation_0 = [
			"key" => "1",
			"value" => "Test"
	];
	$merchantDefinedInformation[0] = new CyberSource\Model\Ptsv2paymentsMerchantDefinedInformation($merchantDefinedInformation_0);

	$merchantDefinedInformation_1 = [
			"key" => "2",
			"value" => "Test2"
	];
	$merchantDefinedInformation[1] = new CyberSource\Model\Ptsv2paymentsMerchantDefinedInformation($merchantDefinedInformation_1);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"paymentInformation" => $paymentInformation,
			"orderInformation" => $orderInformation,
			"merchantDefinedInformation" => $merchantDefinedInformation
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
	echo "\nAuthorizationWithDecisionManagerMerchantDefinedInformation Sample Code is Running..." . PHP_EOL;
	AuthorizationWithDecisionManagerMerchantDefinedInformation();
}
?>
