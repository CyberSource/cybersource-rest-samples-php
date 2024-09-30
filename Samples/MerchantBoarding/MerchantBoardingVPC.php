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


function MerchantBoardingVPC()
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

    // Payments Products
    $paymentsArr = [];

    // Card Processing
    $cardProcessingArr = [];
    $subscriptionInformationArr = [
        "enabled" => true,
        "features" => [
            "cardNotPresent" => ["enabled" => true],
            "cardPresent" => ["enabled" => true],
        ]
    ];

    $cardProcessingArr["subscriptionInformation"] = $subscriptionInformationArr;

    $configurationInformationArr = [];
    $configurationsArr = [];
    $commonArr = [
        "merchantCategoryCode" => "1799",
        "defaultAuthTypeCode" => 'FINAL',
        "masterCardAssignedId" => null,
        "sicCode" => null,
        "enablePartialAuth" => false,
        "enableInterchangeOptimization" => false,
        "enableSplitShipment" => false,
        "visaDelegatedAuthenticationId" => "123457",
        "domesticMerchantId" => "123458",
        "creditCardRefundLimitPercent" => "2",
        "businessCenterCreditCardRefundLimitPercent" => "3",
        "allowCapturesGreaterThanAuthorizations" => false,
        "enableDuplicateMerchantReferenceNumberBlocking" => false,
        "processors" => [
            "VPC" => [
                "acquirer" => [
                    "countryCode" => "840_usa",
                    "fileDestinationBin" => "444500",
                    "interbankCardAssociationId" => "3684",
                    "institutionId" => "444571",
                    "discoverInstitutionId" => null,
                ],
                "paymentTypes" => [
                    "VISA" => [
                        "enabled" => true,
                        "currencies" => [
                            "CAD" => [
                                "enabled" => true,
                                "enabledCardPresent" => false,
                                "enabledCardNotPresent" => true,
                                "terminalId" => "113366",
                                "merchantId" => "113355",
                                "serviceEnablementNumber" => null,
                            ],
                            "USD" => [
                                "enabled" => true,
                                "enabledCardPresent" => false,
                                "enabledCardNotPresent" => true,
                                "terminalId" => "113366",
                                "merchantId" => "113355",
                                "serviceEnablementNumber" => null,
                            ],
                        ],
                    ],
                ],
                "acquirerMerchantId" => "123456",
                "allowMultipleBills" => false,
                "batchGroup" => "vdcvantiv_est_00",
                "businessApplicationId" => "AA",
                "enableAutoAuthReversalAfterVoid" => true,
                "enableExpresspayPanTranslation" => null,
                "merchantVerificationValue" => "123456",
                "quasiCash" => false,
                "enableTransactionReferenceNumber" => true,
            ],
        ],
    ];

    $featuresArr = [
        "cardNotPresent" => [
            "processors" => [
                "VPC" => [
                    "enableEmsTransactionRiskScore" => null,
                    "relaxAddressVerificationSystem" => true,
                    "relaxAddressVerificationSystemAllowExpiredCard" => true,
                    "relaxAddressVerificationSystemAllowZipWithoutCountry" => true,
                ],
            ],
            "visaStraightThroughProcessingOnly" => false,
            "ignoreAddressVerificationSystem" => true,
        ],
        "cardPresent" => [
            "processors" => [
                "VPC" => [
                    "defaultPointOfSaleTerminalId" => "223344",
                ],
            ],
            "enableTerminalIdLookup" => false,
        ],
    ];

    $configurationsArr["common"] = $commonArr;
    $configurationsArr["features"] = $featuresArr;
    $configurationInformationArr["configurations"] = $configurationsArr;
    $configurationInformationArr["templateId"] = "D671CE88-2F09-469C-A1B4-52C47812F792";

    $cardProcessingArr["configurationInformation"] = $configurationInformationArr;
    $paymentsArr["cardProcessing"] = $cardProcessingArr;

    // Virtual Terminal
    $virtualTerminalArr = [
        "subscriptionInformation" => [
            "enabled" => true,
        ],
        "configurationInformation" => [
            "templateId" => "9FA1BB94-5119-48D3-B2E5-A81FD3C657B5",
        ],
    ];

    $paymentsArr["virtualTerminal"] = $virtualTerminalArr;

    // Customer Invoicing
    $customerInvoicingArr = [
        "subscriptionInformation" => [
            "enabled" => true,
        ],
    ];

    $paymentsArr["customerInvoicing"] = $customerInvoicingArr;

    $selectedProductsArr = [
        "payments" => $paymentsArr,
        "risk" => [],
        "commerceSolutions" => [
            "tokenManagement" => [
                "subscriptionInformation" => [
                    "enabled" => true,
                ],
                "configurationInformation" => [
                    "templateId" => "D62BEE20-DCFD-4AA2-8723-BA3725958ABA",
                ],
            ],
        ],
        "valueAddedServices" => [
            "transactionSearch" => [
                "subscriptionInformation" => [
                    "enabled" => true,
                ],
            ],
            "reporting" => [
                "subscriptionInformation" => [
                    "enabled" => true,
                ],
            ],
        ],
    ];

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
    MerchantBoardingVPC();
}
?>
