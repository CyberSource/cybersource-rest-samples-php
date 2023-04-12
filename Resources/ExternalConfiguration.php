<?php
/*
* Purpose : passing Authentication config object to the configuration
*/
namespace CyberSource;
require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';

class ExternalConfiguration
{
    private $merchantConfig;
    private $intermediateMerchantConfig;

    //initialize variable on constructor
    function __construct()
    {
        $this->authType = "http_signature";//http_signature/jwt
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
        
        // new property has been added for user to configure the base path so that request can route the API calls via Azure Management URL.
        // Example: If intermediate url is https://manage.windowsazure.com then in property input can be same url or manage.windowsazure.com.
        $this->IntermediateHost = "https://manage.windowsazure.com";

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

        $this->merchantConfigObject();
        $this->merchantConfigObjectForIntermediateHost();
    }

    //creating merchant config object
    function merchantConfigObject()
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

    //creating merchant config for intermediate host object
    function merchantConfigObjectForIntermediateHost()
    {
        if (!isset($this->intermediateMerchantConfig)) {
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
            $config->setIntermediateHost($this->IntermediateHost);

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
            $this->intermediateMerchantConfig = $config;
        } else {
            return $this->intermediateMerchantConfig;
        }
    }


    function ConnectionHost()
    {
        $merchantConf = $this->merchantConfigObject();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

    function ConnectionHostForIntermediateHost()
    {
        $intermediatemerchantConf = $this->merchantConfigObjectForIntermediateHost();
        $config = new Configuration();
        $config->setHost($intermediatemerchantConf->getHost());
        $config->setLogConfiguration($intermediatemerchantConf->getLogConfiguration());
        return $config;
    }

    function FutureDate($format){
        if($format){
            $rdate = date("Y-m-d",strtotime("+7 days"));
            $retDate = date($format,strtotime($rdate));
        }
        else{
            $retDate = date("Y-m",strtotime("+7 days"));
        }
        echo $retDate;
        return $retDate;
    }

    function CallTestLogging($testId, $apiName, $responseMessage){
        $runtime = date('d-m-Y H:i:s');
        $file = fopen("./CSV_Files/TestReport/TestResults.csv", "a+");
        fputcsv($file, array($testId, $runtime, $apiName, $responseMessage));
        fclose($file);
    }

    function downloadReport($downloadData, $fileName){
        $filePathName = __DIR__. DIRECTORY_SEPARATOR .$fileName;
        $file = fopen($filePathName, "w");
        fwrite($file, $downloadData);
        fclose($file);
        return __DIR__.'\\'.$fileName;
    }
}
?>
