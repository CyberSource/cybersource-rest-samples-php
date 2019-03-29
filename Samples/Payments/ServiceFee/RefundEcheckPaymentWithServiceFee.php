<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function RefundEcheckPaymentWithServiceFee($flag)
{
    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
	
    $apiclient = new CyberSource\ApiClient($config);
    $api_instance = new CyberSource\Api\RefundApi($apiclient);
	
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProcessEcheckPaymentWithServiceFee.php';	
    $id = ProcessEcheckPaymentWithServiceFee("true");
	
    $cliRefInfoArr = [
		"code" => "test_refund_payment"
	];
    $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);
	
    $amountDetailsArr = [
		"totalAmount" => "2325.00",
        "currency" => "USD",
        "serviceFeeAmount" => "20"
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
	$billToInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($billtoArr);
	
    $orderInfoArr = [
		"billTo" => $billToInfo , 
		"amountDetails" => $amountDetInfo
	];
    $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArr);

    $accountInfo = [
		"number" => "4100", 
		"type" => "C", 
		"checkNumber" => "123456"
	];
	$accountInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformationBankAccount($accountInfo);

    $bankInfo = [
		"account" => $accountInformation, 
		"routingNumber" => "071923284"
	];
    $bank = new CyberSource\Model\Ptsv2paymentsPaymentInformationBank($bankInfo);

    $paymentInfoArr = [
		"bank" => $bank
	];
	$paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInfoArr);

    $paymentRequestArr = [
		"clientReferenceInformation" => $client_reference_information, 
		"orderInformation" => $order_information, 
		"paymentInformation" => $paymentInformation
	];
    $paymentRequest = new CyberSource\Model\RefundPaymentRequest($paymentRequestArr);

    $api_response = list($response, $statusCode, $httpHeader) = null;
	
    try
    {
        $api_response = $api_instance->refundPayment($paymentRequest, $id);
        if ($flag == true)
        {
            //Returning the ID
            echo "Fetching Refund Payment ID: " . $api_response[0]['id'] . "\n";
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
    echo "Refund Echeck Payment With Service Fee Sample code is Running.. \n";
    RefundEcheckPaymentWithServiceFee(false);
}
?>
