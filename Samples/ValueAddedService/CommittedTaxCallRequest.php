<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function CommittedTaxCallRequest()
{
    $clientReferenceInformationArr = [
            "code" => "TAX_TC001"
    ];
    $clientReferenceInformation = new CyberSource\Model\Vasv2taxClientReferenceInformation($clientReferenceInformationArr);

    $taxInformationArr = [
            "showTaxPerLineItem" => "Yes",
            "commitIndicator" => true
    ];
    $taxInformation = new CyberSource\Model\Vasv2taxTaxInformation($taxInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\RiskV1DecisionsPost201ResponseOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US"
    ];
    $orderInformationBillTo = new CyberSource\Model\Vasv2taxOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationShippingDetailsArr = [
            "shipFromLocality" => "Cambridge Bay",
            "shipFromCountry" => "CA",
            "shipFromPostalCode" => "A0G 1T0",
            "shipFromAdministrativeArea" => "NL"
    ];
    $orderInformationShippingDetails = new CyberSource\Model\Vasv2taxOrderInformationShippingDetails($orderInformationShippingDetailsArr);

    $orderInformationShipToArr = [
            "country" => "US",
            "administrativeArea" => "FL",
            "locality" => "Panama City",
            "postalCode" => "32401",
            "address1" => "123 Russel St."
    ];
    $orderInformationShipTo = new CyberSource\Model\Vasv2taxOrderInformationShipTo($orderInformationShipToArr);

    $orderInformationLineItems = array();
    $orderInformationLineItems_0 = [
            "productSKU" => "07-12-00657",
            "productCode" => "50161815",
            "quantity" => 1,
            "productName" => "Chewing Gum",
            "unitPrice" => "1200"
    ];
    $orderInformationLineItems[0] = new CyberSource\Model\Vasv2taxOrderInformationLineItems($orderInformationLineItems_0);

    $orderInformationLineItems_1 = [
            "productSKU" => "07-12-00659",
            "productCode" => "50181905",
            "quantity" => 1,
            "productName" => "Sugar Cookies",
            "unitPrice" => "1240"
    ];
    $orderInformationLineItems[1] = new CyberSource\Model\Vasv2taxOrderInformationLineItems($orderInformationLineItems_1);

    $orderInformationLineItems_2 = [
            "productSKU" => "07-12-00658",
            "productCode" => "5020.11",
            "quantity" => 1,
            "productName" => "Carbonated Water",
            "unitPrice" => "9001"
    ];
    $orderInformationLineItems[2] = new CyberSource\Model\Vasv2taxOrderInformationLineItems($orderInformationLineItems_2);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo,
            "shippingDetails" => $orderInformationShippingDetails,
            "shipTo" => $orderInformationShipTo,
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSource\Model\Vasv2taxOrderInformation($orderInformationArr);

    $merchantInformationArr = [
            "vatRegistrationNumber" => "abcdef"
    ];
    $merchantInformation = new CyberSource\Model\Vasv2taxMerchantInformation($merchantInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "taxInformation" => $taxInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation
    ];
    $requestObj = new CyberSource\Model\TaxRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\TaxesApi($api_client);

    try {
        $apiResponse = $api_instance->calculateTax($requestObj);
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
    echo "\nCommittedTaxCallRequest Sample Code is Running..." . PHP_EOL;
    CommittedTaxCallRequest();
}
?>
