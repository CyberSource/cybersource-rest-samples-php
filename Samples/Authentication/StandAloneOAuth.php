<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';

//creating merchant config object
function merchantConfigObject()
{
    $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
    $runEnv = "api-matest.cybersource.com";
    #OAuth related config
    $enableClientCert = true;
    $clientCertDirectory = "Resources/";
    $clientCertFile = ""; // p12 certificate
    $clientCertPassword = "";  // password used to encrypt p12
    $clientId = "";
    $clientSecret = "";

    $confiData = $config->setEnableClientCert($enableClientCert);
    $confiData = $config->setClientCertDirectory($clientCertDirectory);
    $confiData = $config->setClientCertFile($clientCertFile);
    $confiData = $config->setClientCertPassword($clientCertPassword);
    $confiData = $config->setClientId($clientId);
    $confiData = $config->setClientSecret($clientSecret);
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

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

$createUsingAuthCode = true;

function SimpleAuthorizationInternet($refreshToken, $accessToken)
{
    $capture = true;

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

        // Set AccessToken and RefreshToken
        $merchantConfig->setAccessToken($accessToken);
        $merchantConfig->setRefreshToken($refreshToken);

        // Set Authentication to OAuth
        $merchantConfig->setAuthenticationType(strtoupper(trim("oauth")));

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

function postAccessTokenFromAuthCode($code, $grantType)
{
    try {
        $config = ConnectionHost();
        $merchantConfig = merchantConfigObject();

        $requestObj = [
            "code" => $code,
            "grant_type" => $grantType,
            "client_id" => $merchantConfig->getClientId(),
            "client_secret" => $merchantConfig->getClientSecret()
        ];

        $merchantConfig->setAuthenticationType(strtoupper(trim("mutual_auth")));

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\OAuthApi($api_client);

        $apiResponse = $api_instance->postAccessTokenRequest($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    } catch(Cybersource\Authentication\Core\AuthException $e) {
        print_r($e->getMessage());
    }
}

function postAccessTokenFromRefreshToken($refreshToken, $grantType)
{
    try {
        $config = ConnectionHost();
        $merchantConfig = merchantConfigObject();

        $requestObj = [
            "refresh_token" => $refreshToken,
            "grant_type" => $grantType,
            "client_id" => $merchantConfig->getClientId(),
            "client_secret" => $merchantConfig->getClientSecret()
        ];

        $merchantConfig->setAuthenticationType(strtoupper(trim("mutual_auth")));

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\OAuthApi($api_client);

        $apiResponse = $api_instance->postAccessTokenRequest($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    } catch(Cybersource\Authentication\Core\AuthException $e) {
        print_r($e->getMessage());
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nStandAloneOAuth Sample Code is Running..." . PHP_EOL;
    $result = null;

    if($createUsingAuthCode)
    {
        $code = "";
        $grantType = "authorization_code";
        $result = postAccessTokenFromAuthCode($code, $grantType);
    }
    else
    {
        $grantType = "refresh_token";
        $refreshToken = "";
        $result = postAccessTokenFromRefreshToken($refreshToken, $grantType);
    }

    if($result != null) {
        $refreshToken = $result[0]->getRefreshToken();
        $accessToken = $result[0]->getAccessToken();

        //Call Payments SampleCode using OAuth, Set Authentication to OAuth in Sample Code Configuration
        SimpleAuthorizationInternet($refreshToken, $accessToken);
    }
}
?>
