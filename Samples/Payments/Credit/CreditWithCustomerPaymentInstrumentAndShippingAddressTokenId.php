<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreditWithCustomerPaymentInstrumentAndShippingAddressTokenId()
{
	$clientReferenceInformationArr = [
			"code" => "12345678"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$paymentInformationCustomerArr = [
			"id" => "AB695DA801DD1BB6E05341588E0A3BDC"
	];
	$paymentInformationCustomer = new CyberSource\Model\Ptsv2paymentsPaymentInformationCustomer($paymentInformationCustomerArr);

	$paymentInformationPaymentInstrumentArr = [
			"id" => "AB6A54B982A6FCB6E05341588E0A3935"
	];
	$paymentInformationPaymentInstrument = new CyberSource\Model\Ptsv2paymentsPaymentInformationPaymentInstrument($paymentInformationPaymentInstrumentArr);

	$paymentInformationShippingAddressArr = [
			"id" => "AB6A54B97C00FCB6E05341588E0A3935"
	];
	$paymentInformationShippingAddress = new CyberSource\Model\Ptsv2paymentsPaymentInformationShippingAddress($paymentInformationShippingAddressArr);

	$paymentInformationArr = [
			"customer" => $paymentInformationCustomer,
			"paymentInstrument" => $paymentInformationPaymentInstrument,
			"shippingAddress" => $paymentInformationShippingAddress
	];
	$paymentInformation = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformation($paymentInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "200",
			"currency" => "usd"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"paymentInformation" => $paymentInformation,
			"orderInformation" => $orderInformation
	];
	$requestObj = new CyberSource\Model\CreateCreditRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\CreditApi($api_client);

	try {
		$apiResponse = $api_instance->createCredit($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nCreditWithCustomerPaymentInstrumentAndShippingAddressTokenId Sample Code is Running..." . PHP_EOL;
	CreditWithCustomerPaymentInstrumentAndShippingAddressTokenId();
}
?>
