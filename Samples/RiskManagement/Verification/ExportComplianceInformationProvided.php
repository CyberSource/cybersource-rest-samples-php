<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ExportComplianceInformationProvided()
{
    $clientReferenceInformationArr = [
            "code" => "verification example",
            "comments" => "Export -fields"
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

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

    $exportComplianceInformationWeightsArr = [
            "address" => "low",
            "company" => "exact",
            "name" => "exact"
    ];
    $exportComplianceInformationWeights = new CyberSource\Model\Ptsv2paymentsWatchlistScreeningInformationWeights($exportComplianceInformationWeightsArr);

    $exportComplianceInformationSanctionLists = array();
    $exportComplianceInformationSanctionLists[0] = "Bureau Of Industry and Security";
    $exportComplianceInformationArr = [
            "addressOperator" => "and",
            "weights" => $exportComplianceInformationWeights,
            "sanctionLists" => $exportComplianceInformationSanctionLists
    ];
    $exportComplianceInformation = new CyberSource\Model\Riskv1exportcomplianceinquiriesExportComplianceInformation($exportComplianceInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "exportComplianceInformation" => $exportComplianceInformation
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

        WriteLogAudit($apiResponse[1]);
        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
        $errorCode = $e->getCode();
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
    echo "\nExportComplianceInformationProvided Sample Code is Running..." . PHP_EOL;
    ExportComplianceInformationProvided();
}
?>
