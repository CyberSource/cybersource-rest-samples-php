<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithPayerAuthValidation()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationActionList = array();
    $processingInformationActionList[0] = "VALIDATE_CONSUMER_AUTHENTICATION";
    $processingInformationArr = [
            "actionList" => $processingInformationActionList,
            "capture" => false
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4000000000001091",
            "expirationMonth" => "01",
            "expirationYear" => "2023"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Smith",
            "address1" => "201 S. Division St._1",
            "address2" => "Suite 500",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "postalCode" => "94404",
            "country" => "US",
            "email" => "accept@cybs.com",
            "phoneNumber" => "6504327113"
    ];
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $consumerAuthenticationInformationArr = [
            "authenticationTransactionId" => "OiCtXA1j1AxtSNDh5lt1"
    ];
    $consumerAuthenticationInformation = new CyberSource\Model\Ptsv2paymentsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "consumerAuthenticationInformation" => $consumerAuthenticationInformation
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

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nAuthorizationWithPayerAuthValidation Sample Code is Running..." . PHP_EOL;
    AuthorizationWithPayerAuthValidation();
}
?>
