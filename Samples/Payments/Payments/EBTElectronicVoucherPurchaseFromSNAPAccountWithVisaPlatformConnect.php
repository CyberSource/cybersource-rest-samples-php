<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function EBTElectronicVoucherPurchaseFromSNAPAccountWithVisaPlatformConnect()
{
    $clientReferenceInformationArr = [
            "code" => "EBT - Voucher Purchase From SNAP Account"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationPurchaseOptionsArr = [
            "isElectronicBenefitsTransfer" => true
    ];
    $processingInformationPurchaseOptions = new CyberSource\Model\Ptsv2paymentsProcessingInformationPurchaseOptions($processingInformationPurchaseOptionsArr);

    $processingInformationElectronicBenefitsTransferArr = [
            "category" => "FOOD",
            "voucherSerialNumber" => "123451234512345"
    ];
    $processingInformationElectronicBenefitsTransfer = new CyberSource\Model\Ptsv2paymentsProcessingInformationElectronicBenefitsTransfer($processingInformationElectronicBenefitsTransferArr);

    $processingInformationArr = [
            "capture" => false,
            "commerceIndicator" => "retail",
            "purchaseOptions" => $processingInformationPurchaseOptions,
            "electronicBenefitsTransfer" => $processingInformationElectronicBenefitsTransfer
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4012002000013007",
            "expirationMonth" => "12",
            "expirationYear" => "25"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationPaymentTypeArr = [
            "name" => "CARD",
            "subTypeName" => "DEBIT"
    ];
    $paymentInformationPaymentType = new CyberSource\Model\Ptsv2paymentsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard,
            "paymentType" => $paymentInformationPaymentType
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "103.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $pointOfSaleInformationArr = [
            "entryMode" => "keyed",
            "terminalCapability" => 4,
            "trackData" => "%B4111111111111111^JONES/JONES ^3112101976110000868000000?;4111111111111111=16121019761186800000?"
    ];
    $pointOfSaleInformation = new CyberSource\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "pointOfSaleInformation" => $pointOfSaleInformation
    ];
    $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentsApi($api_client);

    try {
        $apiResponse = $api_instance->createPayment($requestObj);
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nEBTElectronicVoucherPurchaseFromSNAPAccountWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
    EBTElectronicVoucherPurchaseFromSNAPAccountWithVisaPlatformConnect();
}
?>