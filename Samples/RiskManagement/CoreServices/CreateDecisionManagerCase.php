<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateDecisionManagerCase()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\DecisionManagerApi($apiclient);
	
	$api_response = list($response,$statusCode,$httpHeader)=null;
		
	$clientRefInfo = ["code" => "54323007"];

	$clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientRefInfo);

	$cardInfo = ["number" => "4444444444444448",
	"expirationMonth" => "12",
	"expirationYear" => "2020"];

	$cardInformation = new CyberSource\Model\Riskv1decisionsPaymentInformationCard($cardInfo);

	$paymentInfo = ["card" => $cardInfo];

	$paymentInformation = new CyberSource\Model\Riskv1decisionsPaymentInformation($paymentInfo);

	$amtDetails = ["currency" => "USD", "totalAmount" => "144.14"];

	$amountDetails = new CyberSource\Model\Riskv1decisionsOrderInformationAmountDetails($amtDetails);

	$billTo = ["address1" => "96, powers street",
	"administrativeArea" => "NH",
	"country" => "US",
	"locality" => "Clearwater milford",
	"firstName" => "James",
	"lastName" => "Smith",
	"phoneNumber" => "7606160717",
	"email" => "test@visa.com",
	"postalCode" => "03055"];

    $billTo = new CyberSource\Model\Riskv1decisionsOrderInformationBillTo($billTo);

	$orderInfo = ["amountDetails" => $amountDetails, "billTo" => $billTo];

    $orderInformation = new CyberSource\Model\Riskv1decisionsOrderInformation($orderInfo);

	$reqObj = ["clientReferenceInformation" => $clientReferenceInformation, "paymentInformation" => $paymentInformation, "orderInformation" => $orderInformation];

	$requestObj = new CyberSource\Model\CreateDecisionManagerCaseRequest($reqObj);


	try {
		$api_response = $api_instance->createDecisionManagerCase($requestObj);
		print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}	

} 


// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "CreateDecisionManagerCase Samplecode is Running.. \n";
	CreateDecisionManagerCase();

}
?>	
