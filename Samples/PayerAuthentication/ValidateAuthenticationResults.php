<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function ValidateAuthenticationResults()
{
    $clientReferenceInformationPartnerArr = [
            "developerId" => "7891234",
            "solutionId" => "89012345"
    ];
    $clientReferenceInformationPartner = new CyberSource\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "pavalidatecheck",
            "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD",
            "totalAmount" => "200.00"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationLineItems = array();
    $orderInformationLineItems_0 = [
            "unitPrice" => "10",
            "quantity" => 2,
            "taxAmount" => "32.40"
    ];
    $orderInformationLineItems[0] = new CyberSource\Model\Riskv1authenticationresultsOrderInformationLineItems($orderInformationLineItems_0);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSource\Model\Riskv1authenticationresultsOrderInformation($orderInformationArr);

    $paymentInformationCardArr = [
            "type" => "002",
            "expirationMonth" => "12",
            "expirationYear" => "2025",
            "number" => "5200000000000007"
    ];
    $paymentInformationCard = new CyberSource\Model\Riskv1authenticationresultsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSource\Model\Riskv1authenticationresultsPaymentInformation($paymentInformationArr);

    $consumerAuthenticationInformationArr = [
            "authenticationTransactionId" => "PYffv9G3sa1e0CQr5fV0",
            "signedPares" => "eNqdmFmT4jgSgN+J4D90zD4yMz45PEFVhHzgA2zwjXnzhQ984Nvw61dAV1"
    ];
    $consumerAuthenticationInformation = new CyberSource\Model\Riskv1authenticationresultsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "paymentInformation" => $paymentInformation,
            "consumerAuthenticationInformation" => $consumerAuthenticationInformation
    ];
    $requestObj = new CyberSource\Model\ValidateRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->validateAuthenticationResults($requestObj);
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
    echo "\nValidateAuthenticationResults Sample Code is Running..." . PHP_EOL;
    ValidateAuthenticationResults();
}
?>
