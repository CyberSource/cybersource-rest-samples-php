<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/SimpleAuthorizationInternet.php';

function RefundPayment()
{
	$id = SimpleAuthorizationInternet("true")[0]['id'];

	$clientReferenceInformationArr = [
			"code" => "TC50171_3"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "10",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation
	];
	$requestObj = new CyberSource\Model\RefundPaymentRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\RefundApi($api_client);

	try {
		$apiResponse = $api_instance->refundPayment($requestObj, $id);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nRefundPayment Sample Code is Running..." . PHP_EOL;
	RefundPayment();
}
?>
