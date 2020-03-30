<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreatePaymentInstrumentBankAccount()
{
	$profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

	$bankAccountArr = [
		"type" => "savings"
	];
	$bankAccount = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBankAccount($bankAccountArr);

	$buyerInformationPersonalIdentification = array();
	$buyerInformationPersonalIdentificationIssuedBy_0Arr = [
		"administrativeArea" => "CA"
	];
	$buyerInformationPersonalIdentificationIssuedBy_0 = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBuyerInformationIssuedBy($buyerInformationPersonalIdentificationIssuedBy_0Arr);

	$buyerInformationPersonalIdentification_0 = [
		"id" => "57684432111321",
		"type" => "driver license", "issuedBy" => $buyerInformationPersonalIdentificationIssuedBy_0
	];
	$buyerInformationPersonalIdentification[0] = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

	$buyerInformationArr = [
		"companyTaxID" => "12345",
		"currency" => "USD",
		"dateOfBirth" => "2000-12-13",
		"personalIdentification" => $buyerInformationPersonalIdentification
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

	$processingInformationBankTransferOptionsArr = [
		"seCCode" => "WEB"
	];
	$processingInformationBankTransferOptions = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedProcessingInformationBankTransferOptions($processingInformationBankTransferOptionsArr);

	$processingInformationArr = [
		"billPaymentProgramEnabled" => true,
		"bankTransferOptions" => $processingInformationBankTransferOptions
	];
	$processingInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedProcessingInformation($processingInformationArr);

	$merchantInformationMerchantDescriptorArr = [
		"alternateName" => "Branch Name"
	];
	$merchantInformationMerchantDescriptor = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedMerchantInformationMerchantDescriptor($merchantInformationMerchantDescriptorArr);

	$merchantInformationArr = [
		"merchantDescriptor" => $merchantInformationMerchantDescriptor
	];
	$merchantInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedMerchantInformation($merchantInformationArr);

	$instrumentIdentifierBankAccountArr = [
		"number" => "4100",
		"routingNumber" => "071923284"
	];
	$instrumentIdentifierBankAccount = new CyberSource\Model\Tmsv1instrumentidentifiersBankAccount($instrumentIdentifierBankAccountArr);

	$instrumentIdentifierArr = [
		"bankAccount" => $instrumentIdentifierBankAccount
	];
	$instrumentIdentifier = new CyberSource\Model\Tmsv1paymentinstrumentsInstrumentIdentifier($instrumentIdentifierArr);

	$requestObjArr = [
		"bankAccount" => $bankAccount,
		"buyerInformation" => $buyerInformation,
		"billTo" => $billTo,
		"processingInformation" => $processingInformation,
		"merchantInformation" => $merchantInformation,
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
	echo "\nCreatePaymentInstrumentBankAccount Sample Code is Running..." . PHP_EOL;
	CreatePaymentInstrumentBankAccount();
}
?>
