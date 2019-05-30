<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateInstrumentIdentifier($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
	
  $tmsCardInfo = [
    "number" => "1234567890987200"
  ];
  $card = new CyberSource\Model\Tmsv1instrumentidentifiersCard($tmsCardInfo);

  $tmsRequestArr = [
    "card" => $card
  ];

	$tmsRequest = new CyberSource\Model\CreateInstrumentIdentifierRequest($tmsRequestArr);
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
    $api_response = $api_instance->createInstrumentIdentifier($profileId, $tmsRequest);
  	if($flag == true){
      //Returning the ID
        echo "Fetching CreateInstrumentIdentifier ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }else{
      print_r($api_response);
    }

	} catch (Cybersource\ApiException $e) {
    print_r($e->getResponseBody());
    print_r($e->getMessage());
  }
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "CreateInstrumentIdentifier Samplecode is Running.. \n";
	CreateInstrumentIdentifier(false);

}
?>	
