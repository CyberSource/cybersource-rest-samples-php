<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/MerchantBoardingConfiguration.php';



use CyberSource\Model\PostRegistrationBody;
use CyberSource\Model\Boardingv1registrationsOrganizationInformation;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformation;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformationAddress;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformationBusinessContact;
use CyberSource\Model\Boardingv1registrationsProductInformation;
use CyberSource\Model\Boardingv1registrationsProductInformationSelectedProducts;
use CyberSource\Model\PaymentsProducts;
use CyberSource\Model\PaymentsProductsPayerAuthentication;
use CyberSource\Model\PaymentsProductsPayerAuthenticationSubscriptionInformation;
use CyberSource\Model\PaymentsProductsPayerAuthenticationConfigurationInformation;
use CyberSource\Model\PayerAuthConfig;
use CyberSource\Model\PayerAuthConfigCardTypes;
use CyberSource\Model\PayerAuthConfigCardTypesVerifiedByVisa;
use CyberSource\Model\PayerAuthConfigCardTypesVerifiedByVisaCurrencies;
use CyberSource\Model\PaymentsProductsCardProcessing;
use CyberSource\Model\PaymentsProductsCardProcessingSubscriptionInformation;
use CyberSource\Model\PaymentsProductsCardProcessingSubscriptionInformationFeatures;
use CyberSource\Model\PaymentsProductsCardProcessingConfigurationInformation;
use CyberSource\Model\CardProcessingConfig;
use CyberSource\Model\CardProcessingConfigCommon;
use CyberSource\Model\CardProcessingConfigCommonMerchantDescriptorInformation;
use CyberSource\Model\CardProcessingConfigCommonProcessors;
use CyberSource\Model\CardProcessingConfigFeatures;
use CyberSource\Model\CardProcessingConfigFeaturesCardNotPresent;
use CyberSource\Model\PaymentsProductsVirtualTerminal;
use CyberSource\Model\PaymentsProductsTax;
use CyberSource\Model\PaymentsProductsPayouts;
use CyberSource\Model\CommerceSolutionsProducts;
use CyberSource\Model\CommerceSolutionsProductsTokenManagement;
use CyberSource\Model\RiskProducts;
use CyberSource\Model\RiskProductsFraudManagementEssentials;
use CyberSource\Model\RiskProductsFraudManagementEssentialsConfigurationInformation;



