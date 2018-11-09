<?php
//echo "Inside php functionality"
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('./Resources/ExternalConfiguration.php');

function CreateInstrumentIdentifier()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifiersApi($apiclient);
	
  $tmsCardInfo = [
    "number" => "1234567890987654"
  ];
  $card = new CyberSource\Model\Tmsv1instrumentidentifiersCard($tmsCardInfo);
  $merchantInitiatedTransactionArr = [
      "previousTransactionId" => "123456789012345"
      
  ];
  $merchantInitiatedTransaction = new CyberSource\Model\Tmsv1InitiatorMerchantInitiatedTransaction($merchantInitiatedTransactionArr);


  $initiatorInfoArr = [
      "merchantInitiatedTransaction" => $merchantInitiatedTransaction
      
  ];
  $initiatorInformation = new CyberSource\Model\Tmsv1instrumentidentifiersProcessingInformationAuthorizationOptionsInitiator($initiatorInfoArr);

  $authorizationOptionsArr = [
      'initiator' => $initiatorInformation
      
  ];
  $authorizationOptions = new CyberSource\Model\Tmsv1instrumentidentifiersProcessingInformationAuthorizationOptions( $authorizationOptionsArr);

  $processingInformationArr = [
      "authorizationOptions" => $authorizationOptions
      
  ];
  $processingInformation = new CyberSource\Model\Tmsv1instrumentidentifiersProcessingInformation($processingInformationArr);

  $tmsRequestArr = [
    "card" => $card,
    "processingInformation" => $processingInformation
  ];

	$tmsRequest = new CyberSource\Model\Body($tmsRequestArr);
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->tmsV1InstrumentidentifiersPost($profileId, $tmsRequest);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
    print_r($e->getMessage());
	}
}    

// Call Sample Code
if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "Samplecode is Running..";
	CreateInstrumentIdentifier();

}
?>	
