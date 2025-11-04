<?php
/*
    The BankAccountValidationConfiguration.php provides the necessary settings for 
    Bank Account Validation (BAV) using the CyberSource REST API. 
    This configuration uses JWT authentication, which is required for Request MLE. 
    The BAV API mandates Request MLE, and JWT is the only supported authentication type for this feature.
    By Default SDK sends encrypted requests for the APIs having mandatory Request MLE flag.
    For more MLE features and configurations, please refer to CyberSource documentation at https://github.com/CyberSource/cybersource-rest-client-php/blob/master/MLE.md
*/
namespace CyberSource;
require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';

class BankAccountValidationConfiguration
{
    private $merchantConfig;

    private $authType;
    private $merchantID;
    private $keyAlias;
    private $keyPass;
    private $keyFilename;
    private $keyDirectory;
    private $runEnv;
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
        $this->authType = "jwt";//only jwt supports MLE
        $this->merchantID = "testcasmerchpd01001";

        $this->keyAlias = "testcasmerchpd01001";
        $this->keyPass = "Authnet101!";
        $this->keyFilename = "testcasmerchpd01001";
        $this->keyDirectory = "Resources/";
        $this->runEnv = "apitest.cybersource.com";

        // New Logging
        $this->enableLogging = true;
        $this->debugLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log";
        $this->errorLogFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log";
        $this->logDateFormat = "Y-m-d\TH:i:s";
        $this->logFormat = "[%datetime%] [%level_name%] [%channel%] : %message%\n";
        $this->logMaxFiles = 3;
        $this->logLevel = "debug";
        $this->enableMasking = true;

        $this->bankAccountValidationConfiguration();
    }

    //creating merchant config object with MLE for Bank Account Validation
    function bankAccountValidationConfiguration()
    {
        if (!isset($this->merchantConfig)) {
            $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
            $config->setauthenticationType(strtoupper(trim($this->authType)));
            $config->setMerchantID(trim($this->merchantID));

            $config->setKeyFileName(trim($this->keyFilename));
            $config->setKeyAlias($this->keyAlias);
            $config->setKeyPassword($this->keyPass);
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

    function ConnectionHost()
    {
        $merchantConf = $this->bankAccountValidationConfiguration();
        $config = new Configuration();
        $config->setHost($merchantConf->getHost());
        $config->setLogConfiguration($merchantConf->getLogConfiguration());
        return $config;
    }

}
?>
