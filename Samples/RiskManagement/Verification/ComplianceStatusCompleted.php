<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ComplianceStatusCompleted()
{
    $clientReferenceInformationArr = [
            "code" => "verification example"
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationBillToArr = [
            "address1" => "901 Metro Centre Blvd",
            "address2" => "2",
            "administrativeArea" => "CA",
            "country" => "US",
            "locality" => "Foster City",
            "postalCode" => "94404",
            "firstName" => "Suman",
            "lastName" => "Kumar",
            "email" => "donewithhorizon@test.com"
    ];
    $orderInformationBillTo = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationShipToArr = [
            "country" => "be",
            "firstName" => "DumbelDore",
            "lastName" => "Albus"
    ];
    $orderInformationShipTo = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationShipTo($orderInformationShipToArr);

    $orderInformationLineItems = array();
    $orderInformationLineItems_0 = [
            "unitPrice" => "19.00"
    ];
    $orderInformationLineItems[0] = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformationLineItems($orderInformationLineItems_0);

    $orderInformationArr = [
            "billTo" => $orderInformationBillTo,
            "shipTo" => $orderInformationShipTo,
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSource\Model\Riskv1exportcomplianceinquiriesOrderInformation($orderInformationArr);

    $buyerInformationArr = [
            "merchantCustomerId" => "87789"
    ];
    $buyerInformation = new CyberSource\Model\Riskv1addressverificationsBuyerInformation($buyerInformationArr);

    $exportComplianceInformationWeightsArr = [
            "address" => "abc",
            "company" => "def",
            "name" => "adb"
    ];
    $exportComplianceInformationWeights = new CyberSource\Model\Ptsv2paymentsWatchlistScreeningInformationWeights($exportComplianceInformationWeightsArr);

    $exportComplianceInformationSanctionLists = array();
    $exportComplianceInformationSanctionLists[0] = "abc";
    $exportComplianceInformationSanctionLists[1] = "acc";
    $exportComplianceInformationSanctionLists[2] = "bac";
    $exportComplianceInformationArr = [
            "addressOperator" => "and",
            "weights" => $exportComplianceInformationWeights,
            "sanctionLists" => $exportComplianceInformationSanctionLists
    ];
    $exportComplianceInformation = new CyberSource\Model\Riskv1exportcomplianceinquiriesExportComplianceInformation($exportComplianceInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "buyerInformation" => $buyerInformation,
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
    echo "\nComplianceStatusCompleted Sample Code is Running..." . PHP_EOL;
    ComplianceStatusCompleted();
}
?>
