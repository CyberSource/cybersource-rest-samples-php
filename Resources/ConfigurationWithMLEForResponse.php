<?php
/*
 * Purpose : passing Authentication config object to the configuration
 */
namespace CyberSource;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

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
    private $mleForRequestPublicCertPath;
    private $useMLEGlobally; //deprecated
    private $enableRequestMLEForOptionalApisGlobally; //alias for useMLEGlobally

    private $mapToControlMLEonAPI;
    private $mleKeyAlias; //deprecated
    private $requestMleKeyAlias; //alias for mleKeyAlias

    private $disableRequestMLEForMandatoryApisGlobally;

    //Response MLE
    private $enableResponseMleGlobally;
    private $responseMleKID;
    private $responseMlePrivateKeyFilePath;
    private $responseMlePrivateKeyFilePassword;
    private $responseMlePrivateKey;

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
        $this->useMLEGlobally = true;
        $this->mleKeyAlias = "CyberSource_SJC_US"; //this is optional paramter, not required to set the parameter/value if custom value is not required for MLE key alias. Default value is "CyberSource_SJC_US".

        //Add the property if required to override the cybs default developerId in all request body
        $this->defaultDeveloperId = "";

        //responsemle
        $this->enableResponseMleGlobally = true;
        $this->responseMleKID = "CyberSource_SJC_US";
        $this->responseMlePrivateKeyFilePath = /*Your Path to private key*/
        $this->responseMlePrivateKeyFilePassword = /*Your private key password for provided file path*/

        // Load private key based on file type
        $this->responseMlePrivateKey = /*load pvt key function*/

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

    }

    //ALL Values related to mle are example values, please use your own correct values

    // Config #1: Primary Configuration - enableRequestMLEForOptionalApisGlobally
    // Demonstrates: Enabling request MLE globally for all APIs with optional MLE support
    function config1_EnableRequestMLEForOptionalApisGlobally()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        
        // PRIMARY: Enable Request MLE for Optional APIs Globally
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #2: Deprecated Configuration - useMLEGlobally (Backward Compatibility)
    // Demonstrates: Using deprecated useMLEGlobally (alias for enableRequestMLEForOptionalApisGlobally)
    function config2_UseMLEGloballyDeprecated()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        
        // DEPRECATED: Use useMLEGlobally (maintained for backward compatibility)
        $config->setUseMLEGlobally(true);
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #3: Advanced Configuration - disableRequestMLEForMandatoryApisGlobally
    // Demonstrates: Disabling request MLE for APIs with mandatory MLE requirement
    function config3_DisableRequestMLEForMandatoryApis()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        
        // ADVANCED: Disable Request MLE for Mandatory APIs
        $config->setDisableRequestMLEForMandatoryApisGlobally(true);
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #4: Certificate File Path - mleForRequestPublicCertPath
    // Demonstrates: Providing custom public certificate path for request encryption
    function config4_MleForRequestPublicCertPath()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        
        // CERTIFICATE PATH: Provide custom public cert path (.pem or .crt)
        $config->setMleForRequestPublicCertPath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/requestMLECert.pem');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #5: Key Alias Configuration - requestMleKeyAlias
    // Demonstrates: Using custom key alias to retrieve MLE certificate from P12 file
    function config5_RequestMleKeyAlias()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        
        // KEY ALIAS: Set custom MLE key alias (default: CyberSource_SJC_US)
        $config->setRequestMleKeyAlias('Custom_value');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #6: Deprecated Key Alias - mleKeyAlias (Backward Compatibility)
    // Demonstrates: Using deprecated mleKeyAlias (alias for requestMleKeyAlias)
    function config6_MleKeyAliasDeprecated()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableRequestMLEForOptionalApisGlobally(true);
        
        // DEPRECATED KEY ALIAS: Use mleKeyAlias (maintained for backward compatibility)
        $config->setMleKeyAlias('CyberSource_SJC_US');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #7: Global Response MLE - enableResponseMleGlobally
    // Demonstrates: Enabling response MLE globally for all APIs that support it
    function config7_EnableResponseMleGlobally()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        
        // GLOBAL RESPONSE MLE: Enable response MLE globally
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMleKID('CyberSource_SJC_US');
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/testrest.p12');
        $config->setResponseMlePrivateKeyFilePassword('testrest');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #8: Response MLE with Private Key File Path (.p12)
    // Demonstrates: Providing private key file path in .p12 format for response decryption
    function config8_ResponseMlePrivateKeyFilePathP12()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableResponseMleGlobally(true);
        
        // OPTION 1: Private Key File Path (.p12)
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/responseMLEPrivateKey.p12');
        $config->setResponseMlePrivateKeyFilePassword('your-password-here');
        $config->setResponseMleKID('your-kid-here');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #9: Response MLE with Private Key File Path (.pem)
    // Demonstrates: Providing private key file path in .pem format for response decryption
    function config9_ResponseMlePrivateKeyFilePathPEM()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableResponseMleGlobally(true);
        
        // OPTION 1: Private Key File Path (.pem)
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/responseMLEPrivateKey.pem');
        $config->setResponseMlePrivateKeyFilePassword('your-password-here'); // optional for encrypted .pem
        $config->setResponseMleKID('your-kid-here');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #10: Response MLE with Private Key Object
    // Demonstrates: Providing private key as OpenSSL object for response decryption
    function config10_ResponseMlePrivateKeyObject()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableResponseMleGlobally(true);
        
        // OPTION 2: Private Key Object (OpenSSLAsymmetricKey)
        // Load private key from file and convert to object
        $privateKeyPath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/responseMLEPrivateKey.pem';
        $privateKeyContent = file_get_contents($privateKeyPath);
        $privateKeyObject = openssl_pkey_get_private($privateKeyContent, 'your-password-here');
        
        $config->setResponseMlePrivateKey($privateKeyObject);
        $config->setResponseMleKID('your-kid-here');
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    // Config #11: API-level MLE Control - Comprehensive Example
    // Demonstrates: All possible map value formats for controlling MLE at API level
    function config11_ApiLevelMLEControl()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        $config->setauthenticationType(strtoupper(trim($this->authType)));
        $config->setMerchantID(trim($this->merchantID));
        $config->setApiKeyID($this->apiKeyID);
        $config->setSecretKey($this->secretKey);
        $config->setKeyFileName(trim($this->keyFilename));
        $config->setKeyAlias($this->keyAlias);
        $config->setKeyPassword($this->keyPass);
        $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
        $config->setRunEnvironment($this->runEnv);
        $config->setEnableResponseMleGlobally(true);
        $config->setResponseMlePrivateKeyFilePath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Resources/testrest.p12');
        $config->setResponseMlePrivateKeyFilePassword('testrest');
        $config->setResponseMleKID('CyberSource_SJC_US');
        
        // API-LEVEL CONTROL: Override global MLE settings for specific APIs
        // Example api names, use correct ones in actual implementation
        $config->setMapToControlMLEonAPI([
            'createPayment' => 'true::true',      // Enable both request and response MLE
            'capturePayment' => 'false::false',   // Disable both request and response MLE
            'refundPayment' => 'true::false',     // Enable request MLE, disable response MLE
            'voidPayment' => 'false::true',       // Disable request MLE, enable response MLE
            'searchPayments' => '::true',         // Use global setting for request, enable response MLE
            'getPaymentDetails' => 'true::',      // Enable request MLE, use global setting for response
            'creditPayment' => '::false',         // Use global setting for request, disable response MLE
            'reversePayment' => 'false::',        // Disable request MLE, use global setting for response
            'incrementAuth' => 'true',            // Enable request MLE only (response uses global)
            'processPayment' => 'false',          // Disable request MLE only (response uses global)
        ]);
        
        // Logging
        $logConfiguration = new \CyberSource\Logging\LogConfiguration();
        $logConfiguration->enableLogging($this->enableLogging);
        $logConfiguration->setDebugLogFile($this->debugLogFile);
        $logConfiguration->setErrorLogFile($this->errorLogFile);
        $config->setLogConfiguration($logConfiguration);
        
        $config->validateMerchantData();
        return $config;
    }

    function ConnectionHost()
    {
        $merchantConf = $this->config11_ApiLevelMLEControl();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

}
?>