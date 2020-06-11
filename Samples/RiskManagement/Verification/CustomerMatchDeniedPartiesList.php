<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CustomerMatchDeniedPartiesList()
{
	$clientReferenceInformationArr = [
			"code" => "verification example",
			"comments" => "Export-basic"
	];
	$clientReferenceInformation = new CyberSource\Model\Riskv1addressverificationsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationBillToCompanyArr = [
			"name" => "A & C International Trade, Inc"
	];
	$orderInformationBillToCompany = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationBillToCompany($orderInformationBillToCompanyArr);

	$orderInformationBillToArr = [
			"address1" => "901 Metro Centre Blvd",
			"administrativeArea" => "CA",
			"country" => "US",
			"locality" => "Foster City",
			"postalCode" => "94404",
			"company" => $orderInformationBillToCompany,
			"firstName" => "ANDREE",
			"lastName" => "AGNESE",
			"email" => "test@domain.com"
	];
	$orderInformationBillTo = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationBillTo($orderInformationBillToArr);

	$orderInformationShipToArr = [
			"country" => "IN",
			"firstName" => "DumbelDore",
			"lastName" => "Albus"
	];
	$orderInformationShipTo = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationShipTo($orderInformationShipToArr);

	$orderInformationLineItems = array();
	$orderInformationLineItems_0 = [
			"unitPrice" => "120.50",
			"quantity" => 3,
			"productSKU" => "123456",
			"productName" => "Qwe",
			"productCode" => "physical_software"
	];
	$orderInformationLineItems[0] = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationLineItems($orderInformationLineItems_0);

	$orderInformationArr = [
			"billTo" => $orderInformationBillTo,
			"shipTo" => $orderInformationShipTo,
			"lineItems" => $orderInformationLineItems
	];
	$orderInformation = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformation($orderInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation
	];
	$requestObj = new CyberSource\Model\ValidateExportComplianceRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\VerificationApi($api_client);

	try {
		$apiResponse = $api_instance->validateExportCompliance($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nCustomerMatchDeniedPartiesList Sample Code is Running..." . PHP_EOL;
	CustomerMatchDeniedPartiesList();
}
?>
