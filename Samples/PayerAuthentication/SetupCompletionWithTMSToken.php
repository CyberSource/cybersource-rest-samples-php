<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithTMSToken()
{
	$clientReferenceInformationArr = [
			"code" => "cybs_test"
	];
	$clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

	$paymentInformationCustomerArr = [
			"customerId" => "AB695DA801DD1BB6E05341588E0A3BDC"
	];
	$paymentInformationCustomer = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformationCustomer($paymentInformationCustomerArr);

	$paymentInformationArr = [
			"customer" => $paymentInformationCustomer
	];
	$paymentInformation = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformation($paymentInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"paymentInformation" => $paymentInformation
	];
	$requestObj = new CyberSource\Model\PayerAuthSetupRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

	try {
		$apiResponse = $api_instance->payerAuthSetup($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nSetupCompletionWithTMSToken Sample Code is Running..." . PHP_EOL;
	SetupCompletionWithTMSToken();
}
?>
