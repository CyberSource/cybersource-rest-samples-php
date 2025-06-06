<?php

use CyberSource\Authentication\Util\JWE\JWEUtility;

require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './CreateInstrumentIdentifierCardEnrollForNetworkToken.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './PaymentCredentialsFromNetworkToken.php';



function NetworkTokenization() {
    $commonElement = new CyberSource\ExternalConfiguration();
    $merchantConfig = $commonElement->merchantConfigObject();

    try {
        // Step-I
        $instrumentIdentifierForNetworkToken = CreateInstrumentIdentifierCardEnrollForNetworkToken();
        $tokenID =  $instrumentIdentifierForNetworkToken[0]['id'];

        //Step-II
        $encodedResponse = PaymentCredentialsFromNetworkToken($tokenID)[0];

        //Step-III

        // The following method JWEUtility.decryptJWEResponse($encodedResponse, $merchantConfig) has been deprecated.
        // $decodedResponse = JWEUtility::decryptJWEResponse($encodedResponse, $merchantConfig);

        // Using the new method JWEUtility.decryptJWEResponseUsingPrivateKey($privateKey, $encodedResponse) instead
        $privateKey = file_get_contents($merchantConfig->getJwePEMFileDirectory());
        $decodedResponse = JWEUtility::decryptJWEUsingPrivateKey($privateKey, $encodedResponse);

        print_r("Decoded Response".PHP_EOL);
        print_r($decodedResponse);

    } catch (Exception $e) {
        print_r($e);
    }

}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status".PHP_EOL);
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nNetworkToken Sample Code is Running..." . PHP_EOL;
    NetworkTokenization();
}
