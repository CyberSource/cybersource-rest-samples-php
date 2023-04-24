<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AddressMatchNotFound()
{
    $clientReferenceInformationArr = [
            "code" => "addressEg",
            "comments" => "dav-error response check"
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationBillToArr = [
            "address1" => "Apt C ",
            "address2" => "",
            "administrativeArea" => "CA",
            "country" => "US",
            "locality" => "Glendale",
            "postalCode" => "91204"
    ];
    $orderInformationBillTo = new CyberSource\Model\Riskv1addressverificationsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Riskv1addressverificationsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation
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
    echo "\nAddressMatchNotFound Sample Code is Running..." . PHP_EOL;
    AddressMatchNotFound();
}
?>
