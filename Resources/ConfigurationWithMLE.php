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
        $this->merchantID = "testrest";
        $this->apiKeyID = "08c94330-f618-42a3-b09d-e1e43be5efda";
        $this->secretKey = "yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=";

        // MetaKey configuration [Start]
        $this->useMetaKey = false;
        $this->portfolioID = "";
        // MetaKey configuration [End]

        $this->keyAlias = "testrest";
        $this->keyPass = "testrest";
        $this->keyFilename = "testrest";
        $this->keyDirectory = "Resources/";
        $this->runEnv = "apitest.cybersource.com";
        $this->enableRequestMLEForOptionalApisGlobally = true;
        $this->requestMleKeyAlias  = "CyberSource_SJC_US"; //this is optional paramter, not required to set the parameter/value if custom value is not required for MLE key alias. Default value is "CyberSource_SJC_US".

        // Response MLE configuration
        $this->enableResponseMleGlobally = false;
        $this->responseMlePrivateKeyFilePath = "";
        $this->responseMlePrivateKeyFilePassword = "";
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
            $config->setEnableResponseMleGlobally(false);  // Disable response MLE globally
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
        return $config;
    }

    function merchantConfigObjectWithRequestAndResponseMLE2()
    {
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
        return $config;
    }

    function ConnectionHost()
    {
        $merchantConf = $this->merchantConfigObjectWithMLE1();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

}
?>
