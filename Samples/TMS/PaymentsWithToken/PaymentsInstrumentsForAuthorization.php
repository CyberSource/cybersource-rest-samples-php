<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('../CybersourceRestclientPHP/autoload.php');
require_once('../CybersourceRestclientPHP/ExternalConfig.php');

function CreateInstrumentIdentifier()
{
	$commonElement = new CyberSource\ExternalConfig();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
	
  $tmsCardInfo = [
    "number" => "1234567890987654"
  ];
  $card = new CyberSource\Model\InstrumentidentifiersCard($tmsCardInfo);
  $merchantInitiatedTransactionArr = [
      "previousTransactionId" => "123456789012345"
      
  ];
  $merchantInitiatedTransaction = new CyberSource\Model\InstrumentidentifiersProcessingInformationAuthorizationOptionsInitiatorMerchantInitiatedTransaction($merchantInitiatedTransactionArr);


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
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->instrumentidentifiersPost($profileId, $tmsRequest);
		echo "<pre>";print_r($api_response);

	} catch (Exception $e) {
    print_r($e->getmessage());
	}
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "Samplecode is Running..";
	CreateInstrumentIdentifier();

}
?>	
