<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function ValidateAuthenticationResults()
{
	$clientReferenceInformationArr = [
			"code" => "pavalidatecheck"
	];
	$clientReferenceInformation = new CyberSource\Model\Riskv1authenticationsetupsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationAmountDetailsArr = [
			"currency" => "USD",
			"totalAmount" => "200.00"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationLineItems = array();
	$orderInformationLineItems_0 = [
			"unitPrice" => "10",
			"quantity" => 2,
			"taxAmount" => "32.40"
	];
	$orderInformationLineItems[0] = new CyberSource\Model\Riskv1authenticationresultsOrderInformationLineItems($orderInformationLineItems_0);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails,
			"lineItems" => $orderInformationLineItems
	];
	$orderInformation = new CyberSource\Model\Riskv1authenticationresultsOrderInformation($orderInformationArr);

	$paymentInformationCardArr = [
			"type" => "002",
			"expirationMonth" => "12",
			"expirationYear" => "2025",
			"number" => "5200000000000007"
	];
	$paymentInformationCard = new CyberSource\Model\Riskv1authenticationresultsPaymentInformationCard($paymentInformationCardArr);

	$paymentInformationArr = [
			"card" => $paymentInformationCard
	];
	$paymentInformation = new CyberSource\Model\Riskv1authenticationresultsPaymentInformation($paymentInformationArr);

	$consumerAuthenticationInformationArr = [
			"authenticationTransactionId" => "PYffv9G3sa1e0CQr5fV0",
			"responseAccessToken" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI5YTAwYTYzMC0zNzFhLTExZTYtYTU5Ni1kZjQwZjUwMjAwNmMiLCJpYXQiOjE0NjY0NDk4MDcsImlzcyI6Ik1pZGFzLU5vRFYtS2V5IiwiUGF5bG9hZCI6eyJPcmRlckRldGFpbHMiOnsiT3JkZXJOdW1iZXIiOjE1NTc4MjAyMzY3LCJBbW91bnQiOiIxNTAwIiwiQ3VycmVudENvZGUiOiI4NDAiLCJUcmFuc2FjdGlvbklkIjoiOVVzaGVoRFFUcWh1SFk5SElqZTAifX0sIk9yZ1VuaXRJZCI6IjU2NGNkY2JjYjlmNjNmMGM0OGQ2Mzg3ZiIsIk9iamVjdGlmeVBheWxvYWQiOnRydWV9.eaU8LZJnMtY3mPl4vBXVCVUuyeSeAp8zoNaEOmKS4XY",
			"signedPares" => "eNqdmFmT4jgSgN+J4D90zD4yMz45PEFVhHzgA2zwjXnzhQ984Nvw61dAV1"
	];
	$consumerAuthenticationInformation = new CyberSource\Model\Riskv1authenticationresultsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation,
			"paymentInformation" => $paymentInformation,
			"consumerAuthenticationInformation" => $consumerAuthenticationInformation
	];
	$requestObj = new CyberSource\Model\ValidateRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

	try {
		$apiResponse = $api_instance->validateAuthenticationResults($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nValidateAuthenticationResults Sample Code is Running..." . PHP_EOL;
	ValidateAuthenticationResults();
}
?>
