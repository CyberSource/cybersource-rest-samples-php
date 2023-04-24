<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';

//creating merchant config object
function merchantConfigObject()
{
        $authType = "http_signature";
        $merchantID = "";
        $apiKeyID = "";
        $secretKey = "";
        $useMetaKey = true;
        $portfolioID = "";
        $runEnv = "apitest.cybersource.com";
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();

        $confiData = $config->setauthenticationType(strtoupper(trim($authType)));
        $confiData = $config->setMerchantID(trim($merchantID));
        $confiData = $config->setApiKeyID($apiKeyID);
        $confiData = $config->setSecretKey($secretKey);
        $confiData = $config->setUseMetaKey($useMetaKey);
        $confiData = $config->setPortfolioID($portfolioID);
        $confiData = $config->setRunEnvironment($runEnv);
        $config->validateMerchantData($confiData);
        return $config;
}

function ConnectionHost()
{
        $merchantConfig = merchantConfigObject();
        $config = new \CyberSource\Configuration();
        $config = $config->setHost($merchantConfig->getHost());
        return $config;
}

function StandAloneMetaKey()
{
    SimplePaymentsUsingMetaKey("false");
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

function SimplePaymentsUsingMetaKey($flag)
{
    if (isset($flag) && $flag == "true") {
        $capture = true;
    } else {
        $capture = false;
    }

    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationArr = [
            "capture" => $capture
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4111111111111111",
            "expirationMonth" => "12",
            "expirationYear" => "2031"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "102.21",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "1 Market St",
            "locality" => "san francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);

    try {
        $config = ConnectionHost();
        $merchantConfig = merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PaymentsApi($api_client);

        $apiResponse = $api_instance->createPayment($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);

        WriteLogAudit($apiResponse[1]);
        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    } catch(Cybersource\Authentication\Core\AuthException $e) {
        print_r($e->getMessage());
        $errorCode = $e->getCode();
        WriteLogAudit($errorCode);
    }
}

if (!defined('DO_NOT_RUN_SAMPLES'))
{
    echo "StandAloneMetaKey Sample Code is running...\n";
    StandAloneMetaKey();
}

?>