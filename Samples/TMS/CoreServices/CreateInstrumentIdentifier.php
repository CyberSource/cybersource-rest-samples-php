<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function CreateInstrumentIdentifier($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
	
  $tmsCardInfo = [
    "number" => "1234567890987200"
  ];
  $card = new CyberSource\Model\InstrumentidentifiersCard($tmsCardInfo);
  $merchantInitiatedTransactionArr = [
      "previousTransactionId" => "123456789012345"
      
  ];
  $merchantInitiatedTransaction = new CyberSource\Model\MerchantInitiatedTransaction($merchantInitiatedTransactionArr);


  $initiatorInfoArr = [
      "merchantInitiatedTransaction" => $merchantInitiatedTransaction
      
  ];
  $initiatorInformation = new CyberSource\Model\InstrumentidentifiersProcessingInformationAuthorizationOptionsInitiator($initiatorInfoArr);

  $authorizationOptionsArr = [
      'initiator' => $initiatorInformation
      
  ];
  $authorizationOptions = new CyberSource\Model\InstrumentidentifiersProcessingInformationAuthorizationOptions( $authorizationOptionsArr);

  $processingInformationArr = [
      "authorizationOptions" => $authorizationOptions
      
  ];
  $processingInformation = new CyberSource\Model\InstrumentidentifiersProcessingInformation($processingInformationArr);

  $tmsRequestArr = [
    "card" => $card,
    "processingInformation" => $processingInformation
  ];

	$tmsRequest = new CyberSource\Model\Body($tmsRequestArr);
  //print_r($tmsRequest);die;
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->instrumentidentifiersPost($profileId, $tmsRequest);
		if($flag == true){
      //Returning the ID
        echo "Fetching CreateInstrumentIdentifier ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }else{
      print_r($api_response);
    }

	} catch (Cybersource\ApiException $e) {
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	CreateInstrumentIdentifier(false);

}
?>	
