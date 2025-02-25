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
    private $IntermediateHost;
    private $jwePEMFileDirectory;
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
    private $useMLEGlobally;
    private $mapToControlMLEonAPI;
    private $mleKeyAlias;

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
        $this->mleKeyAlias  = "CyberSource_SJC_US"; //this is optional paramter, not required to set the parameter/value if custom value is not required for MLE key alias. Default value is "CyberSource_SJC_US".
        
        // new property has been added for user to configure the base path so that request can route the API calls via Azure Management URL.
        // Example: If intermediate url is https://manage.windowsazure.com then in property input can be same url or manage.windowsazure.com.
        $this->IntermediateHost = "https://manage.windowsazure.com";

        //PEM Key file path for decoding JWE Response Enter the folder path where the .pem file is located.
        // It is optional property, require adding only during JWE decryption.
        $this -> jwePEMFileDirectory = "Resources/NetworkTokenCert.pem";

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
        $this->jwePEMFileDirectory = "Resources".DIRECTORY_SEPARATOR."NetworkTokenCert.pem";
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
            $config->setJwePEMFileDirectory($this -> jwePEMFileDirectory);
            $config->setRunEnvironment($this->runEnv);
            $config->setUseMLEGlobally(true);  ////globally MLE will be enabled for all the MLE supported APIs by Cybs in SDK
            $config->setMleKeyAlias($this->mleKeyAlias);

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
            $config->setJwePEMFileDirectory($this -> jwePEMFileDirectory);
            $config->setRunEnvironment($this->runEnv);
            $config->setUseMLEGlobally(true);  //globally MLE will be enabled for all the MLE supported APIs by Cybs in SDK
            $config->setMapToControlMLEonAPI([
            'createPayment' => true, 
            'capturePayment' => false    //only capturePayment function will have MLE=false i.e. (/pts/v2/payments POST API) out of all MLE supported APIs
            ]);
            $config->setMleKeyAlias($this->mleKeyAlias);


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
            $config->setJwePEMFileDirectory($this -> jwePEMFileDirectory);
            $config->setRunEnvironment($this->runEnv);
            $config->setUseMLEGlobally(false);  //globally MLE will be disabled for all the MLE supported APIs by Cybs in SDK
            $config->setMapToControlMLEonAPI([
            'createPayment' => true,  //only createPayment and capturePayment function will have MLE=true out of all MLE supported APIs 
            'capturePayment' => true  // i.e. (/pts/v2/payments POST API) and (/pts/v2/payments/{id}/captures POST API)
            ]);
            $config->setMleKeyAlias($this->mleKeyAlias);


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
