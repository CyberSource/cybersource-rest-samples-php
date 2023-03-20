<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function AuthorizationForIncrementalAuthorizationFlow()
{
    $processingInformationArr = [
            "capture" => false,
            "industryDataType" => "lodging"
    ];
    $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4111111111111111",
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "type" => "001"
    ];
    $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationTokenizedCardArr = [
            "securityCode" => "123"
    ];
    $paymentInformationTokenizedCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationTokenizedCard($paymentInformationTokenizedCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard,
            "tokenizedCard" => $paymentInformationTokenizedCard
    ];
    $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "20",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Smith",
            "address1" => "201 S. Division St.",
            "address2" => "Suite 500",
            "locality" => "Ann Arbor",
            "administrativeArea" => "MI",
            "postalCode" => "12345",
            "country" => "US",
            "email" => "null@cybersource.com",
            "phoneNumber" => "514-670-8700"
    ];
    $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationShipToArr = [
            "firstName" => "Olivia",
            "lastName" => "White",
            "address1" => "1295 Charleston Rd",
            "address2" => "Cube 2386",
            "locality" => "Mountain View",
            "administrativeArea" => "CA",
            "postalCode" => "94041",
            "country" => "AE",
            "phoneNumber" => "650-965-6000"
    ];
    $orderInformationShipTo = new CyberSource\Model\Ptsv2paymentsOrderInformationShipTo($orderInformationShipToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo,
            "shipTo" => $orderInformationShipTo
    ];
    $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $merchantInformationMerchantDescriptorArr = [
            "contact" => "965-6000"
    ];
    $merchantInformationMerchantDescriptor = new CyberSource\Model\Ptsv2paymentsMerchantInformationMerchantDescriptor($merchantInformationMerchantDescriptorArr);

    $merchantInformationArr = [
            "merchantDescriptor" => $merchantInformationMerchantDescriptor
    ];
    $merchantInformation = new CyberSource\Model\Ptsv2paymentsMerchantInformation($merchantInformationArr);

    $consumerAuthenticationInformationArr = [
            "cavv" => "ABCDEabcde12345678900987654321abcdeABCDE",
            "xid" => "12345678909876543210ABCDEabcdeABCDEF1234"
    ];
    $consumerAuthenticationInformation = new CyberSource\Model\Ptsv2paymentsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

    $installmentInformationArr = [
            "amount" => "1200",
            "frequency" => "W",
            "sequence" => 34,
            "totalAmount" => "2000",
            "totalCount" => 12
    ];
    $installmentInformation = new CyberSource\Model\Ptsv2paymentsInstallmentInformation($installmentInformationArr);

    $travelInformationLodgingRoom = array();
    $travelInformationLodgingRoom_0 = [
            "dailyRate" => "1.50",
            "numberOfNights" => 5
    ];
    $travelInformationLodgingRoom[0] = new CyberSource\Model\Ptsv2paymentsTravelInformationLodgingRoom($travelInformationLodgingRoom_0);

    $travelInformationLodgingRoom_1 = [
            "dailyRate" => "11.50",
            "numberOfNights" => 5
    ];
    $travelInformationLodgingRoom[1] = new CyberSource\Model\Ptsv2paymentsTravelInformationLodgingRoom($travelInformationLodgingRoom_1);

    $travelInformationLodgingArr = [
            "checkInDate" => "11062019",
            "checkOutDate" => "11092019",
            "room" => $travelInformationLodgingRoom,
            "smokingPreference" => "yes",
            "numberOfRooms" => 1,
            "numberOfGuests" => 3,
            "roomBedType" => "king",
            "roomTaxType" => "tourist",
            "roomRateType" => "sr citizen",
            "guestName" => "Tulasi",
            "customerServicePhoneNumber" => "+13304026334",
            "corporateClientCode" => "HDGGASJDGSUY",
            "additionalDiscountAmount" => "99.123456781",
            "roomLocation" => "seaview",
            "specialProgramCode" => "2",
            "totalTaxAmount" => "99.1234567891",
            "prepaidCost" => "9999999999.99",
            "foodAndBeverageCost" => "9999999999.99",
            "roomTaxAmount" => "9999999999.99",
            "adjustmentAmount" => "9999999999.99",
            "phoneCost" => "9999999999.99",
            "restaurantCost" => "9999999999.99",
            "roomServiceCost" => "9999999999.99",
            "miniBarCost" => "9999999999.99",
            "laundryCost" => "9999999999.99",
            "miscellaneousCost" => "9999999999.99",
            "giftShopCost" => "9999999999.99",
            "movieCost" => "9999999999.99",
            "healthClubCost" => "9999999999.99",
            "valetParkingCost" => "9999999999.99",
            "cashDisbursementCost" => "9999999999.99",
            "nonRoomCost" => "9999999999.99",
            "businessCenterCost" => "9999999999.99",
            "loungeBarCost" => "9999999999.99",
            "transportationCost" => "9999999999.99",
            "gratuityAmount" => "9999999999.99",
            "conferenceRoomCost" => "9999999999.99",
            "audioVisualCost" => "9999999999.99",
            "nonRoomTaxAmount" => "9999999999.99",
            "earlyCheckOutCost" => "9999999999.99",
            "internetAccessCost" => "9999999999.99"
    ];
    $travelInformationLodging = new CyberSource\Model\Ptsv2paymentsTravelInformationLodging($travelInformationLodgingArr);

    $travelInformationArr = [
            "duration" => "3",
            "lodging" => $travelInformationLodging
    ];
    $travelInformation = new CyberSource\Model\Ptsv2paymentsTravelInformation($travelInformationArr);

    $promotionInformationArr = [
            "additionalCode" => "999999.99"
    ];
    $promotionInformation = new CyberSource\Model\Ptsv2paymentsPromotionInformation($promotionInformationArr);

    $requestObjArr = [
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation,
            "consumerAuthenticationInformation" => $consumerAuthenticationInformation,
            "installmentInformation" => $installmentInformation,
            "travelInformation" => $travelInformation,
            "promotionInformation" => $promotionInformation
    ];
    $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\PaymentsApi($api_client);

    try {
        $apiResponse = $api_instance->createPayment($requestObj);
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
    echo "\nAuthorizationForIncrementalAuthorizationFlow Sample Code is Running..." . PHP_EOL;
    AuthorizationForIncrementalAuthorizationFlow();
}
?>
