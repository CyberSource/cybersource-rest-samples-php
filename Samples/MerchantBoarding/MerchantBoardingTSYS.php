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


function MerchantBoardingTSYS()
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

    // Product Information
    $productInformationArr = [];
    $selectedProductsArr = [];

    // Payments Products
    $paymentsArr = [];
    $cardProcessingArr = [];
    $subscriptionInformationArr = [
        "enabled" => true,
        "features" => [
            "cardNotPresent" => ["enabled" => true],
            "cardPresent" => ["enabled" => true]
        ]
    ];
    $cardProcessingArr["subscriptionInformation"] = $subscriptionInformationArr;

    // Card Processing Configurations
    $configurationInformationArr = [];

    $configurationsArr = [];
    $commonArr = [
        "merchantCategoryCode" => "5999",
        "processLevel3Data" => "ignored",
        "defaultAuthTypeCode" => "FINAL",
        "enablePartialAuth" => false,
        "amexVendorCode" => "2233",
        "merchantDescriptorInformation" => [
            "city" => "cupertino",
            "country" => "USA",
            "name" => "kumar",
            "state" => "CA",
            "phone" => "888555333",
            "zip" => "94043",
            "street" => "steet1"
        ],
        "processors" => [
            "tsys" => [
                "acquirer" => [],
                "currencies" => [
                    "CAD" => [
                        "enabled" => true,
                        "enabledCardPresent" => true,
                        "enabledCardNotPresent" => true,
                        "terminalId" => "1234",
                        "serviceEnablementNumber" => ""
                    ]
                ],
                "paymentTypes" => [
                    "MASTERCARD" => ["enabled" => true],
                    "VISA" => ["enabled" => true]
                ],
                "bankNumber" => "234576",
                "chainNumber" => "223344",
                "batchGroup" => "vital_1130",
                "enhancedData" => "disabled",
                "industryCode" => "D",
                "merchantBinNumber" => "765576",
                "merchantId" => "834215123456",
                "merchantLocationNumber" => "00001",
                "storeID" => "2563",
                "vitalNumber" => "71234567",
                "quasiCash" => false,
                "sendAmexLevel2Data" => null,
                "softDescriptorType" => "1 - trans_ref_no",
                "travelAgencyCode" => "2356",
                "travelAgencyName" => "Agent"
            ]
        ]
    ];
    $configurationsArr["common"] = $commonArr;

    $featuresArr = [
        "cardNotPresent" => [
            "visaStraightThroughProcessingOnly" => false,
            "amexTransactionAdviceAddendum1" => null
        ]
    ];
    $configurationsArr["features"] = $featuresArr;

    $configurationInformationArr["configurations"] = $configurationsArr;
    $configurationInformationArr["templateId"] = "818048AD-2860-4D2D-BC39-2447654628A1";

    $cardProcessingArr["configurationInformation"] = $configurationInformationArr;
    $paymentsArr["cardProcessing"] = $cardProcessingArr;

    // Virtual Terminal
    $virtualTerminalArr = [
        "subscriptionInformation" => ["enabled" => true],
        "configurationInformation" => ["templateId" => "9FA1BB94-5119-48D3-B2E5-A81FD3C657B5"]
    ];
    $paymentsArr["virtualTerminal"] = $virtualTerminalArr;

    // Customer Invoicing
    $customerInvoicingArr = [
        "subscriptionInformation" => ["enabled" => true]
    ];
    $paymentsArr["customerInvoicing"] = $customerInvoicingArr;

    $selectedProductsArr["payments"] = $paymentsArr;

    // Risk Products
    $riskArr = [];
    $selectedProductsArr["risk"] = $riskArr;

    // Commerce Solutions Products
    $commerceSolutionsArr = [];
    $tokenManagementArr = [
        "subscriptionInformation" => ["enabled" => true],
        "configurationInformation" => ["templateId" => "D62BEE20-DCFD-4AA2-8723-BA3725958ABA"]
    ];
    $commerceSolutionsArr["tokenManagement"] = $tokenManagementArr;
    $selectedProductsArr["commerceSolutions"] = $commerceSolutionsArr;

    // Value Added Services Products
    $valueAddedServicesArr = [];

    $transactionSearchArr = [
        "subscriptionInformation" => ["enabled" => true]
    ];
    $valueAddedServicesArr["transactionSearch"] = $transactionSearchArr;

    $reportingArr = [
        "subscriptionInformation" => ["enabled" => true]
    ];
    $valueAddedServicesArr["reporting"] = $reportingArr;

    $selectedProductsArr["valueAddedServices"] = $valueAddedServicesArr;

    $productInformationArr["selectedProducts"] = $selectedProductsArr;
    $reqObjArr["productInformation"] = $productInformationArr;

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
    MerchantBoardingTSYS();
}
?>
