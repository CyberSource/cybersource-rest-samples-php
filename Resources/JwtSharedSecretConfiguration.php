<?php
/*
* Purpose : Configuration for JWT authentication with Shared Secret (symmetric / HS256).
*
* Why JWT with Shared Secret?
*   - HTTP Signature is being deprecated. JWT with Shared Secret provides a
*     seamless migration path — it uses the SAME apiKeyID and secretKey
*     credentials you already have for HTTP Signature.
*   - Enables MLE (Message Level Encryption). MLE requires JWT authentication.
*     By switching to JWT with Shared Secret, you can enable MLE without managing
*     a P12 certificate file.
*   - Zero credential changes. Your existing Key ID and Shared Secret from the
*     CyberSource Business Center work as-is.
*
* Credentials:
*   The apiKeyID and secretKey are the same credentials used for HTTP Signature
*   authentication. You can obtain them from the CyberSource Business Center:
*     Test: https://businesscentertest.cybersource.com/ebc2
*     Prod: https://businesscenter.cybersource.com/ebc2
*/

namespace CyberSource;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

class JwtSharedSecretConfiguration
{
    private $merchantConfig;

    // Logging
    private $enableLogging;
    private $debugLogFile;
    private $errorLogFile;
    private $logDateFormat;
    private $logFormat;
    private $logMaxFiles;
    private $logLevel;
    private $enableMasking;

    //initialize variable on constructor
    function __construct()
    {
        // Logging
        $this->enableLogging = true;
        $this->debugLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log";
        $this->errorLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log";
        $this->logDateFormat = "Y-m-d\TH:i:s";
        $this->logFormat = "[%datetime%] [%level_name%] [%channel%] : %message%\n";
        $this->logMaxFiles = 3;
        $this->logLevel = "debug";
        $this->enableMasking = true;

        $this->merchantConfigObject();
    }

    // ---------------------------------------------------------------
    // Helper: build and return a LogConfiguration
    // ---------------------------------------------------------------
    private function buildLogConfiguration()
    {
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $logConfiguration->setLogDateFormat($this->logDateFormat);
        $logConfiguration->setLogFormat($this->logFormat);
        $logConfiguration->setLogMaxFiles($this->logMaxFiles);
        $logConfiguration->setLogLevel($this->logLevel);
        $logConfiguration->enableMasking($this->enableMasking);
        return $logConfiguration;
    }

    // ===============================================================
    // merchantConfigObject — JWT with Shared Secret (no MLE)
    //
    // This is a drop-in replacement for HTTP Signature authentication.
    // The only changes from a typical HTTP Signature configuration are:
    //   1. authenticationType = JWT (instead of http_signature)
    //   2. jwtKeyType = SHARED_SECRET (new property)
    //
    // The apiKeyID and secretKey remain the same.
    // ===============================================================
    function merchantConfigObject()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();

            // Authentication: JWT with Shared Secret (HS256)
            $config->setAuthenticationType("JWT");
            $config->setJwtKeyType("SHARED_SECRET");

            $config->setMerchantID("testrest");
            $config->setRunEnvironment("apitest.cybersource.com");

            // Shared Secret credentials — same as HTTP Signature credentials
            $config->setApiKeyID("08c94330-f618-42a3-b09d-e1e43be5efda");
            $config->setSecretKey("yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=");

            // MetaKey Parameters
            $config->setUseMetaKey(false);
            $config->setPortfolioID("");

            $config->setLogConfiguration($this->buildLogConfiguration());
            $config->validateMerchantData();
            $this->merchantConfig = $config;
        }
        return $this->merchantConfig;
    }

    // ===============================================================
    // merchantConfigObjectWithMLE — JWT with Shared Secret + MLE enabled
    //
    // This configuration enables Message Level Encryption (MLE) for
    // request payloads. Response MLE is also supported — set
    // enableResponseMleGlobally to true and provide the response MLE
    // private key settings.
    //
    // When using jwtKeyType=SHARED_SECRET, Request MLE requires the
    // public certificate to be provided via mleForRequestPublicCertPath
    // because there is no P12 file to auto-extract it from.
    //
    // Download the MLE public certificate from the CyberSource
    // Business Center:
    //   Test: https://businesscentertest.cybersource.com/ebc2
    //   Prod: https://businesscenter.cybersource.com/ebc2
    // ===============================================================
    function merchantConfigObjectWithMLE()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();

        // Authentication: JWT with Shared Secret (HS256)
        $config->setAuthenticationType("JWT");
        $config->setJwtKeyType("SHARED_SECRET");

        $config->setMerchantID("testrest");
        $config->setRunEnvironment("apitest.cybersource.com");

        // Shared Secret credentials — same as HTTP Signature credentials
        $config->setApiKeyID("08c94330-f618-42a3-b09d-e1e43be5efda");
        $config->setSecretKey("yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=");

        // --- Request MLE Configuration ---
        // When using SHARED_SECRET, the MLE certificate must be provided separately.
        // Download from CyberSource Business Center:
        //   Test: https://businesscentertest.cybersource.com/ebc2
        //   Prod: https://businesscenter.cybersource.com/ebc2
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        $config->setMleForRequestPublicCertPath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "MLE_PublicCert.pem");
        // $config->setRequestMleKeyAlias("CyberSource_SJC_US"); // Optional — defaults to CyberSource_SJC_US

        // --- Response MLE Configuration ---
        // Set to true to enable response MLE (encrypted responses from CyberSource).
        // Requires a private key for decryption.
        $config->setEnableResponseMleGlobally(false);
        // Provide a private key file path for response decryption.
        // Supported formats: .p12, .pfx, .pem, .key, .p8
        // $config->setResponseMlePrivateKeyFilePath(""); // e.g., "Resources/your_mle_private_key.p12"
        // $config->setResponseMlePrivateKeyFilePassword(""); // Required for .p12/.pfx or encrypted keys
        // responseMleKID: Optional for CyberSource-generated P12 files (auto-extracted).
        // Required for PEM/KEY files.
        // $config->setResponseMleKID("");

        // MetaKey Parameters
        $config->setUseMetaKey(false);
        $config->setPortfolioID("");

        $config->setLogConfiguration($this->buildLogConfiguration());
        $config->validateMerchantData();
        return $config;
    }

    // ---------------------------------------------------------------
    // ConnectionHost helpers
    // ---------------------------------------------------------------
    function ConnectionHost()
    {
        $merchantConf = $this->merchantConfigObject();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

    function ConnectionHostFrom($merchantConf)
    {
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }
}
?>
