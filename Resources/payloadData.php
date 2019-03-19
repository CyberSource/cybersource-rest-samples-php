<?php
/*
* Purpose : Calling Authentication SDK
* Create new Payment in cybersource 
*/
namespace CybSource;
use CybSource\SampleApiClient\Model as Cybscard;

require_once '../../autoload.php';
require_once '../../AuthenticationSdk/com/cybersource/payloadDigest/payloadDigest.php';
require_once '../../AuthenticationSdk/com/cybersource/util/propertiesUtil.php';
require_once '../../SampleApiClient/controller/apiController.php';
require_once '../../SampleApiClient/Model/V2paymentsPaymentInformationCard.php';
require_once '../../SampleApiClient/Model/V2paymentsPaymentInformation.php';
require_once '../../SampleApiClient/Model/V2paymentsOrderInformation.php';
require_once '../../SampleApiClient/Model/V2paymentsOrderInformationBillTo.php';
require_once '../../SampleApiClient/Model/V2paymentsOrderInformationAmountDetails.php';
require_once '../../SampleApiClient/Model/V2paymentsAggregatorInformation.php';
require_once '../../SampleApiClient/Model/V2paymentsAggregatorInformationSubMerchant.php';
require_once '../../SampleApiClient/Model/V2creditsProcessingInformation.php';
require_once '../../SampleApiClient/Model/V2paymentsClientReferenceInformation.php';
require_once '../../SampleApiClient/Model/Request.php';
require_once '../../AuthenticationSdk/com/cybersource/core/merchantConfig.php';

class PayloadData
{
  //Calling post method for payment creation
  public function payloadData()
  {
    
    $getConfig = new PropertiesUtil();
    $getConfigDet = $getConfig->readConfig();

    if($getConfigDet != null){
      require_once '../../AuthenticationSdk/com/cybersource/core/merchantConfig.php';
      $merchantConfig = new MerchantConfiguration();
      //Set the cybs properties value in merchant config
      $merchantConfigObj = $merchantConfig->setMerchantCredentials($getConfigDet);
    }else{
      //calling the merchant config Object
      require_once '../../CybersourceAuthenticationSdkPhp/resource/Configuration.php';
      $merObj = new Configuration();
      $merchantConfigObj = $merObj->merchantConfigObject();
    }
   
    $creditDet = array(
    	
        "number" => "5555555555554444",
        "expirationMonth" => "12",
        "expirationYear" => "2031",
        "type" => "002",
        "securityCode" => "123"
    );
    $creditCard = new Cybscard\V2paymentsPaymentInformationCard($creditDet);
    $paymentInfo  = array(
    	"card" =>$creditCard
    );
    $paymentInformation = new Cybscard\V2paymentsPaymentInformation($paymentInfo);

    $billtoArr = array(
    	'firstName' => 'RTS',
      'lastName' => 'VDP',
      'company' => 'string',
      'address1' => '201 S. Division St.',
      'address2' => 'Address 2',
      'locality' => 'Ann Arbor',
      'administrativeArea' => 'MI',
      'postalCode' => '48104-2201',
      'country' => 'US',
      'district' => 'MI',
      'buildingNumber' => '123',
      'email' => 'test@cybs.com',
      'phoneNumber' => '999999999');
    $orderInfoBillTo = new Cybscard\V2paymentsOrderInformationBillTo($billtoArr);
    $amountDetArr = array(
    	"totalAmount"=> "102.21",
	    "currency"=> "USD"
  	);
  	$amountInfo = new Cybscard\V2paymentsOrderInformationAmountDetails($amountDetArr);
  	$orderInfoArr = array(
  		'amountDetails' => $amountInfo,
      'billTo' => $orderInfoBillTo
    );
  	$orderInformation = new Cybscard\V2paymentsOrderInformation($orderInfoArr);
	
  	$aggregatorInfoSubMerArr =array(
  		'cardAcceptorId' => '1234567890',
        'name' => 'Visa Inc',
        'address1' => '900 Metro Center',
        'locality' => 'Foster City',
        'administrativeArea' => 'CA',
        'region' => 'PEN',
        'postalCode' => '94404-2775',
        'country' => 'US',
        'email' => 'test@cybs.com',
        'phoneNumber' => '650-432-0000'
  	);
  	$aggregatorInfoSubMer = new Cybscard\V2paymentsAggregatorInformationSubMerchant($aggregatorInfoSubMerArr);
  	$aggregatorInfoArr = array(
		  'aggregatorId' => '123456789',
      'name' => 'V-Internatio',
      'subMerchant' => $aggregatorInfoSubMer
  	);
  	$aggregatorInfo = new Cybscard\V2paymentsAggregatorInformation($aggregatorInfoArr);

  	$processingInfoArr = array(
		  'commerceIndicator' => 'internet'
  	);
  	$processingInfo = new Cybscard\V2creditsProcessingInformation($processingInfoArr);

  	$clientRefInfoArr = array(
		  'code' => 'TC50171_3'
  	);
  	$clientRefInfo = new Cybscard\V2paymentsClientReferenceInformation($clientRefInfoArr);
	

  	$createPaymentArr = array(
  		'clientReferenceInformation' => $clientRefInfo,
      'processingInformation' => $processingInfo,
      'paymentInformation' => $paymentInformation,
      'orderInformation' => $orderInformation,
      'aggregatorInformation' => $aggregatorInfo
  	);
  	$payloadData = new Cybscard\Request($createPaymentArr);
  	$payloaddataArr = json_decode($payloadData);
  	$payload = json_encode($payloaddataArr, JSON_FORCE_OBJECT);
    return $payload;
    
  }
}
$obj = new PayloadData();
$obj->payloadData();
?>