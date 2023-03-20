<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateAndSendInvoiceImmediately()
{
    $customerInformationArr = [
            "name" => "Tanya Lee",
            "email" => "tanya.lee@my-email.world"
    ];
    $customerInformation = new CyberSource\Model\Invoicingv2invoicesCustomerInformation($customerInformationArr);

    $invoiceInformationArr = [
            "description" => "This is a test invoice",
            "dueDate" => "2019-07-11",
            "sendImmediately" => true,
            "allowPartialPayments" => true,
            "deliveryMode" => "email"
    ];
    $invoiceInformation = new CyberSource\Model\Invoicingv2invoicesInvoiceInformation($invoiceInformationArr);

    $orderInformationAmountDetailsTaxDetailsArr = [
            "type" => "State Tax",
            "amount" => "208.04",
            "rate" => "8.25"
    ];
    $orderInformationAmountDetailsTaxDetails = new CyberSource\Model\Invoicingv2invoicesOrderInformationAmountDetailsTaxDetails($orderInformationAmountDetailsTaxDetailsArr);

    $orderInformationAmountDetailsFreightArr = [
            "amount" => "20.00",
            "taxable" => true
    ];
    $orderInformationAmountDetailsFreight = new CyberSource\Model\Invoicingv2invoicesOrderInformationAmountDetailsFreight($orderInformationAmountDetailsFreightArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "2623.64",
            "currency" => "USD",
            "discountAmount" => "126.08",
            "discountPercent" => 5.0,
            "subAmount" => 2749.72,
            "minimumPartialAmount" => 20.00,
            "taxDetails" => $orderInformationAmountDetailsTaxDetails,
            "freight" => $orderInformationAmountDetailsFreight
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Invoicingv2invoicesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationLineItems = array();
    $orderInformationLineItems_0 = [
            "productSku" => "P653727383",
            "productName" => "First line item's name",
            "quantity" => 21,
            "unitPrice" => "120.08"
    ];
    $orderInformationLineItems[0] = new CyberSource\Model\Invoicingv2invoicesOrderInformationLineItems($orderInformationLineItems_0);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSource\Model\Invoicingv2invoicesOrderInformation($orderInformationArr);

    $requestObjArr = [
            "customerInformation" => $customerInformation,
            "invoiceInformation" => $invoiceInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\CreateInvoiceRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\InvoicesApi($api_client);

    try {
        $apiResponse = $api_instance->createInvoice($requestObj);
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
    echo "\nCreateAndSendInvoiceImmediately Sample Code is Running..." . PHP_EOL;
    CreateAndSendInvoiceImmediately();
}
?>
