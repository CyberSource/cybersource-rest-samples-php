<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function MultipleLineItems()
{
	$clientReferenceInformationArr = [
			"code" => "addressEg",
			"comments" => "dav-All fields"
	];
	$clientReferenceInformation = new CyberSource\Model\Riskv1addressverificationsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationBillToArr = [
			"address1" => "12301 research st",
			"address2" => "1",
			"address3" => "2",
			"address4" => "3",
			"administrativeArea" => "TX",
			"country" => "US",
			"locality" => "Austin",
			"postalCode" => "78759"
	];
	$orderInformationBillTo = new CyberSource\Model\Riskv1addressverificationsOrderInformationBillTo($orderInformationBillToArr);

	$orderInformationShipToArr = [
			"address1" => "PO Box 9088",
			"address2" => "",
			"address3" => "",
			"address4" => "",
			"administrativeArea" => "CA",
			"country" => "US",
			"locality" => "San Jose",
			"postalCode" => "95132"
	];
	$orderInformationShipTo = new CyberSource\Model\Riskv1addressverificationsOrderInformationShipTo($orderInformationShipToArr);

	$orderInformationLineItems = array();
	$orderInformationLineItems_0 = [
			"unitPrice" => "120.50",
			"quantity" => 3,
			"productSKU" => "9966223",
			"productName" => "headset",
			"productCode" => "electronix"
	];
	$orderInformationLineItems[0] = new CyberSource\Model\Riskv1addressverificationsOrderInformationLineItems($orderInformationLineItems_0);

	$orderInformationLineItems_1 = [
			"unitPrice" => "10.50",
			"quantity" => 2,
			"productSKU" => "9966226",
			"productName" => "wwrdf",
			"productCode" => "electronic"
	];
	$orderInformationLineItems[1] = new CyberSource\Model\Riskv1addressverificationsOrderInformationLineItems($orderInformationLineItems_1);

	$orderInformationArr = [
			"billTo" => $orderInformationBillTo,
			"shipTo" => $orderInformationShipTo,
			"lineItems" => $orderInformationLineItems
	];
	$orderInformation = new CyberSource\Model\Riskv1addressverificationsOrderInformation($orderInformationArr);

	$buyerInformationArr = [
			"merchantCustomerId" => "QWERTY"
	];
	$buyerInformation = new CyberSource\Model\Riskv1addressverificationsBuyerInformation($buyerInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation,
			"buyerInformation" => $buyerInformation
	];
	$requestObj = new CyberSource\Model\VerifyCustomerAddressRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\VerificationApi($api_client);

	try {
		$apiResponse = $api_instance->verifyCustomerAddress($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nMultipleLineItems Sample Code is Running..." . PHP_EOL;
	MultipleLineItems();
}
?>
