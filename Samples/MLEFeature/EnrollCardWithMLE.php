<?php
/**
 * Enroll a card using the Agentic Card Enrollment API with MLE support.
 * This sample demonstrates how to use the EnrollmentApi to enroll a card
 * with comprehensive device information, buyer information, assurance data, and consent data.
 * 
 * This example uses merchantConfigObjectWithRequestAndResponseMLE1() for full request and response MLE encryption.
 * You can change to merchantConfigObjectWithRequestAndResponseMLE2() for API-level control,
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ConfigurationWithMLE.php';

function enrollCardWithMLE($flag = false)
{
    try {
        // Client Reference Information
        $clientCorrelationId = '3e1b7943-6567-4965-a32b-5aa93d057d35';
        
        // Device Information - Device Data
        $deviceInformationDeviceDataArr = [
            "type" => "Mobile",
            "manufacturer" => "Apple",
            "brand" => "Apple",
            "model" => "iPhone 16 Pro Max"
        ];
        $deviceInformationDeviceData = new CyberSource\Model\Acpv1tokensDeviceInformationDeviceData($deviceInformationDeviceDataArr);

        // Device Information
        $deviceInformationArr = [
            "userAgent" => "SampleUserAgent",
            "applicationName" => "My Magic App",
            "fingerprintSessionId" => "finSessionId",
            "country" => "US",
            "deviceData" => $deviceInformationDeviceData,
            "ipAddress" => "192.168.0.100",
            "clientDeviceId" => "000b2767814e4416999f4ee2b099491d2087"
        ];
        $deviceInformation = new CyberSource\Model\Acpv1tokensDeviceInformation($deviceInformationArr);

        // Buyer Information - Personal Identification
        $buyerInformationPersonalIdentification = array();
        $buyerInformationPersonalIdentification_0 = [
            "type" => "The identification type",
            "id" => "1"
        ];
        $buyerInformationPersonalIdentification[0] = new CyberSource\Model\Acpv1tokensBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

        // Buyer Information
        $buyerInformationArr = [
            // "language" => "en",
            "merchantCustomerId" => "3e1b7943-6567-4965-a32b-5aa93d057d35",
            "personalIdentification" => $buyerInformationPersonalIdentification
        ];
        $buyerInformation = new CyberSource\Model\Acpv1tokensBuyerInformation($buyerInformationArr);

        // Bill To Information
        $billToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "fullName" => "John Michael Doe",
            "email" => "john.doe@example.com",
            "countryCallingCode" => "1",
            "phoneNumber" => "5551234567",
            "numberIsVoiceOnly" => false,
            "country" => "US"
        ];
        $billTo = new CyberSource\Model\Acpv1tokensBillTo($billToArr);

        // Consumer Identity
        $consumerIdentityArr = [
            "identityType" => "EMAIL_ADDRESS",
            "identityValue" => "john.doe@example.com",
            "identityProvider" => "PARTNER",
            "identityProviderUrl" => "https://identity.partner.com"
        ];
        $consumerIdentity = new CyberSource\Model\Acpv1tokensConsumerIdentity($consumerIdentityArr);

        // Payment Information - Customer
        $paymentInformationCustomerArr = [
            "id" => ""
        ];
        $paymentInformationCustomer = new CyberSource\Model\Acpv1tokensPaymentInformationCustomer($paymentInformationCustomerArr);

        // Payment Information - Payment Instrument
        $paymentInformationPaymentInstrumentArr = [
            "id" => ""
        ];
        $paymentInformationPaymentInstrument = new CyberSource\Model\Acpv1tokensPaymentInformationPaymentInstrument($paymentInformationPaymentInstrumentArr);

        // Payment Information - Instrument Identifier
        $paymentInformationInstrumentIdentifierArr = [
            "id" => "4044EB915C613A82E063AF598E0AE6EF"
        ];
        $paymentInformationInstrumentIdentifier = new CyberSource\Model\Acpv1tokensPaymentInformationInstrumentIdentifier($paymentInformationInstrumentIdentifierArr);

        // Payment Information
        $paymentInformationArr = [
            "customer" => $paymentInformationCustomer,
            "paymentInstrument" => $paymentInformationPaymentInstrument,
            "instrumentIdentifier" => $paymentInformationInstrumentIdentifier
        ];
        $paymentInformation = new CyberSource\Model\Acpv1tokensPaymentInformation($paymentInformationArr);

        // Enrollment Reference Data
        $enrollmentReferenceDataArr = [
            "enrollmentReferenceType" => "TOKEN_REFERENCE_ID",
            "enrollmentReferenceProvider" => "VTS"
        ];
        $enrollmentReferenceData = new CyberSource\Model\Acpv1tokensEnrollmentReferenceData($enrollmentReferenceDataArr);

        // Assurance Data
        $assuranceData = array();
        
        // Assurance Data - Verification Events
        $assuranceDataVerificationEvents = array();
        $assuranceDataVerificationEvents[0] = "01";
        
        // Assurance Data - Authentication Context
        $assuranceDataAuthenticationContext_0Arr = [
            "action" => "AUTHENTICATE"
        ];
        $assuranceDataAuthenticationContext_0 = new CyberSource\Model\Acpv1tokensAuthenticationContext($assuranceDataAuthenticationContext_0Arr);

        // Assurance Data - Authenticated Identities
        $assuranceDataAuthenticatedIdentities_0Arr = [
            "data" => "authenticatedData",
            "provider" => "VISA_PAYMENT_PASSKEY",
            "id" => "f48ac10b-58cc-4372-a567-0e02b2c3d489"
        ];
        $assuranceDataAuthenticatedIdentities_0 = new CyberSource\Model\Acpv1tokensAuthenticatedIdentities($assuranceDataAuthenticatedIdentities_0Arr);

        // Assurance Data - Complete Object
        $assuranceData_0 = [
            "verificationType" => "DEVICE",
            "verificationEntity" => "10",
            "verificationEvents" => $assuranceDataVerificationEvents,
            "verificationMethod" => "02",
            "verificationResults" => "01",
            "verificationTimestamp" => "1735690745",
            "authenticationContext" => $assuranceDataAuthenticationContext_0,
            "authenticatedIdentities" => $assuranceDataAuthenticatedIdentities_0,
            "additionalData" => ""
        ];
        $assuranceData[0] = new CyberSource\Model\Acpv1tokensAssuranceData($assuranceData_0);

        // Consent Data
        $consentData = array();
        $consentData_0 = [
            "id" => "550e8400-e29b-41d4-a716-446655440000",
            "type" => "PERSONALIZATION",
            "source" => "CLIENT",
            "acceptedTime" => "1719169800",
            "effectiveUntil" => "1750705800"
        ];
        $consentData[0] = new CyberSource\Model\Acpv1tokensConsentData($consentData_0);

        // Create the main request object
        $requestObjArr = [
            "clientCorrelationId" => $clientCorrelationId,
            "deviceInformation" => $deviceInformation,
            "buyerInformation" => $buyerInformation,
            "billTo" => $billTo,
            "consumerIdentity" => $consumerIdentity,
            "paymentInformation" => $paymentInformation,
            "enrollmentReferenceData" => $enrollmentReferenceData,
            "assuranceData" => $assuranceData,
            "consentData" => $consentData
        ];
        $requestObj = new CyberSource\Model\AgenticCardEnrollmentRequest($requestObjArr);

        // Configure MLE
        // Use MLE configuration type 2 (globally enabled MLE with request and response encryption)
        // You can change this to merchantConfigObjectWithMLE1() or merchantConfigObjectWithMLE3()
        // depending on your MLE requirements
        $commonElement = new CyberSource\ConfigurationWithMLE();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObjectWithRequestAndResponseMLE1();

        // Create API instance and make the call
        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\EnrollmentApi($api_client);

        $apiResponse = $api_instance->enrollCard($requestObj);
        
        print_r(PHP_EOL);
        print_r("\nAPI RESPONSE CODE : " . $apiResponse[1]);
        print_r(PHP_EOL);
        print_r("\nAPI RESPONSE BODY : ");
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

if (!function_exists('WriteLogAudit')) {
    function WriteLogAudit($status) {
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nEnrollCardWithMLE Sample Code is Running..." . PHP_EOL;
    enrollCardWithMLE(false);
}
?>
