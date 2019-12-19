<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function UpdatePaymentInstrument()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PaymentInstrumentApi($apiclient);
	
  $tmsCardInfo = [
    "expirationMonth" => "09",
    "expirationYear" => "2022",
    "type" => "visa"
  ];
  $card = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedCard($tmsCardInfo);

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
  $tmsBillTo = new CyberSource\Model\TmsV1InstrumentIdentifiersPaymentInstrumentsGet200ResponseEmbeddedBillTo($tmsBillToArr);
  $cardArr = [
      "number" => "4111111111111111" 
  ];
  $instrumentidentifiersCard = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseCard($cardArr);

  $strumentidentifiersArr = [
    "card" => $instrumentidentifiersCard ];

  $instrumentIdentifier = new CyberSource\Model\Tmsv1paymentinstrumentsInstrumentIdentifier($strumentidentifiersArr);
  $tmsRequestArr = [
    "card" => $card,
    "billTo" => $tmsBillTo,
    "instrumentIdentifier" => $instrumentIdentifier
  ];
	$tmsRequest = new CyberSource\Model\UpdatePaymentInstrumentRequest($tmsRequestArr);

  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  require_once __DIR__. DIRECTORY_SEPARATOR .'RetrievePaymentInstrument.php';
  $tokenId = RetrievePaymentInstrument(true);
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->updatePaymentInstrument($profileId, $tokenId, $tmsRequest);
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
