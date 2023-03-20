<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AddDataToList()
{
    $type = 'negative';
    $orderInformationAddressArr = [
            "address1" => "1234 Sample St.",
            "address2" => "Mountain View",
            "locality" => "California",
            "country" => "US",
            "administrativeArea" => "CA",
            "postalCode" => "94043"
    ];
    $orderInformationAddress = new CyberSource\Model\Riskv1liststypeentriesOrderInformationAddress($orderInformationAddressArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => "test@example.com"
    ];
    $orderInformationBillTo = new CyberSource\Model\Riskv1liststypeentriesOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "address" => $orderInformationAddress,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Riskv1liststypeentriesOrderInformation($orderInformationArr);

    $paymentInformationArr = [
    ];
    $paymentInformation = new CyberSource\Model\Riskv1liststypeentriesPaymentInformation($paymentInformationArr);

    $clientReferenceInformationPartnerArr = [
            "developerId" => "7891234",
            "solutionId" => "89012345"
    ];
    $clientReferenceInformationPartner = new CyberSource\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "54323007",
            "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $riskInformationMarkingDetailsArr = [
            "action" => "add"
    ];
    $riskInformationMarkingDetails = new CyberSource\Model\Riskv1liststypeentriesRiskInformationMarkingDetails($riskInformationMarkingDetailsArr);

    $riskInformationArr = [
            "markingDetails" => $riskInformationMarkingDetails
    ];
    $riskInformation = new CyberSource\Model\Riskv1liststypeentriesRiskInformation($riskInformationArr);

    $requestObjArr = [
            "orderInformation" => $orderInformation,
            "paymentInformation" => $paymentInformation,
            "clientReferenceInformation" => $clientReferenceInformation,
            "riskInformation" => $riskInformation
    ];
    $requestObj = new CyberSource\Model\AddNegativeListRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\DecisionManagerApi($api_client);

    try {
        $apiResponse = $api_instance->addNegative($type, $requestObj);
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
    echo "\nAddDataToList Sample Code is Running..." . PHP_EOL;
    AddDataToList();
}
?>
