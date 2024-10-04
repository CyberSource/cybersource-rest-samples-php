<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/MerchantBoardingConfiguration.php';

use CyberSource\Model\PostRegistrationBody;
use CyberSource\Model\Boardingv1registrationsProductInformation;
use CyberSource\Model\Boardingv1registrationsProductInformationSelectedProducts;
use CyberSource\Model\PaymentsProducts;
use CyberSource\Model\PaymentsProductsCardProcessing;
use CyberSource\Model\PaymentsProductsCardProcessingSubscriptionInformation;
use CyberSource\Model\PaymentsProductsCardProcessingSubscriptionInformationFeatures;
use CyberSource\Model\PaymentsProductsCardProcessingConfigurationInformation;
use CyberSource\Model\CardProcessingConfig;
use CyberSource\Model\CardProcessingConfigCommon;
use CyberSource\Model\CardProcessingConfigCommonMerchantDescriptorInformation;
use CyberSource\Model\CardProcessingConfigCommonProcessors;
use CyberSource\Model\CardProcessingConfigCommonAcquirer;
use CyberSource\Model\CardProcessingConfigCommonCurrencies1;
use CyberSource\Model\CardProcessingConfigCommonPaymentTypes;
use CyberSource\Model\CardProcessingConfigFeatures;
use CyberSource\Model\CardProcessingConfigFeaturesCardNotPresent;
use CyberSource\Model\PaymentsProductsVirtualTerminal;
use CyberSource\Model\PaymentsProductsPayerAuthenticationSubscriptionInformation;
use CyberSource\Model\PaymentsProductsVirtualTerminalConfigurationInformation;
use CyberSource\Model\PaymentsProductsTax;
use CyberSource\Model\RiskProducts;
use CyberSource\Model\CardProcessingConfigFeaturesCardNotPresentProcessors;
use CyberSource\Model\CommerceSolutionsProducts;
use CyberSource\Model\CommerceSolutionsProductsTokenManagement;
use CyberSource\Model\CommerceSolutionsProductsTokenManagementConfigurationInformation;
use CyberSource\Model\ValueAddedServicesProducts;
use CyberSource\Model\Boardingv1registrationsOrganizationInformation;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformation;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformationAddress;
use CyberSource\Model\Boardingv1registrationsOrganizationInformationBusinessInformationBusinessContact;


function MerchantBoardingBinLookUp()
{
    
    $reqObjArr = [];
    
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
    
    $selectedProductsArr = [
        "payments" => new PaymentsProducts(),
        "risk" => new RiskProducts(),
        "commerceSolutions" => [
            "binLookup" => [
                "subscriptionInformation" => [
                    "enabled" => true
                ],
                "configurationInformation" => [
                    "configurations" => [
                        "isPayoutOptionsEnabled" => false,
                        "isAccountPrefixEnabled" => true
                    ]
                ]
            ]
        ],
        "valueAddedServices" => new ValueAddedServicesProducts()
    ];
    
    $selectedProducts = new Boardingv1registrationsProductInformationSelectedProducts($selectedProductsArr);
    
    $productInformationArr = [
        "selectedProducts" => $selectedProducts
    ];
    
    $productInformation = new Boardingv1registrationsProductInformation($productInformationArr);
    $reqObjArr["productInformation"] = $productInformation;
    
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
    MerchantBoardingBinLookUp();
}
?>
