<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CapturePayment($flag)
{
    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\CaptureApi($apiclient);
	
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ProcessPaymentWithServiceFee.php';
	
    $id = ProcessPaymentWithServiceFee("true");
	
    $cliRefInfoArr = [
		"code" => "test_capture"
	];
    $client_reference_information = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($cliRefInfoArr);
	
    $amountDetailsArr = [
		"totalAmount" => "225.00",
		"currency" => "USD",
		"serviceFeeAmount" => "30.0"
	];
    $amountDetInfo = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($amountDetailsArr);

    $orderInfoArr = [
		"amountDetails" => $amountDetInfo
	];
    $order_information = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInfoArr);
	
    $requestArr = [
		"clientReferenceInformation" => $client_reference_information, 
		"orderInformation" => $order_information
	];
    $request = new CyberSource\Model\CapturePaymentRequest($requestArr);
	
    $api_response = list($response, $statusCode, $httpHeader) = null;
    try
    {
        //Calling the Api
        $api_response = $api_instance->capturePayment($request, $id);

        if ($flag == true)
        {
            //Returning the ID
            echo "Fetching Capture ID: " . $api_response[0]['id'] . "\n";
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
    echo "Capture payment Samplecode is Running.. \n";
    CapturePayment(false);
}

?>
