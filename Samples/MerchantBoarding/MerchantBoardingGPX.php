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


function MerchantBoardingGPX()
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

    $productInformationArr = [];

    $selectedProductsArr = [];

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

    $commonArr = [
        "merchantCategoryCode" => "1799",
        "defaultAuthTypeCode" => "FINAL",
        "foodAndConsumerServiceId" => "1456",
        "masterCardAssignedId" => "4567",
        "sicCode" => "1345",
        "enablePartialAuth" => false,
        "allowCapturesGreaterThanAuthorizations" => false,
        "enableDuplicateMerchantReferenceNumberBlocking" => false,
        "creditCardRefundLimitPercent" => "2",
        "businessCenterCreditCardRefundLimitPercent" => "3",
        "processors" => [
            "gpx" => [
                "acquirer" => [
                    "countryCode" => "840_usa",
                    "fileDestinationBin" => "123456",
                    "interbankCardAssociationId" => "1256",
                    "institutionId" => "113366",
                    "discoverInstitutionId" => "1567"
                ],
                "currencies" => [
                    "AED" => [
                        "enabled" => true,
                        "enabledCardPresent" => false,
                        "enabledCardNotPresent" => true,
                        "terminalId" => "",
                        "serviceEnablementNumber" => ""
                    ]
                ],
                "paymentTypes" => [
                    "MASTERCARD" => ["enabled" => true],
                    "DISCOVER" => ["enabled" => true],
                    "JCB" => ["enabled" => true],
                    "VISA" => ["enabled" => true],
                    "DINERS_CLUB" => ["enabled" => true],
                    "PIN_DEBIT" => ["enabled" => true]
                ],
                "allowMultipleBills" => true,
                "batchGroup" => "gpx",
                "businessApplicationId" => "AA",
                "enhancedData" => "disabled",
                "fireSafetyIndicator" => false,
                "abaNumber" => "1122445566778",
                "merchantVerificationValue" => "234",
                "quasiCash" => false,
                "merchantId" => "112233",
                "terminalId" => "112244"
            ]
        ]
    ];

    $configurationsArr = [
        "common" => $commonArr,
        "features" => [
            "cardNotPresent" => [
                "processors" => [
                    "gpx" => [
                        "enableEmsTransactionRiskScore" => true,
                        "relaxAddressVerificationSystem" => true,
                        "relaxAddressVerificationSystemAllowExpiredCard" => true,
                        "relaxAddressVerificationSystemAllowZipWithoutCountry" => true
                    ]
                ],
                "visaStraightThroughProcessingOnly" => false,
                "ignoreAddressVerificationSystem" => false
            ],
            "cardPresent" => [
                "processors" => [
                    "gpx" => [
                        "financialInstitutionId" => "1347",
                        "pinDebitNetworkOrder" => "23456",
                        "pinDebitReimbursementCode" => "43567",
                        "defaultPointOfSaleTerminalId" => "5432"
                    ]
                ],
                "enableTerminalIdLookup" => false
            ]
        ]
    ];

    $cardProcessingArr["configurations"] = $configurationsArr;
    $cardProcessingArr["templateId"] = "D2A7C000-5FCA-493A-AD21-469744A19EEA";
    $paymentsArr["cardProcessing"] = $cardProcessingArr;

    $virtualTerminalArr = [
        "subscriptionInformation" => ["enabled" => true],
        "configurationInformation" => ["templateId" => "9FA1BB94-5119-48D3-B2E5-A81FD3C657B5"]
    ];

    $paymentsArr["virtualTerminal"] = $virtualTerminalArr;

    $customerInvoicingArr = [
        "subscriptionInformation" => ["enabled" => true]
    ];

    $paymentsArr["customerInvoicing"] = $customerInvoicingArr;

    $selectedProductsArr["payments"] = $paymentsArr;

    $riskArr = [];

    $selectedProductsArr["risk"] = $riskArr;

    $commerceSolutionsArr = [
        "tokenManagement" => [
            "subscriptionInformation" => ["enabled" => true],
            "configurationInformation" => ["templateId" => "D62BEE20-DCFD-4AA2-8723-BA3725958ABA"]
        ]
    ];

    $selectedProductsArr["commerceSolutions"] = $commerceSolutionsArr;

    $valueAddedServicesArr = [
        "transactionSearch" => [
            "subscriptionInformation" => ["enabled" => true]
        ],
        "reporting" => [
            "subscriptionInformation" => ["enabled" => true]
        ]
    ];

    $selectedProductsArr["valueAddedServices"] = $valueAddedServicesArr;

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
    MerchantBoardingGPX();
}
?>
