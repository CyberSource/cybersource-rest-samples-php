<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function PayoutToken()
{
	$clientReferenceInformationArr = [
			"code" => "111111113"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2payoutsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "111.00",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2payoutsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2payoutsOrderInformation($orderInformationArr);

	$merchantInformationMerchantDescriptorArr = [
			"name" => "Sending Company Name",
			"locality" => "FC",
			"country" => "US",
			"administrativeArea" => "CA",
			"postalCode" => "94440"
	];
	$merchantInformationMerchantDescriptor = new CyberSource\Model\Ptsv2payoutsMerchantInformationMerchantDescriptor($merchantInformationMerchantDescriptorArr);

	$merchantInformationArr = [
			"merchantDescriptor" => $merchantInformationMerchantDescriptor
	];
	$merchantInformation = new CyberSource\Model\Ptsv2payoutsMerchantInformation($merchantInformationArr);

	$recipientInformationArr = [
			"firstName" => "John",
			"lastName" => "Doe",
			"address1" => "Paseo Padre Boulevard",
			"locality" => "Foster City",
			"administrativeArea" => "CA",
			"country" => "US",
			"postalCode" => "94400",
			"phoneNumber" => "6504320556"
	];
	$recipientInformation = new CyberSource\Model\Ptsv2payoutsRecipientInformation($recipientInformationArr);

	$senderInformationAccountArr = [
			"fundsSource" => "05",
			"number" => "1234567890123456789012345678901234"
	];
	$senderInformationAccount = new CyberSource\Model\Ptsv2payoutsSenderInformationAccount($senderInformationAccountArr);

	$senderInformationArr = [
			"referenceNumber" => "1234567890",
			"account" => $senderInformationAccount,
			"name" => "Company Name",
			"address1" => "900 Metro Center Blvd.900",
			"locality" => "Foster City",
			"administrativeArea" => "CA",
			"countryCode" => "US"
	];
	$senderInformation = new CyberSource\Model\Ptsv2payoutsSenderInformation($senderInformationArr);

	$processingInformationArr = [
			"businessApplicationId" => "FD",
			"networkRoutingOrder" => "V8",
			"commerceIndicator" => "internet"
	];
	$processingInformation = new CyberSource\Model\Ptsv2payoutsProcessingInformation($processingInformationArr);

	$paymentInformationCustomerArr = [
			"customerId" => "7500BB199B4270EFE05340588D0AFCAD"
	];
	$paymentInformationCustomer = new CyberSource\Model\Ptsv2paymentsPaymentInformationCustomer($paymentInformationCustomerArr);

	$paymentInformationArr = [
			"customer" => $paymentInformationCustomer
	];
	$paymentInformation = new CyberSource\Model\Ptsv2payoutsPaymentInformation($paymentInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation,
			"merchantInformation" => $merchantInformation,
			"recipientInformation" => $recipientInformation,
			"senderInformation" => $senderInformation,
			"processingInformation" => $processingInformation,
			"paymentInformation" => $paymentInformation
	];
	$requestObj = new CyberSource\Model\OctCreatePaymentRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayoutsApi($api_client);

	try {
		$apiResponse = $api_instance->octCreatePayment($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nPayoutToken Sample Code is Running..." . PHP_EOL;
	PayoutToken();
}
?>
