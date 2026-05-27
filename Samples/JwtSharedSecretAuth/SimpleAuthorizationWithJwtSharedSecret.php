<?php
/**
 * Simple Authorization using JWT authentication with Shared Secret (HS256).
 *
 * This sample demonstrates a drop-in replacement for HTTP Signature authentication.
 * It uses the SAME apiKeyID and secretKey credentials you already use for HTTP
 * Signature, but authenticates via JWT instead.
 *
 * Migration from HTTP Signature:
 *   HTTP Signature authentication is being deprecated. To migrate:
 *     1. Change authenticationType from http_signature to jwt
 *     2. Add jwtKeyType = SHARED_SECRET
 *     3. Keep your existing apiKeyID and secretKey as-is
 *
 * See Resources/JwtSharedSecretConfiguration.php for the full configuration.
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/JwtSharedSecretConfiguration.php';

function SimpleAuthorizationWithJwtSharedSecret($flag)
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

    /* Load JWT + Shared Secret configuration (no MLE) */
    $commonElement = new CyberSource\JwtSharedSecretConfiguration();
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
    echo "\nSimpleAuthorizationWithJwtSharedSecret Sample Code is Running..." . PHP_EOL;
    SimpleAuthorizationWithJwtSharedSecret('false');
}
?>
