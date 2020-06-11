<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreatePaymentInstrumentCardEnrollForNetworkToken()
{
	$profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

	$cardArr = [
			"expirationMonth" => "09",
			"expirationYear" => "2017",
			"type" => "visa",
			"issueNumber" => "01",
			"startMonth" => "01",
			"startYear" => "2016"
	];
	$card = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedCard($cardArr);

	$buyerInformationArr = [
			"companyTaxID" => "12345",
			"currency" => "USD"
	];
	$buyerInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBuyerInformation($buyerInformationArr);

	$billToArr = [
			"firstName" => "John",
			"lastName" => "Smith",
			"company" => "Cybersource",
			"address1" => "8310 Capital of Texas Highwas North",
			"address2" => "Bluffstone Drive",
			"locality" => "Austin",
			"administrativeArea" => "TX",
			"postalCode" => "78731",
			"country" => "US",
			"email" => "john.smith@test.com",
			"phoneNumber" => "+44 2890447951"
	];
	$billTo = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBillTo($billToArr);

	$processingInformationArr = [
			"billPaymentProgramEnabled" => true
	];
	$processingInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedProcessingInformation($processingInformationArr);

	$instrumentIdentifierCardArr = [
			"number" => "4622943127013705"
	];
	$instrumentIdentifierCard = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseCard($instrumentIdentifierCardArr);

	$instrumentIdentifierArr = [
			"card" => $instrumentIdentifierCard
	];
	$instrumentIdentifier = new CyberSource\Model\Tmsv1paymentinstrumentsInstrumentIdentifier($instrumentIdentifierArr);

	$requestObjArr = [
			"card" => $card,
			"buyerInformation" => $buyerInformation,
			"billTo" => $billTo,
			"processingInformation" => $processingInformation,
			"instrumentIdentifier" => $instrumentIdentifier
	];
	$requestObj = new CyberSource\Model\CreatePaymentInstrumentRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentInstrumentApi($api_client);

	try {
		$apiResponse = $api_instance->createPaymentInstrument($profileid, $requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nCreatePaymentInstrumentCardEnrollForNetworkToken Sample Code is Running..." . PHP_EOL;
	CreatePaymentInstrumentCardEnrollForNetworkToken();
}
?>
