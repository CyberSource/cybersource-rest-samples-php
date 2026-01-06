<?php
/*
* Purpose : passing Authentication config object to the configuration
*/
namespace CyberSource;
require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';

class ConfigurationWithMLE
{
    private $merchantConfig;
    private $intermediateMerchantConfig;

    private $authType;
    private $merchantID;
    private $apiKeyID;
    private $secretKey;
    private $useMetaKey;
    private $portfolioID;
    private $keyAlias;
    private $keyPass;
    private $keyFilename;
    private $keyDirectory;
    private $runEnv;
    private $enableClientCert;
    private $clientCertDirectory;
    private $clientCertFile;
    private $clientCertPassword;
    private $clientId;
    private $clientSecret;
    private $enableLogging;
    private $debugLogFile;
    private $errorLogFile;
    private $logDateFormat;
    private $logFormat;
    private $logMaxFiles;
    private $logLevel;
    private $enableMasking;
    private $defaultDeveloperId;
    private $enableRequestMLEForOptionalApisGlobally;
    private $mapToControlMLEonAPI;
    private $requestMleKeyAlias;
    private $enableResponseMleGlobally;
    private $responseMlePrivateKeyFilePath;
    private $responseMlePrivateKeyFilePassword;
    private $responseMleKID;

    //initialize variable on constructor
    function __construct()
    {
        $this->authType = "jwt";//only jwt supports MLE
        $this->merchantID = "agentic_mid_091225001";
        $this->apiKeyID = "08c94330-f618-42a3-b09d-e1e43be5efda";
        $this->secretKey = "yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=";

        // MetaKey configuration [Start]
        $this->useMetaKey = false;
        $this->portfolioID = "";
        // MetaKey configuration [End]

        $this->keyAlias = "agentic_mid_091225001";
        $this->keyPass = "Changeit@123";
        $this->keyFilename = "agentic_mid_091225001";
        $this->keyDirectory = "Resources/";
        $this->runEnv = "apitest.cybersource.com";
        $this->enableRequestMLEForOptionalApisGlobally = true;
        $this->requestMleKeyAlias  = "CyberSource_SJC_US"; //this is optional paramter, not required to set the parameter/value if custom value is not required for MLE key alias. Default value is "CyberSource_SJC_US".

        // Response MLE configuration
        $this->enableResponseMleGlobally = false;
        $this->responseMlePrivateKeyFilePath = __DIR__  . DIRECTORY_SEPARATOR."agentic_mid_091225001.p12";
        $this->responseMlePrivateKeyFilePassword = "Changeit@123";
        $this->responseMleKID = "";

        //Add the property if required to override the cybs default developerId in all request body
        $this->defaultDeveloperId = "";


        //OAuth related config
        $this->enableClientCert = false;
        $this->clientCertDirectory = "Resources/";
        $this->clientCertFile = "";
        $this->clientCertPassword = "";
        $this->clientId = "";
        $this->clientSecret = "";

        // New Logging
        $this->enableLogging = true;
        $this->debugLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log";
        $this->errorLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log";
        $this->logDateFormat = "Y-m-d\TH:i:s";
        $this->logFormat = "[%datetime%] [%level_name%] [%channel%] : %message%\n";
        $this->logMaxFiles = 3;
        $this->logLevel = "debug";
        $this->enableMasking = true;

        $this->merchantConfigObjectWithMLE1();
    }

    //creating merchant config object with MLE
    function merchantConfigObjectWithMLE1()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType(strtoupper(trim($this->authType)));
            $config->setMerchantID(trim($this->merchantID));
            $config->setApiKeyID($this->apiKeyID);
            $config->setSecretKey($this->secretKey);
            $config->setKeyFileName(trim($this->keyFilename));
            $config->setKeyAlias($this->keyAlias);
            $config->setKeyPassword($this->keyPass);
            $config->setUseMetaKey($this->useMetaKey);
            $config->setPortfolioID($this->portfolioID);
            $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
            $config->setRunEnvironment($this->runEnv);
            
            // Request MLE Settings
            $config->setRequestMleKeyAlias($this->requestMleKeyAlias);
            $config->setEnableRequestMLEForOptionalApisGlobally(true); // Enables request MLE globally for all APIs that have optional MLE support
            // Response MLE Settings
            $config->setEnableResponseMleGlobally(true);  // Disable response MLE globally
            $config->setResponseMlePrivateKeyFilePath($this->responseMlePrivateKeyFilePath);
            $config->setResponseMlePrivateKeyFilePassword($this->responseMlePrivateKeyFilePassword);
            $config->setResponseMleKID($this->responseMleKID);

