<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function CreatePaymentsInstruments()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\PaymentInstrumentsApi($apiclient);
	
  $tmsCardInfo = [
    "expirationMonth" => "09",
    "expirationYear" => "2022",
    "type" => "visa"
  ];
  $card = new CyberSource\Model\Tmsv1paymentinstrumentsCard($tmsCardInfo);

  $tmsBillToArr = [
    "firstName" => "John",
    "lastName" => "Deo",
    "company" => "CyberSource",
    "address1" => "12 Main Street",
    "address2" => "20 My Street",
    "locality" => "Foster City",
    "administrativeArea" => "CA",
    "postalCode" => "90200",
    "country" => "US",
    "email" => "john.smith@example.com",
    "phoneNumber" => "555123456"
  ];
  $tmsBillTo = new CyberSource\Model\Tmsv1paymentinstrumentsBillTo($tmsBillToArr);
  $cardArr = [
      "number" => "4111111111111111" 
  ];
  $instrumentidentifiersCard = new CyberSource\Model\Tmsv1instrumentidentifiersCard($cardArr);

  $instrumentidentifiersArr = [
      "card" => $instrumentidentifiersCard
  ];
  $instrumentidentifier = new CyberSource\Model\Tmsv1paymentinstrumentsInstrumentIdentifier($instrumentidentifiersArr);

  $tmsRequestArr = [
    "card" => $card,
    "billTo" => $tmsBillTo,
    "instrumentIdentifier" => $instrumentidentifier
  ];
  $tmsRequest = new CyberSource\Model\Body2($tmsRequestArr);
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tmsV1PaymentinstrumentsPost($profileId, $tmsRequest);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Samplecode is Running..";
	CreatePaymentsInstruments();

}
?>	
