<?php
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../vendor/autoload.php';
require_once __DIR__. DIRECTORY_SEPARATOR .'../../../Resources/ExternalConfiguration.php';

function CreateInstrumentIdentifier($flag)
{
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$apiclient = new CyberSource\ApiClient($config);
	$api_instance = new CyberSource\Api\InstrumentIdentifiersApi($apiclient);
	
  $tmsCardInfo = [
    "number" => "1234567890987200"
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
  $requestArr = json_decode($tmsRequest);
  $requestBody = $apiclient->dataMasking(json_encode($paymentrqstArr, JSON_UNESCAPED_SLASHES));
  echo "The Request Payload : \n".$requestBody."\n\n";
  $profileId = '93B32398-AD51-4CC2-A682-EA3E93614EB1';
	
 	$api_response = list($response,$statusCode,$httpHeader)=null;
	try {
    $api_response = $api_instance->tmsV1InstrumentidentifiersPost($profileId, $tmsRequest);
    
  	if($flag == true){
      //Returning the ID
      echo "Fetching CreateInstrumentIdentifier ID: ".$api_response[0]['id']."\n";
      return $api_response[0]['id'];
    }else{
      echo "The API Request Header: \n". json_encode($config->getRequestHeaders(), JSON_UNESCAPED_SLASHES)."\n\n";
      $resBodyArr= json_decode($api_response[0]);
      echo "The Api Response Body: \n". json_encode($resBodyArr, JSON_UNESCAPED_SLASHES)."\n\n";
      echo "The Api Response StatusCode: ".json_encode($api_response[1])."\n\n";
      echo "The Api Response Header: \n".json_encode($api_response[2], JSON_UNESCAPED_SLASHES)."\n";
    }

	} catch (Cybersource\ApiException $e) {
    
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
if(!defined('DO_NOT_RUN_SAMPLES')){
  echo "[BEGIN] EXECUTION OF SAMPLE CODE: CreateInstrumentIdentifier  \n\n";
	CreateInstrumentIdentifier(false);

}
?>	