            //Add the property if required to override the cybs default developerId in all request body
            $config->setDefaultDeveloperId($this->defaultDeveloperId);

            // New Logging
            $logConfiguration = new \CyberSource\Logging\LogConfiguration();
            $logConfiguration->enableLogging($this->enableLogging);
            $logConfiguration->setDebugLogFile($this->debugLogFile);
            $logConfiguration->setErrorLogFile($this->errorLogFile);
            $logConfiguration->setLogDateFormat($this->logDateFormat);
            $logConfiguration->setLogFormat($this->logFormat);
            $logConfiguration->setLogMaxFiles($this->logMaxFiles);
            $logConfiguration->setLogLevel($this->logLevel);
            $logConfiguration->enableMasking($this->enableMasking);
            $config->setLogConfiguration($logConfiguration);

            $config->validateMerchantData();
            $this->merchantConfig = $config;
        } else {
            return $this->merchantConfig;
        }
    }


    function merchantConfigObjectWithMLE2()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType(strtoupper(trim($this->authType)));
            $config->setMerchantID(trim($this->merchantID));
            $config->setApiKeyID($this->apiKeyID);
            $config->setSecretKey($this->secretKey);
            $config->setKeyFileName(trim($this->keyFilename));
            $config->setKeyAlias($this->keyAlias);
            $config->setKeyPassword($this->keyPass);
            $config->setUseMetaKey($this->useMetaKey);
            $config->setPortfolioID($this->portfolioID);
            $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
            $config->setRunEnvironment($this->runEnv);
            
            // Request MLE Settings
            $config->setEnableRequestMLEForOptionalApisGlobally(true);  // Enables request MLE globally for all APIs that have optional MLE support
            $config->setRequestMleKeyAlias($this->requestMleKeyAlias);
            
            // Response MLE Settings
            $config->setEnableResponseMleGlobally(false);  // Disable response MLE globally
            $config->setResponseMlePrivateKeyFilePath($this->responseMlePrivateKeyFilePath);
            $config->setResponseMlePrivateKeyFilePassword($this->responseMlePrivateKeyFilePassword);
            $config->setResponseMleKID($this->responseMleKID);
            
            // Map to control MLE on API level (format: "requestMLE::responseMLE")
            $config->setMapToControlMLEonAPI([
            'createPayment' => 'true::false',      // CreatePayment will have Request MLE=true and Response MLE=false
            'capturePayment' => 'false::false'     // CapturePayment will have Request MLE=false and Response MLE=false
            ]);

            //Add the property if required to override the cybs default developerId in all request body
            $config->setDefaultDeveloperId($this->defaultDeveloperId);

            // New Logging
            $logConfiguration = new \CyberSource\Logging\LogConfiguration();
            $logConfiguration->enableLogging($this->enableLogging);
            $logConfiguration->setDebugLogFile($this->debugLogFile);
            $logConfiguration->setErrorLogFile($this->errorLogFile);
            $logConfiguration->setLogDateFormat($this->logDateFormat);
            $logConfiguration->setLogFormat($this->logFormat);
            $logConfiguration->setLogMaxFiles($this->logMaxFiles);
            $logConfiguration->setLogLevel($this->logLevel);
            $logConfiguration->enableMasking($this->enableMasking);
            $config->setLogConfiguration($logConfiguration);

            $config->validateMerchantData();
            $this->merchantConfig = $config;
        } else {
            return $this->merchantConfig;
        }
    }

    function merchantConfigObjectWithMLE3()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType(strtoupper(trim($this->authType)));
            $config->setMerchantID(trim($this->merchantID));
            $config->setApiKeyID($this->apiKeyID);
            $config->setSecretKey($this->secretKey);
            $config->setKeyFileName(trim($this->keyFilename));
            $config->setKeyAlias($this->keyAlias);
            $config->setKeyPassword($this->keyPass);
            $config->setUseMetaKey($this->useMetaKey);
            $config->setPortfolioID($this->portfolioID);
            $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
            $config->setRunEnvironment($this->runEnv);
            
            // Request MLE Settings
            $config->setEnableRequestMLEForOptionalApisGlobally(false);  // Disable request MLE globally for all APIs that have optional MLE support
            $config->setRequestMleKeyAlias($this->requestMleKeyAlias);
            
            // Response MLE Settings
            $config->setEnableResponseMleGlobally(false);  // Disable response MLE globally
            $config->setResponseMlePrivateKeyFilePath($this->responseMlePrivateKeyFilePath);
            $config->setResponseMlePrivateKeyFilePassword($this->responseMlePrivateKeyFilePassword);
            $config->setResponseMleKID($this->responseMleKID);
            
            // Map to control MLE on API level (format: "requestMLE::responseMLE")
            $config->setMapToControlMLEonAPI([
            'createPayment' => 'true::false',      // CreatePayment will have Request MLE=true and Response MLE=false
            'capturePayment' => 'true::false'      // CapturePayment will have Request MLE=true and Response MLE=false
            ]);

            //Add the property if required to override the cybs default developerId in all request body
            $config->setDefaultDeveloperId($this->defaultDeveloperId);

            // New Logging
            $logConfiguration = new \CyberSource\Logging\LogConfiguration();
            $logConfiguration->enableLogging($this->enableLogging);
            $logConfiguration->setDebugLogFile($this->debugLogFile);
            $logConfiguration->setErrorLogFile($this->errorLogFile);
            $logConfiguration->setLogDateFormat($this->logDateFormat);
            $logConfiguration->setLogFormat($this->logFormat);
            $logConfiguration->setLogMaxFiles($this->logMaxFiles);
            $logConfiguration->setLogLevel($this->logLevel);
            $logConfiguration->enableMasking($this->enableMasking);
            $config->setLogConfiguration($logConfiguration);

            $config->validateMerchantData();
            $this->merchantConfig = $config;
        } else {
            return $this->merchantConfig;
        }
    }

    function merchantConfigObjectWithRequestAndResponseMLE1()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType("JWT"); // MLE only support with JWT Auth Type
            $config->setMerchantID("agentic_mid_091225001");
            $config->setKeyFileName("agentic_mid_091225001");
            $config->setKeyAlias("agentic_mid_091225001");
            $config->setKeyPassword("Changeit@123");
            $config->setUseMetaKey(false);
            $config->setPortfolioID("");
            $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR);
            $config->setRunEnvironment("apitest.cybersource.com");
            
            // Request MLE Settings
            $config->setEnableRequestMLEForOptionalApisGlobally(true);  // Enables request MLE globally for all APIs that have optional MLE support
            
            // Response MLE Settings
            $config->setEnableResponseMleGlobally(true);  // Enables response MLE globally for all APIs that support MLE responses
            $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
            $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
            //$config->setResponseMleKID("1764104507829324018353");  // Optional
            
            //Add the property if required to override the cybs default developerId in all request body
            $config->setDefaultDeveloperId("");

            // New Logging
            $logConfiguration = new \CyberSource\Logging\LogConfiguration();
            $logConfiguration->enableLogging(true);
            $logConfiguration->setDebugLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log");
            $logConfiguration->setErrorLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log");
            $logConfiguration->setLogDateFormat("Y-m-d\TH:i:s");
            $logConfiguration->setLogFormat("[%datetime%] [%level_name%] [%channel%] : %message%\n");
            $logConfiguration->setLogMaxFiles(3);
            $logConfiguration->setLogLevel("debug");
            $logConfiguration->enableMasking(true);
            $config->setLogConfiguration($logConfiguration);

            $config->validateMerchantData();
            $this->merchantConfig = $config;
        } else {
            return $this->merchantConfig;
        }
    }

    function merchantConfigObjectWithRequestAndResponseMLE2()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType("JWT"); // MLE only support with JWT Auth Type
            $config->setMerchantID("agentic_mid_091225001");
            $config->setKeyFileName("agentic_mid_091225001");
            $config->setKeyAlias("agentic_mid_091225001");
            $config->setKeyPassword("Changeit@123");
            $config->setUseMetaKey(false);
            $config->setPortfolioID("");
            $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR);
            $config->setRunEnvironment("apitest.cybersource.com");
            
            // Request MLE Settings
            $config->setEnableRequestMLEForOptionalApisGlobally(false);  // Disable request MLE globally
            
            // Response MLE Settings
            $config->setEnableResponseMleGlobally(false);  // Disable response MLE globally
            
            // Since one of the API has Response MLE true, below fields are required for Response MLE
            $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.p8");
            $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
            $config->setResponseMleKID("1764104507829324018353");  // Optional since p12 is Cybs Generated
            
            // Map to control MLE on API level (format: "requestMLE::responseMLE")
            $config->setMapToControlMLEonAPI([
                'createPayment' => 'true::false',   // CreatePayment will have Request MLE=true and Response MLE=false
                'enrollCard' => 'true::true'        // EnrollCard will have Request MLE=true and Response MLE=true
            ]);
            
            //Add the property if required to override the cybs default developerId in all request body
            $config->setDefaultDeveloperId("");

            // New Logging
            $logConfiguration = new \CyberSource\Logging\LogConfiguration();
            $logConfiguration->enableLogging(true);
            $logConfiguration->setDebugLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log");
            $logConfiguration->setErrorLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log");
            $logConfiguration->setLogDateFormat("Y-m-d\TH:i:s");
            $logConfiguration->setLogFormat("[%datetime%] [%level_name%] [%channel%] : %message%\n");
            $logConfiguration->setLogMaxFiles(3);
            $logConfiguration->setLogLevel("debug");
            $logConfiguration->enableMasking(true);
            $config->setLogConfiguration($logConfiguration);

            $config->validateMerchantData();
            $this->merchantConfig = $config;
        } else {
            return $this->merchantConfig;
        }
    }

    function ConnectionHost()
    {
        $merchantConf = $this->merchantConfigObjectWithMLE1();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

    // ==================================================================================
    // HELPER METHODS
    // ==================================================================================

    /**
     * Helper method to create base configuration
     * @return \CyberSource\Authentication\Core\MerchantConfiguration
     */
    private function getBaseConfig()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType("JWT");
        $config->setMerchantID("agentic_mid_091225001");
        $config->setKeyFileName("agentic_mid_091225001");
        $config->setKeyAlias("agentic_mid_091225001");
        $config->setKeyPassword("Changeit@123");
        $config->setUseMetaKey(false);
        $config->setPortfolioID("");
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR);
        $config->setRunEnvironment("apitest.cybersource.com");
        return $config;
    }

    /**
     * Helper method to create log configuration
     * @return \CyberSource\Logging\LogConfiguration
     */
    private function getLogConfig()
    {
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging(true);
        $logConfiguration->setDebugLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log");
        $logConfiguration->setErrorLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log");
        $logConfiguration->setLogDateFormat("Y-m-d\TH:i:s");
        $logConfiguration->setLogFormat("[%datetime%] [%level_name%] [%channel%] : %message%\n");
        $logConfiguration->setLogMaxFiles(3);
        $logConfiguration->setLogLevel("debug");
        $logConfiguration->enableMasking(true);
        return $logConfiguration;
    }

    // ==================================================================================
    // GROUP 1: CORRECT CREDENTIALS WITH MLE RESPONSE - FILE-BASED CONFIGURATIONS
    // ==================================================================================

    /**
     * Test Case 1: P12 file with correct password, Response MLE enabled
     * Test Scenario: enableResponseMleGlobally=true, correct P12 file, correct password
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMleP12CorrectEnabled()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        // $config->setResponseMleKID("1757695744950028980655"); // Optional for P12
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 2: P12 file with correct password, Response MLE disabled
     * Test Scenario: enableResponseMleGlobally=false, correct P12 file, correct password
     * Expected: Response MLE decryption should NOT be attempted (disabled)
     */
    public function getResponseMleP12CorrectDisabled()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        // $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 3: PEM file (unencrypted) with Response MLE enabled
     * Test Scenario: Unencrypted PEM file, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMlePemUnencrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key.pem");
        $config->setResponseMlePrivateKeyFilePassword("");  // No password for unencrypted
        $config->setResponseMleKID("1764104507829324018353");  // Required for PEM
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 4: PEM file (encrypted) with correct password
     * Test Scenario: Encrypted PEM file with correct password, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMlePemEncrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.pem");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");  // Required for PEM
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 5: P8 file (unencrypted) with Response MLE enabled
     * Test Scenario: Unencrypted P8 file, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMleP8Unencrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key.p8");
        $config->setResponseMlePrivateKeyFilePassword("");  // No password for unencrypted
        $config->setResponseMleKID("1764104507829324018353");  // Required for P8
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 6: P8 file (encrypted) with correct password
     * Test Scenario: Encrypted P8 file with correct password, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMleP8Encrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.p8");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");  // Required for P8
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 7: KEY file (unencrypted) with Response MLE enabled
     * Test Scenario: Unencrypted KEY file, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMleKeyUnencrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key.key");
        $config->setResponseMlePrivateKeyFilePassword("");  // No password for unencrypted
        $config->setResponseMleKID("1764104507829324018353");  // Required for KEY
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 8: KEY file (encrypted) with correct password
     * Test Scenario: Encrypted KEY file with correct password, Response MLE enabled
     * Expected: Response MLE decryption should succeed
     */
    public function getResponseMleKeyEncrypted()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.key");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");  // Required for KEY
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 2: CORRECT CREDENTIALS WITH PRIVATE KEY OBJECT
    // ==================================================================================

    /**
     * Test Case 9: Private key object with Response MLE enabled
     * Test Scenario: Direct private key object (loaded from P12), Response MLE enabled
     * Expected: Response MLE decryption should succeed
     * Note: PHP implementation would require loading the P12 file and extracting the private key
     */
    public function getResponseMlePrivateKeyObjectEnabled()
    {
        $config = $this->getBaseConfig();
        
        // Note: In PHP, you would need to load the private key from P12 file using OpenSSL functions
        // For now, we'll use the file path approach which is more common in PHP
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");  // Required when using key object
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 10: Private key object with Response MLE disabled
     * Test Scenario: Direct private key object (loaded from P12), Response MLE disabled
     * Expected: Response MLE decryption should NOT be attempted (disabled)
     */
    public function getResponseMlePrivateKeyObjectDisabled()
    {
        $config = $this->getBaseConfig();
        
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 3: INCORRECT PASSWORD SCENARIOS
    // ==================================================================================

    /**
     * Test Case 11: P12 file with incorrect password, Response MLE enabled
     * Test Scenario: P12 file with incorrect password, Response MLE enabled
     * Expected: Should fail to load private key due to incorrect password
     */
    public function getResponseMleP12IncorrectPasswordEnabled()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 12: P12 file with incorrect password, Response MLE disabled
     * Test Scenario: P12 file with incorrect password, Response MLE disabled
     * Expected: Should not attempt decryption (disabled), but config validation may still fail
     */
    public function getResponseMleP12IncorrectPasswordDisabled()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 13: Encrypted PEM file with incorrect password
     * Test Scenario: Encrypted PEM file with incorrect password
     * Expected: Should fail to load private key due to incorrect password
     */
    public function getResponseMlePemIncorrectPassword()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.pem");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 14: Encrypted P8 file with incorrect password
     * Test Scenario: Encrypted P8 file with incorrect password
     * Expected: Should fail to load private key due to incorrect password
     */
    public function getResponseMleP8IncorrectPassword()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.p8");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 15: Encrypted KEY file with incorrect password
     * Test Scenario: Encrypted KEY file with incorrect password
     * Expected: Should fail to load private key due to incorrect password
     */
    public function getResponseMleKeyIncorrectPassword()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle_private_key_encrypted.key");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 16: PFX file with incorrect password (PFX is same as P12)
     * Test Scenario: PFX/P12 file with incorrect password
     * Expected: Should fail to load private key due to incorrect password
     */
    public function getResponseMlePfxIncorrectPassword()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings (using P12 as PFX)
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("WrongPassword123");  // Incorrect password
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 4: INCORRECT PRIVATE KEY OBJECT SCENARIOS
    // ==================================================================================

    /**
     * Test Case 17: Incorrect private key object, Response MLE enabled
     * Test Scenario: Invalid/incorrect private key object, Response MLE enabled
     * Expected: Should fail decryption with incorrect key
     */
    public function getResponseMleIncorrectPrivateKeyObjectEnabled()
    {
        $config = $this->getBaseConfig();
        
        // Load a different/wrong private key from JWT auth P12
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001.p12");  // Wrong key file
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 18: Incorrect private key object, Response MLE disabled
     * Test Scenario: Invalid/incorrect private key object, Response MLE disabled
     * Expected: Should not attempt decryption (disabled)
     */
    public function getResponseMleIncorrectPrivateKeyObjectDisabled()
    {
        $config = $this->getBaseConfig();
        
        // Load a different/wrong private key from JWT auth P12
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001.p12");  // Wrong key file
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 5: INCORRECT FILE PATH SCENARIOS
    // ==================================================================================

    /**
     * Test Case 19: Incorrect PEM file path
     * Test Scenario: Non-existent PEM file path
     * Expected: Should fail to find/load the file
     */
    public function getResponseMleIncorrectPemPath()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "non_existent_file.pem");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 20: Incorrect P8 file path
     * Test Scenario: Non-existent P8 file path
     * Expected: Should fail to find/load the file
     */
    public function getResponseMleIncorrectP8Path()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "non_existent_file.p8");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 21: Incorrect KEY file path
     * Test Scenario: Non-existent KEY file path
     * Expected: Should fail to find/load the file
     */
    public function getResponseMleIncorrectKeyPath()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "non_existent_file.key");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 22: Incorrect P12/PFX file path
     * Test Scenario: Non-existent P12/PFX file path
     * Expected: Should fail to find/load the file
     */
    public function getResponseMleIncorrectP12Path()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "non_existent_file.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 6: NON-MLE RESPONSE SCENARIOS
    // ==================================================================================

    /**
     * Test Case 23: Response MLE enabled but API returns non-encrypted response
     * Test Scenario: Response MLE enabled, but API returns plain JSON (non-encrypted)
     * Expected: Should handle plain JSON response gracefully (no decryption needed)
     */
    public function getResponseMleEnabledNonEncryptedApi()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - configured but API won't return encrypted response
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 24: Response MLE disabled and API returns non-encrypted response
     * Test Scenario: Response MLE disabled, API returns plain JSON (non-encrypted)
     * Expected: Should process plain JSON response normally
     */
    public function getResponseMleDisabledNonEncryptedApi()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - disabled
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 7: VALID JWT + RESPONSE MLE WITH mapToControlMLEonAPI STRING FORMAT
    // ==================================================================================

    /**
     * Test Case 25: JWT + Global Response MLE enabled + API override to enable
     * Test Scenario: authType=JWT, enableResponseMleGlobally=true, mapToControlMLEonAPI('enrollCard','::true')
     * Expected: Response MLE should be enabled (global setting confirmed by API-level setting)
     */
    public function getMleJwtGlobalEnabledApiOverrideTrue()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control with string format (::true means request MLE not specified, response MLE enabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => '::true'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 26: JWT + Global disabled + API-level Request+Response MLE
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','true::true')
     * Expected: Both Request and Response MLE enabled at API level
     */
    public function getMleJwtGlobalDisabledApiRequestResponseTrue()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control (true::true means both request and response MLE enabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true::true'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 27: JWT + Global disabled + API-level Response MLE only
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','false::true')
     * Expected: Only Response MLE enabled at API level (Request MLE disabled)
     */
    public function getMleJwtGlobalDisabledApiResponseOnlyTrue()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control (false::true means request MLE disabled, response MLE enabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'false::true'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 28: JWT + Global enabled + API override to disable Response MLE
     * Test Scenario: authType=JWT, enableResponseMleGlobally=true, mapToControlMLEonAPI('enrollCard','::false')
     * Expected: Response MLE disabled at API level (overrides global setting)
     */
    public function getMleJwtGlobalEnabledApiOverrideFalse()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - configured but will be overridden
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control (::false means response MLE disabled at API level)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => '::false'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 29: JWT + Global disabled + API-level disable Response MLE
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','::false')
     * Expected: Response MLE disabled both globally and at API level
     */
    public function getMleJwtGlobalDisabledApiResponseFalse()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - disabled
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control (::false means response MLE disabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => '::false'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 30: JWT + Global disabled + API-level Request MLE only
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','true::false')
     * Expected: Only Request MLE enabled at API level, Response MLE disabled
     */
    public function getMleJwtGlobalDisabledApiRequestOnlyTrue()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - disabled
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath("");
        $config->setResponseMlePrivateKeyFilePassword("");
        $config->setResponseMleKID("");
        
        // API-level control (true::false means request MLE enabled, response MLE disabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true::false'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 31: JWT + Global disabled + API-level both disabled
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','false::false')
     * Expected: Both Request and Response MLE disabled at API level
     */
    public function getMleJwtGlobalDisabledApiBothFalse()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - disabled
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath("");
        $config->setResponseMlePrivateKeyFilePassword("");
        $config->setResponseMleKID("");
        
        // API-level control (false::false means both disabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'false::false'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 8: HTTP SIGNATURE AUTH CONFIGURATIONS
    // ==================================================================================

    /**
     * Test Case 32: HTTP Signature + Global Response MLE enabled
     * Test Scenario: authType=http_signature, enableResponseMleGlobally=true
     * Expected: Should handle based on whether HTTP Signature supports Response MLE
     */
    public function getMleHttpSignatureGlobalEnabled()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType("http_signature");
        $config->setMerchantID("agentic_mid_091225001");
        $config->setApiKeyID("agentic_mid_091225001_key_id");
        $config->setSecretKey("agentic_mid_091225001_secret_key");
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR);
        $config->setUseMetaKey(false);
        $config->setPortfolioID("");
        $config->setRunEnvironment("apitest.cybersource.com");
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 33: HTTP Signature + Global disabled + API-level Response MLE
     * Test Scenario: authType=http_signature, enableResponseMleGlobally=false, mapToControlMLEonAPI('enrollCard','false::true')
     * Expected: API-level Response MLE enabled with HTTP Signature auth
     */
    public function getMleHttpSignatureGlobalDisabledApiResponseTrue()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType("http_signature");
        $config->setMerchantID("agentic_mid_091225001");
        $config->setApiKeyID("agentic_mid_091225001_key_id");
        $config->setSecretKey("agentic_mid_091225001_secret_key");
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR);
        $config->setUseMetaKey(false);
        $config->setPortfolioID("");
        $config->setRunEnvironment("apitest.cybersource.com");
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // API-level control
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'false::true'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 9: JWT BASE CASES
    // ==================================================================================

    /**
     * Test Case 34: JWT only (no MLE)
     * Test Scenario: authType=JWT only, no MLE configuration
     * Expected: No MLE encryption/decryption
     */
    public function getMleJwtOnlyNoMle()
    {
        $config = $this->getBaseConfig();
        
        // No MLE settings at all
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 35: JWT + Global Response MLE disabled
     * Test Scenario: authType=JWT, enableResponseMleGlobally=false (explicitly disabled)
     * Expected: Response MLE disabled
     */
    public function getMleJwtGlobalResponseDisabled()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings - explicitly disabled
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 10: INVALID FORMAT ERROR TESTING
    // ==================================================================================

    /**
     * Test Case 36: Invalid format - single colon
     * Test Scenario: authType=JWT, mapToControlMLEonAPI('enrollCard',':true')
     * Expected: Error due to invalid format (should be '::true' not ':true')
     */
    public function getMleInvalidFormatSingleColon()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // Invalid API-level control format
        $config->setMapToControlMLEonAPI([
            'enrollCard' => ':true'  // INVALID: should be '::true'
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 37: Invalid format - too many parts
     * Test Scenario: authType=JWT, mapToControlMLEonAPI('enrollCard','::true::true')
     * Expected: Error due to invalid format (too many colons/parts)
     */
    public function getMleInvalidFormatTooManyParts()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // Invalid API-level control format
        $config->setMapToControlMLEonAPI([
            'enrollCard' => '::true::true'  // INVALID: too many parts
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 38: Invalid format - trailing colons
     * Test Scenario: authType=JWT, mapToControlMLEonAPI('enrollCard','::true::')
     * Expected: Error due to invalid format (trailing colons)
     */
    public function getMleInvalidFormatTrailingColons()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // Invalid API-level control format
        $config->setMapToControlMLEonAPI([
            'enrollCard' => '::true::'  // INVALID: trailing colons
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 39: Invalid format - three colons
     * Test Scenario: authType=JWT, mapToControlMLEonAPI('enrollCard',':::true')
     * Expected: Error due to invalid format (three colons)
     */
    public function getMleInvalidFormatThreeColons()
    {
        $config = $this->getBaseConfig();
        
        // Response MLE Settings
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        // Invalid API-level control format
        $config->setMapToControlMLEonAPI([
            'enrollCard' => ':::true'  // INVALID: three colons
        ]);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    // ==================================================================================
    // GROUP 11: JWT + REQUEST MLE CONFIGURATIONS (NEW REQUIREMENTS)
    // ==================================================================================

    /**
     * Test Case 40: JWT + useMLEGlobally=true (deprecated parameter)
     * Test Scenario: authType=JWT, useMLEGlobally=true
     * Expected: Request MLE enabled globally using deprecated parameter
     * Note: useMLEGlobally is deprecated, use enableRequestMLEForOptionalApisGlobally instead
     */
    public function getJwtUseMLEGloballyTrue()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings using deprecated parameter
        $config->setUseMLEGlobally(true);  // Deprecated parameter
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // No Response MLE configuration
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 41: JWT + enableRequestMLEForOptionalApisGlobally=true
     * Test Scenario: authType=JWT, enableRequestMLEForOptionalApisGlobally=true
     * Expected: Request MLE enabled globally for all APIs with optional MLE support
     */
    public function getJwtEnableRequestMLEGloballyTrue()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // No Response MLE configuration
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 42: JWT + Global enabled + API override with boolean format
     * Test Scenario: authType=JWT, enableRequestMLEForOptionalApisGlobally=true, 
     *                mapToControlMLEonAPI("anyAPI","true")
     * Expected: Global request MLE enabled, API-level override using boolean "true" format
     */
    public function getJwtGlobalEnabledApiOverrideTrue()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // API-level control with boolean format (old format)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true'  // Boolean string format for request MLE
        ]);
        
        // No Response MLE configuration
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 43: JWT + Global disabled + API-level request MLE with "true::" format
     * Test Scenario: authType=JWT, enableRequestMLEForOptionalApisGlobally=false, 
     *                mapToControlMLEonAPI("anyAPI","true::")
     * Expected: Global disabled, API-level request MLE enabled with string format
     * Note: "true::" means request MLE=true, response MLE not specified
     */
    public function getJwtGlobalDisabledApiRequestTrueString()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings
        $config->setEnableRequestMLEForOptionalApisGlobally(false);
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // API-level control with string format (true:: means request MLE enabled, response not specified)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true::'  // Request MLE enabled, response MLE not specified
        ]);
        
        // No Response MLE configuration
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 44: JWT + Global disabled + API-level "true::false"
     * Test Scenario: authType=JWT, enableRequestMLEForOptionalApisGlobally=false, 
     *                mapToControlMLEonAPI("anyAPI","true::false")
     * Expected: Global disabled, API-level request MLE enabled, response MLE disabled
     * Note: "true::false" means request MLE=true, response MLE=false
     */
    public function getJwtGlobalDisabledApiRequestTrueResponseFalse()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings
        $config->setEnableRequestMLEForOptionalApisGlobally(false);
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // API-level control (true::false means request MLE enabled, response MLE disabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true::false'  // Request MLE enabled, Response MLE disabled
        ]);
        
        // No Response MLE configuration
        $config->setEnableResponseMleGlobally(false);
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

    /**
     * Test Case 45: JWT + Global disabled + API-level "true::true"
     * Test Scenario: authType=JWT, enableRequestMLEForOptionalApisGlobally=false, 
     *                mapToControlMLEonAPI("anyAPI","true::true")
     * Expected: Global disabled, API-level both request and response MLE enabled
     * Note: "true::true" means request MLE=true, response MLE=true
     */
    public function getJwtGlobalDisabledApiRequestResponseBothTrue()
    {
        $config = $this->getBaseConfig();
        
        // Request MLE Settings
        $config->setEnableRequestMLEForOptionalApisGlobally(false);
        $config->setRequestMleKeyAlias("CyberSource_SJC_US");
        
        // API-level control (true::true means both request and response MLE enabled)
        $config->setMapToControlMLEonAPI([
            'enrollCard' => 'true::true'  // Both Request and Response MLE enabled
        ]);
        
        // Response MLE Settings required since API-level response MLE is enabled
        $config->setEnableResponseMleGlobally(false);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "agentic_mid_091225001_new_generated_mle.p12");
        $config->setResponseMlePrivateKeyFilePassword("Changeit@123");
        $config->setResponseMleKID("1764104507829324018353");
        
        $config->setLogConfiguration($this->getLogConfig());
        $config->validateMerchantData();
        return $config;
    }

}
?>
