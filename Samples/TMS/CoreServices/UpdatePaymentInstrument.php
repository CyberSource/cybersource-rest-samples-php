<?php
require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function UpdatePaymentInstrument()
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

  $strumentidentifiersArr = [
    "card" => $instrumentidentifiersCard ];

  $instrumentIdentifier = new CyberSource\Model\Tmsv1paymentinstrumentsInstrumentIdentifier($strumentidentifiersArr);
  $tmsRequestArr = [
    "card" => $card,
    "billTo" => $tmsBillTo,
    "instrumentIdentifier" => $instrumentIdentifier
  ];
	$tmsRequest = new CyberSource\Model\Body3($tmsRequestArr);

  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  include_once 'Samples/TMS/CoreServices/RetrievePaymentInstrument.php';
  $tokenId = RetrievePaymentInstrument(true);
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tmsV1PaymentinstrumentsTokenIdPatch($profileId, $tokenId, $tmsRequest);
		echo "<pre>";print_r($api_response);

	}catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
  echo "UpdatePaymentInstrument Samplecode is Running.. \n";
	UpdatePaymentInstrument();

}
?>	
