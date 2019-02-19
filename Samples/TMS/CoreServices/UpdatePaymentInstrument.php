<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

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
  $requestArr = json_decode($tmsRequest);
  $requestBody = $apiclient->dataMasking(json_encode($requestArr, JSON_UNESCAPED_SLASHES));
  echo "The Request Payload : \n".$requestBody."\n\n";
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
  require_once __DIR__. DIRECTORY_SEPARATOR .'RetrievePaymentInstrument.php';
  $tokenId = RetrievePaymentInstrument(true);
 	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
    
		$api_response = $api_instance->tmsV1PaymentinstrumentsTokenIdPatch($profileId, $tokenId, $tmsRequest);
		echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
		$resBodyArr= json_decode($api_response[0]);
    echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
    echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
    echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";

	}catch (Cybersource\ApiException $e) {
		  
      echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
        echo "The Exception Response Body: \n";
      print_r($e->getResponseBody()); echo "\n\n";
      echo "The Exception Response Header: \n";
      print_r($e->getResponseHeaders()); echo "\n\n";
      echo "The Exception Response Header: \n";
      print_r($e->getMessage());echo "\n\n";
    }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
  echo "[BEGIN] EXECUTION OF SAMPLE CODE: UpdatePaymentInstrument  \n\n";
	UpdatePaymentInstrument();

}
?>	
