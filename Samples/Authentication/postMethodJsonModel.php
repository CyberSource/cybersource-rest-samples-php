<?php

use CybSource\SampleApiClient\Model as SampleModels;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/controller/apiController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsPaymentInformationCard.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsPaymentInformation.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsOrderInformation.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsOrderInformationBillTo.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsOrderInformationAmountDetails.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsAggregatorInformation.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsAggregatorInformationSubMerchant.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2creditsProcessingInformation.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/V2paymentsClientReferenceInformation.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../lib/SampleApiClient/Model/Request.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/cybersource/rest-client-php/lib/Authentication/PayloadDigest/PayloadDigest.php';

class PostMethodJsonModel
{
    public function postJsonModel()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';
        $merObj            = new CyberSource\ExternalConfiguration();
        $merchantConfigObj = $merObj->merchantConfigObject();

        $creditDet        = array(
            "number" => "5555555555554444",
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "type" => "002",
            "securityCode" => "123"
        );
        $creditCard         = new SampleModels\V2paymentsPaymentInformationCard($creditDet);

        $paymentInfo        = array(
            "card" => $creditCard
        );
        $paymentInformation = new SampleModels\V2paymentsPaymentInformation($paymentInfo);

        $billtoArr        = array(
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
            'phoneNumber' => '999999999'
        );
        $orderInfoBillTo  = new SampleModels\V2paymentsOrderInformationBillTo($billtoArr);

        $amountDetArr     = array(
            "totalAmount" => "102.21",
            "currency" => "USD"
        );
        $amountInfo       = new SampleModels\V2paymentsOrderInformationAmountDetails($amountDetArr);

        $orderInfoArr     = array(
            'amountDetails' => $amountInfo,
            'billTo' => $orderInfoBillTo
        );
        $orderInformation = new SampleModels\V2paymentsOrderInformation($orderInfoArr);

        $aggregatorInfoSubMerArr = array(
            'cardAcceptorId' => '1234567890',
            'name' => 'ABC Company',
            'address1' => '900 Metro Center',
            'locality' => 'Foster City',
            'administrativeArea' => 'CA',
            'region' => 'PEN',
            'postalCode' => '94404-2775',
            'country' => 'US',
            'email' => 'test@cybs.com',
            'phoneNumber' => '650-432-0000'
        );
        $aggregatorInfoSubMer    = new SampleModels\V2paymentsAggregatorInformationSubMerchant($aggregatorInfoSubMerArr);

        $aggregatorInfoArr       = array(
            'aggregatorId' => '123456789',
            'name' => 'V-Internatio',
            'subMerchant' => $aggregatorInfoSubMer
        );
        $aggregatorInfo          = new SampleModels\V2paymentsAggregatorInformation($aggregatorInfoArr);

        $processingInfoArr = array(
            'commerceIndicator' => 'internet'
        );
        $processingInfo    = new SampleModels\V2creditsProcessingInformation($processingInfoArr);

        $clientRefInfoArr = array(
            'code' => 'TC50171_3'
        );
        $clientRefInfo    = new SampleModels\V2paymentsClientReferenceInformation($clientRefInfoArr);

        $createPaymentArr = array(
            'clientReferenceInformation' => $clientRefInfo,
            'processingInformation' => $processingInfo,
            'paymentInformation' => $paymentInformation,
            'orderInformation' => $orderInformation,
            'aggregatorInformation' => $aggregatorInfo
        );
        $payloadData      = new SampleModels\Request($createPaymentArr);

        $payloaddataArr   = json_decode($payloadData);
        $payload          = json_encode($payloaddataArr, JSON_FORCE_OBJECT);

        $requestTarget    = "/pts/v2/payments";
        $api_response     = list($response, $statusCode, $httpHeader) = null;
        try {
            $api_instance = new CybSource\ApiController();
            $api_response = $api_instance->apiController("POST", $payload, $requestTarget, $merchantConfigObj);

            print_r($api_response);
            WriteLogAudit($api_response[1]);
            die;
        }
        catch (Exception $e) {
            WriteLogAudit((explode(" ", $e->getresponseHeaders()[0]))[1]);
            print_r($e->getresponseBody());
        }
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status\n");
    }
}

$obj = new PostMethodJsonModel();
$obj->postJsonModel();

?>