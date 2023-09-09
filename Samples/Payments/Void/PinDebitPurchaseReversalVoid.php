<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/PinDebitPurchaseUsingSwipedTrackDataWithVisaPlatformConnect.php';

function PinDebitPurchaseReversalVoid()
{
	$id = PinDebitPurchaseUsingSwipedTrackDataWithVisaPlatformConnect()[0]['id'];

	$clientReferenceInformationArr = [
			"code" => "Pin Debit Purchase Reversal(Void)"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

	$paymentInformationPaymentTypeArr = [
			"name" => "CARD",
			"subTypeName" => "DEBIT"
	];
	$paymentInformationPaymentType = new CyberSource\Model\Ptsv2paymentsidrefundsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

	$paymentInformationArr = [
			"paymentType" => $paymentInformationPaymentType
	];
	$paymentInformation = new CyberSource\Model\Ptsv2paymentsidvoidsPaymentInformation($paymentInformationArr);

	$amountDetailsArr = [
		"totalAmount"=> "202.00",
		"currency"=> "USD"
	];

	$amountDetails = new CyberSource\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($amountDetailsArr);

	$orderInformationAmountDetailsArr = [
		"amountDetails" => $amountDetails
	];

	$orderInformation = new CyberSource\Model\Ptsv2paymentsidvoidsOrderInformation($orderInformationAmountDetailsArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"paymentInformation" => $paymentInformation,
			"orderInformation" => $orderInformation
	];
	$requestObj = new CyberSource\Model\VoidPaymentRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\VoidApi($api_client);

	try {
		$apiResponse = $api_instance->voidPayment($requestObj, $id);
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
	echo "\nPinDebitPurchaseReversalVoid Sample Code is Running..." . PHP_EOL;
	PinDebitPurchaseReversalVoid();
}
?>
