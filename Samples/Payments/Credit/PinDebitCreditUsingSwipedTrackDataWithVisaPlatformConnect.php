<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function PinDebitCreditUsingSwipedTrackDataWithVisaPlatformConnect()
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

	$pointOfSaleInformationArr = [
			"entryMode" => "swiped",
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
	echo "\nPinDebitCreditUsingSwipedTrackDataWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
	PinDebitCreditUsingSwipedTrackDataWithVisaPlatformConnect();
}
?>
