<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function PinDebitCreditUsingEMVTechnologyWithContactlessReadWithVisaPlatformConnect()
{
	$clientReferenceInformationArr = [
			"code" => "2.2 Credit"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$processingInformationArr = [
			"commerceIndicator" => "retail"
	];
	$processingInformation = new CyberSource\Model\Ptsv2creditsProcessingInformation($processingInformationArr);

	$paymentInformationPaymentTypeArr = [
			"name" => "CARD",
			"subTypeName" => "DEBIT"
	];
	$paymentInformationPaymentType = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

	$paymentInformationArr = [
			"paymentType" => $paymentInformationPaymentType
	];
	$paymentInformation = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformation($paymentInformationArr);

	$orderInformationAmountDetailsArr = [
			"totalAmount" => "202.00",
			"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

	$merchantInformationArr = [
	];
	$merchantInformation = new CyberSource\Model\Ptsv2paymentsidrefundsMerchantInformation($merchantInformationArr);

	$pointOfSaleInformationEmvArr = [
			"tags" => "9F3303204000950500000000009F3704518823719F100706011103A000009F26081E1756ED0E2134E29F36020015820200009C01009F1A0208409A030006219F02060000000020005F2A0208409F0306000000000000",
			"cardSequenceNumber" => "1",
			"fallback" => false
	];
	$pointOfSaleInformationEmv = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformationEmv($pointOfSaleInformationEmvArr);

	$pointOfSaleInformationArr = [
			"entryMode" => "contactless",
			"terminalCapability" => 4,
			"emv" => $pointOfSaleInformationEmv,
			"trackData" => "%B4111111111111111^JONES/JONES ^3112101976110000868000000?;4111111111111111=16121019761186800000?"
	];
	$pointOfSaleInformation = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"processingInformation" => $processingInformation,
			"paymentInformation" => $paymentInformation,
			"orderInformation" => $orderInformation,
			"merchantInformation" => $merchantInformation,
			"pointOfSaleInformation" => $pointOfSaleInformation
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

		WriteLogAudit($apiResponse[1]);
		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
		WriteLogAudit($errorCode);
	}
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nPinDebitCreditUsingEMVTechnologyWithContactlessReadWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
	PinDebitCreditUsingEMVTechnologyWithContactlessReadWithVisaPlatformConnect();
}
?>
