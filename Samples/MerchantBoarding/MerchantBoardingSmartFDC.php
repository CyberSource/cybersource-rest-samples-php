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


function MerchantBoardingSmartFDC()
{
    $reqObjArr = [];

    // Organization Information
    $organizationInformationArr = [
        "parentOrganizationId" => "apitester00",
        "type" => 'MERCHANT',
        "configurable" => true,
        "businessInformation" => [
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
        ]
    ];

    $organizationInformation = new Boardingv1registrationsOrganizationInformation($organizationInformationArr);
    $reqObjArr["organizationInformation"] = $organizationInformation;

    // Product Information
    $productInformationArr = [];
    $selectedProductsArr = [];

    // Payments
    $paymentsArr = ["cardProcessing" => [
        "subscriptionInformation" => [
            "enabled" => true,
            "features" => [
                "cardNotPresent" => ["enabled" => true],
                "cardPresent" => ["enabled" => true]
            ]
        ],
        "configurationInformation" => [
            "configurations" => [
                "common" => [
                    "merchantCategoryCode" => "1799",
                    "defaultAuthTypeCode" => "FINAL",
                    "enablePartialAuth" => true,
                    "processors" => [
                        "smartfdc" => [
                            "acquirer" => [],
                            "paymentTypes" => [
                                "MASTERCARD" => ["enabled" => true],
                                "DISCOVER" => ["enabled" => true],
                                "JCB" => ["enabled" => true],
                                "VISA" => ["enabled" => true],
                                "DINERS_CLUB" => ["enabled" => true],
                                "AMERICAN_EXPRESS" => ["enabled" => true]
                            ],
                            "batchGroup" => "smartfdc_00",
                            "merchantId" => "00001234567",
                            "terminalId" => "00007654321"
                        ]
                    ]
                ]
            ],
            "templateId" => "3173DA78-A71E-405B-B79C-928C1A9C6AB2"
        ]
    ]];

    // Virtual Terminal
    $virtualTerminalArr = [
        "subscriptionInformation" => ["enabled" => true],
        "configurationInformation" => ["templateId" => "9FA1BB94-5119-48D3-B2E5-A81FD3C657B5"]
    ];
    $paymentsArr["virtualTerminal"] = $virtualTerminalArr;

    // Customer Invoicing
    $paymentsArr["customerInvoicing"] = ["subscriptionInformation" => ["enabled" => true]];

    $selectedProductsArr["payments"] = $paymentsArr;

    // Risk
    $selectedProductsArr["risk"] = new RiskProducts();

    // Commerce Solutions
    $commerceSolutionsArr = ["tokenManagement" => [
        "subscriptionInformation" => ["enabled" => true],
        "configurationInformation" => ["templateId" => "D62BEE20-DCFD-4AA2-8723-BA3725958ABA"]
    ]];
    $selectedProductsArr["commerceSolutions"] = $commerceSolutionsArr;

    // Value Added Services
    $valueAddedServicesArr = ["transactionSearch" => ["subscriptionInformation" => ["enabled" => true]],
                            "reporting" => ["subscriptionInformation" => ["enabled" => true]]];
    $selectedProductsArr["valueAddedServices"] = $valueAddedServicesArr;

    $productInformationArr["selectedProducts"] = $selectedProductsArr;

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
    MerchantBoardingSmartFDC();
}
?>
