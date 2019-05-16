<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function UpdateInstrumentIdentifier()
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();
	$apiclient = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\InstrumentIdentifierApi($apiclient);
	
  $merchantInitiatedTransactionArr = [
      "previousTransactionId" => "123456789012345"
      
  ];
  $merchantInitiatedTransaction = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseMerchantInitiatedTransaction($merchantInitiatedTransactionArr);


  $initiatorInfoArr = [
      "merchantInitiatedTransaction" => $merchantInitiatedTransaction
      
  ];
  $initiatorInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseProcessingInformationAuthorizationOptionsInitiator($initiatorInfoArr);

  $authorizationOptionsArr = [
      'initiator' => $initiatorInformation
      
  ];
  $authorizationOptions = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseProcessingInformationAuthorizationOptions( $authorizationOptionsArr);

  $processingInformationArr = [
      "authorizationOptions" => $authorizationOptions
      
  ];
  $processingInformation = new CyberSource\Model\TmsV1InstrumentIdentifiersPost200ResponseProcessingInformation($processingInformationArr);

  $tmsRequestArr = [
    "processingInformation" => $processingInformation
  ];

	$tmsRequest = new CyberSource\Model\UpdateInstrumentIdentifierRequest($tmsRequestArr);
  require_once __DIR__. DIRECTORY_SEPARATOR .'RetrieveInstrumentIdentifier.php';
  $tokenId = RetrieveInstrumentIdentifier(true);
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
		$api_response = $api_instance->updateInstrumentIdentifier($profileId, $tokenId, $tmsRequest);
		echo "<pre>";print_r($api_response);

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
    }
}    

// Call Sample Code
if(!defined('DO NOT RUN SAMPLE')){
    echo "UpdateInstrumentIdentifier Samplecode is Running.. \n";
	UpdateInstrumentIdentifier();

}
?>