<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreatePaymentInstrumentBankAccount()
{
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

    $bankAccountArr = [
        "type" => "savings"
    ];
    $bankAccount = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBankAccount($bankAccountArr);

    $buyerInformationPersonalIdentification = array();
    $buyerInformationPersonalIdentificationIssuedBy_0Arr = [
        "administrativeArea" => "CA"
    ];
    $buyerInformationPersonalIdentificationIssuedBy_0 = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformationIssuedBy($buyerInformationPersonalIdentificationIssuedBy_0Arr);

    $buyerInformationPersonalIdentification_0 = [
        "id" => "57684432111321",
        "type" => "driver license", "issuedBy" => $buyerInformationPersonalIdentificationIssuedBy_0
    ];
    $buyerInformationPersonalIdentification[0] = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

    $buyerInformationArr = [
        "companyTaxID" => "12345",
        "currency" => "USD",
        "dateOfBirth" => "2000-12-13",
        "personalIdentification" => $buyerInformationPersonalIdentification
    ];
    $buyerInformation = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformation($buyerInformationArr);

    $billToArr = [
        "firstName" => "John",
        "lastName" => "Doe",
        "company" => "Cybersource",
        "address1" => "1 Market St",
        "locality" => "San Francisco",
        "administrativeArea" => "CA",
        "postalCode" => "94105",
        "country" => "US",
        "email" => "test@cybs.com",
        "phoneNumber" => "4158880000"
    ];
    $billTo = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBillTo($billToArr);

    $processingInformationBankTransferOptionsArr = [
        "seCCode" => "WEB"
    ];
    $processingInformationBankTransferOptions = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentProcessingInformationBankTransferOptions($processingInformationBankTransferOptionsArr);

    $processingInformationArr = [
        "bankTransferOptions" => $processingInformationBankTransferOptions
    ];
    $processingInformation = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentProcessingInformation($processingInformationArr);

    $instrumentIdentifierArr = [
            "id" => "A7A91A2CA872B272E05340588D0A0699"
    ];
    $instrumentIdentifier = new CyberSource\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentInstrumentIdentifier($instrumentIdentifierArr);

    $requestObjArr = [
        "bankAccount" => $bankAccount,
        "buyerInformation" => $buyerInformation,
        "billTo" => $billTo,
        "processingInformation" => $processingInformation,
        "instrumentIdentifier" => $instrumentIdentifier
    ];
    $requestObj = new CyberSource\Model\PostPaymentInstrumentRequest($requestObjArr);

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentInstrumentApi($api_client);

    try {
        $apiResponse = $api_instance->postPaymentInstrument($requestObj, $profileid);
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
    echo "\nCreatePaymentInstrumentBankAccount Sample Code is Running..." . PHP_EOL;
    CreatePaymentInstrumentBankAccount();
}
?>
