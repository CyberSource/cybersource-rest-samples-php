<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ProcessCreditWithServiceFee($flag)
{
    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $apiclient = new CyberSource\ApiClient($config);
    $api_instance = new CyberSource\Api\CreditApi($apiclient);
	
    $cliRefInfoArr = [
		"code" => "12345678"
	];
    $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);

    $amountDetailsArr = [
		"totalAmount" => "200",
        "currency" => "usd",
        "serviceFeeAmount" =>"30.0"
	];
    $amountDetInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($amountDetailsArr);
	
    $billtoArr = [  
		"firstName" => "John",
		"lastName" => "Doe",
		"address1" => "1 Market St",
		"postalCode" => "94105",
		"locality" => "san francisco",
		"administrativeArea" => "CA",
		"country" => "US",
		"phoneNumber" => "4158880000",
		"company" => "ABC Company",
		"email" => "test@cybs.com"
	];
    $billto = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($billtoArr);
	
    $orderInfoArr = [
		"amountDetails" => $amountDetInfo, 
		"billTo" => $billto
	];
    $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArr);

    $paymentCardInfo = [
		"expirationYear" => "2031",
		"number" => "4111111111111111",
		"securityCode" => "123",
		"expirationMonth" => "12"
	];
    $card = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentCardInfo);
	
    $paymentInfoArr = [
		"card" => $card
    ];
    $payment_information = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInfoArr);

    $paymentRequestArr = [
		"clientReferenceInformation" => $client_reference_information, 
		"orderInformation" => $order_information, 
		"paymentInformation" => $payment_information
	];

    $paymentRequest = new CyberSource\Model\CreateCreditRequest($paymentRequestArr);
	
    $api_response = list($response, $statusCode, $httpHeader) = null;
    try
    {
        $api_response = $api_instance->createCredit($paymentRequest);
        if ($flag == true)
        {
            echo "Fetching Credit ID: " . $api_response[0]['id'] . "\n";
            return $api_response[0]['id'];
        }
        else
        {
            print_r($api_response);
        }
    }
    catch(Cybersource\ApiException $e)
    {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
    }
}

// Call Sample Code
if (!defined('DO_NOT_RUN_SAMPLES'))
{
    echo "Process Credit With Service Fee Sample code is Running.. \n";
    ProcessCreditWithServiceFee(false);
}
?>
