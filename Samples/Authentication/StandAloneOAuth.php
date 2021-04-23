<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

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


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	// Set AccessToken and RefreshToken
	$merchantConfig->setAccessToken($accessToken);
	$merchantConfig->setRefreshToken($refreshToken);

	// Set Authentication to OAuth
	$merchantConfig->setAuthenticationType(strtoupper(trim("oauth")));

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentsApi($api_client);

	try {
		$apiResponse = $api_instance->createPayment($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

function postAccessTokenFromAuthCode($code, $grantType)
{
    $commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

    $requestObj = [
        "code" => $code,
        "grant_type" => $grantType,
        "client_id" => $merchantConfig->getClientId(),
        "client_secret" => $merchantConfig->getClientSecret()
    ];

    $merchantConfig->setAuthenticationType(strtoupper(trim("mutual_auth")));

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\OAuthApi($api_client);

	try {
		$apiResponse = $api_instance->postAccessTokenRequest($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

function postAccessTokenFromRefreshToken($refreshToken, $grantType)
{
    $commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

    $requestObj = [
        "refresh_token" => $refreshToken,
        "grant_type" => $grantType,
        "client_id" => $merchantConfig->getClientId(),
        "client_secret" => $merchantConfig->getClientSecret()
    ];

    $merchantConfig->setAuthenticationType(strtoupper(trim("mutual_auth")));

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\OAuthApi($api_client);

	try {
		$apiResponse = $api_instance->postAccessTokenRequest($requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nStandAloneOAuth Sample Code is Running..." . PHP_EOL;
    $result = null;

    if($createUsingAuthCode)
    {
        $code = "s";
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
