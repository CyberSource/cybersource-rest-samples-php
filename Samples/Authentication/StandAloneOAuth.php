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
        $code = "URvXIU";
        $grantType = "authorization_code";
        $result = postAccessTokenFromAuthCode($code, $grantType);
    }
    else
    {
        $grantType = "refresh_token";
        $refreshToken = "eyJraWQiOiIxMGM2MTYxNzg2MzE2ZWMzMGJjZmI5ZDcyZGU4MzFjOSIsImFsZyI6IlJTMjU2In0.eyJqdGkiOiJjMjM4ZjFjZi0zOWEzLTRmMDctODBjZi0yZTU3NThjYzI1NmIiLCJzY29wZXMiOlsiYWx0ZXJuYXRlX3BheW1lbnRzIiwiYmFua190cmFuc2ZlcnMiLCJib2FyZGluZyIsImNvbW1lcmNlX3NlcnZpY2VzIiwiZnJhdWRfbWFuYWdlbWVudCIsImludm9pY2luZyIsImtleXMiLCJtYW5hZ2Vfc2VjdXJlX2FjY2VwdGFuY2UiLCJwYXltZW50c193aXRoX3N0YW5kYWxvbmVfY3JlZGl0IiwicGF5bWVudHNfd2l0aG91dF9zdGFuZGFsb25lX2NyZWRpdCIsInBheW91dHMiLCJyZXBvcnRpbmciLCJ0b2tlbml6YXRpb25fc2VydmljZXMiLCJ0cmFuc2FjdGlvbnMiLCJ1c2VycyJdLCJpYXQiOjE2MTY3NDY3MTY1ODcsImFzc29jaWF0ZWRfaWQiOiJzYW1wbGVwYXJ0bmVyIiwiY2xpZW50X2lkIjoidjZUSkgxSXFoTSIsIm1lcmNoYW50X2lkIjoiY2drMl9wdXNoX3Rlc3RzIiwiZXhwaXJlc19pbiI6MTY0ODI4MjcxNjU4NywidG9rZW5fdHlwZSI6InJlZnJlc2hfdG9rZW4iLCJncmFudF90eXBlIjoiYXV0aG9yaXphdGlvbl9jb2RlIiwiZ3JhbnRfdGltZSI6IjIwMjEwMzI2MDExOCJ9.UO9RoE8yz-XE-g3_ftcMu3BwbgslQXC8FjXNqquVujSNmx5Z5E2XlHGk8yMYAzjQ2OI5X2JXEzvQ5-CruAI0oIXAovhUz-20mlgcft80VdLnET6WrZpGCVksdT-KVt7s9neBTZcBq_xIBrzEiL8i-twRXYcU644-9PhKHV2awJD_nl7Es3BOsayHZJf-Dy1I4IYayF61Mgol9niSyzL94-eN_aV45-GEKGd7vnoTctQJmkh1QTykbVehmZ6Xkq1KyMojIkOSjX3ZhLF0jXkjV4K3oul2lT4A7UpdEmhVHLbQvY2G8UrwPzrCz7gML674OvU8PseT-FhI1-ZgfE1rpA";
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
