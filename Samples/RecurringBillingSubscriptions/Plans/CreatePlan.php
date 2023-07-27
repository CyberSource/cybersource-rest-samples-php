<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreatePlan()
{
    // Required to make the sample code ActivatePlan.php work
    $planStatus = "DRAFT";

    $planInformationBillingPeriodArr = [
            "length" => "1",
            "unit" => "M"
    ];
    $planInformationBillingPeriod = new CyberSource\Model\InlineResponse200PlanInformationBillingPeriod($planInformationBillingPeriodArr);

    $planInformationBillingCyclesArr = [
            "total" => "12"
    ];
    $planInformationBillingCycles = new CyberSource\Model\Rbsv1plansPlanInformationBillingCycles($planInformationBillingCyclesArr);

    $planInformationArr = [
            "name" => "Gold Plan",
            "description" => "New Gold Plan",
            "status" => $planStatus,
            "billingPeriod" => $planInformationBillingPeriod,
            "billingCycles" => $planInformationBillingCycles
    ];
    $planInformation = new CyberSource\Model\Rbsv1plansPlanInformation($planInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD",
            "billingAmount" => "10",
            "setupFee" => "2"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Rbsv1plansOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSource\Model\Rbsv1plansOrderInformation($orderInformationArr);

    $requestObjArr = [
            "planInformation" => $planInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSource\Model\CreatePlanRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PlansApi($api_client);

    try {
        $apiResponse = $api_instance->createPlan($requestObj);
        print_r(PHP_EOL);
        print_r($apiResponse);
        WriteLogAudit($apiResponse[1]);

        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
        $errorCode = $e->getCode();
        WriteLogAudit($errorCode);
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nCreatePlan Sample Code is Running..." . PHP_EOL;
    CreatePlan();
}
?>