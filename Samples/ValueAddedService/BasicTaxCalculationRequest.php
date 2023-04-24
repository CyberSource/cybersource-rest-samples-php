<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function BasicTaxCalculationRequest()
{
    $clientReferenceInformationArr = [
            "code" => "TAX_TC001"
    ];
    $clientReferenceInformation = new CyberSource\Model\Vasv2taxClientReferenceInformation($clientReferenceInformationArr);

    $taxInformationArr = [
            "showTaxPerLineItem" => "Yes"
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
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSource\Model\Vasv2taxOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "taxInformation" => $taxInformation,
            "orderInformation" => $orderInformation
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
    echo "\nBasicTaxCalculationRequest Sample Code is Running..." . PHP_EOL;
    BasicTaxCalculationRequest();
}
?>