function CreateRegistration()
{
    $reqObjArr = [];

    // Organization Information
    $organizationInformationArr = [
        "parentOrganizationId" => "apitester00",
        "type" => 'MERCHANT',
        "configurable" => true
    ];

    $businessInformationArr = [
        "name" => "StuartWickedFastEatz",
        "address" => [
            "country" => "US",
            "address1" => "123456 SandMarket",
            "locality" => "ORMOND BEACH",
            "administrativeArea" => "FL",
            "postalCode" => "32176"
        ],
        "websiteUrl" => "https://www.StuartWickedEats.com",
        "phoneNumber" => "6574567813",
        "businessContact" => [
            "firstName" => "Stuart",
            "lastName" => "Stuart",
            "phoneNumber" => "6574567813",
            "email" => "svc_email_bt@corpdev.visa.com"
        ],
        "merchantCategoryCode" => "5999"
    ];

    $organizationInformationArr["businessInformation"] = $businessInformationArr;
    $organizationInformation = new Boardingv1registrationsOrganizationInformation($organizationInformationArr);
    $reqObjArr["organizationInformation"] = $organizationInformation;

    // Product Information
    $productInformationArr = [];
    $selectedProductsArr = [];

    // Payments
    $paymentsArr = [];

    // Payer Authentication
    $payerAuthenticationArr = [];
    $subscriptionInformationArr = ["enabled" => true];
    $payerAuthenticationArr["subscriptionInformation"] = $subscriptionInformationArr;

    $configurationInformationArr = [];
    $configurationsArr = [];
    $cardTypesArr = [];
    $verifiedByVisaArr = [];
    $currenciesArr = [
        [
            "currencyCodes" => ["ALL"],
            "acquirerId" => "469216",
            "processorMerchantId" => "678855"
        ]
    ];
    $verifiedByVisaArr["currencies"] = $currenciesArr;
    $cardTypesArr["verifiedByVisa"] = $verifiedByVisaArr;
    $configurationsArr["cardTypes"] = $cardTypesArr;
    $configurationInformationArr["configurations"] = $configurationsArr;
    $payerAuthenticationArr["configurationInformation"] = $configurationInformationArr;
    $paymentsArr["payerAuthentication"] = $payerAuthenticationArr;

    // Card Processing
    $cardProcessingArr = [];
    $subscriptionInformation2Arr = ["enabled" => true];
    $featuresArr = ["cardNotPresent" => ["enabled" => true]];
    $subscriptionInformation2Arr["features"] = $featuresArr;
    $cardProcessingArr["subscriptionInformation"] = $subscriptionInformation2Arr;

    $configurationInformation2Arr = [];
    $configurations2Arr = [];
    $commonArr = [
        "merchantCategoryCode" => "1234",
        "merchantDescriptorInformation" => [
            "name" => "r4ef",
            "city" => "Bellevue",
            "country" => "US",
            "phone" => "4255547845",
            "state" => "WA",
            "street" => "StreetName",
            "zip" => "98007"
        ]
    ];
    $processorsArr = [
        "tsys" => [
            "merchantId" => "123456789101",
            "terminalId" => "1231",
            "industryCode" => "D",
            "vitalNumber" => "71234567",
            "merchantBinNumber" => "123456",
            "merchantLocationNumber" => "00001",
            "storeID" => "1234",
            "settlementCurrency" => "USD"
        ]
    ];
    $commonArr["processors"] = $processorsArr;
    $configurations2Arr["common"] = $commonArr;

    $features2Arr = [];
    $cardNotPresentArr = ["visaStraightThroughProcessingOnly" => true];
    $features2Arr["cardNotPresent"] = $cardNotPresentArr;
    $configurations2Arr["features"] = $features2Arr;
    $configurationInformation2Arr["configurations"] = $configurations2Arr;
    $cardProcessingArr["configurationInformation"] = $configurationInformation2Arr;
    $paymentsArr["cardProcessing"] = $cardProcessingArr;

    // Virtual Terminal
    $virtualTerminalArr = ["subscriptionInformation" => ["enabled" => true]];
    $paymentsArr["virtualTerminal"] = $virtualTerminalArr;

    // Customer Invoicing
    $customerInvoicingArr = ["subscriptionInformation" => ["enabled" => true]];
    $paymentsArr["customerInvoicing"] = $customerInvoicingArr;

    // Payouts
    $payoutsArr = ["subscriptionInformation" => ["enabled" => true]];
    $paymentsArr["payouts"] = $payoutsArr;

    $selectedProductsArr["payments"] = $paymentsArr;

    // Commerce Solutions
    $commerceSolutionsArr = [];
    $tokenManagementArr = ["subscriptionInformation" => ["enabled" => true]];
    $commerceSolutionsArr["tokenManagement"] = $tokenManagementArr;
    $selectedProductsArr["commerceSolutions"] = $commerceSolutionsArr;

    // Risk
    $riskArr = [];
    $fraudManagementEssentialsArr = ["subscriptionInformation" => ["enabled" => true]];
    $configurationInformation5Arr = ["templateId" => "E4EDB280-9DAC-4698-9EB9-9434D40FF60C"];
    $fraudManagementEssentialsArr["configurationInformation"] = $configurationInformation5Arr;
    $riskArr["fraudManagementEssentials"] = $fraudManagementEssentialsArr;

    $selectedProductsArr["risk"] = $riskArr;

    $productInformationArr["selectedProducts"] = $selectedProductsArr;
    $reqObjArr["productInformation"] = new Boardingv1registrationsProductInformation($productInformationArr);

    $reqObj = new PostRegistrationBody($reqObjArr);
   

    $commonElement = new CyberSource\MerchantBoardingConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantBoardingConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\MerchantBoardingApi($api_client);

    try {
        $apiResponse = $api_instance->postRegistration($reqObj);
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

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\Merchant Boarding Sample Code is Running..." . PHP_EOL;
    CreateRegistration();
}
?>
