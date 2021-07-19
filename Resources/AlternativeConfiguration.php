<?php
/*
* Purpose : passing Authentication config object to the configuration
*/

namespace CyberSource;

require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';


class ExternalConfiguration
{
        //initialize variable on constructor
        function __construct()
        {
                $this->authType = "http_signature";//http_signature/jwt
                // $this->enableLog = true;
                // $this->logSize = "1048576";
                // $this->logFile = "Log";
                // $this->logFilename = "Cybs.log";
                $this->merchantID = "testrest_cpctv";
                $this->apiKeyID = "e547c3d3-16e4-444c-9313-2a08784b906a";
                $this->secretKey = "JXm4dqKYIxWofM1TIbtYY9HuYo7Cg1HPHxn29f6waRo=";
                // meta key config         
                $this->useMetaKey = false;
                $this->portfolioID = "";
                // end meta key config
                $this->keyAlias = "testrest_cpctv";
                $this->keyPass = "testrest_cpctv";
                $this->keyFilename = "testrest_cpctv";
                $this->keyDirectory = "Resources/";
                $this->runEnv = "apitest.cybersource.com";
                // New logging configuration
                $this->enableLogging = true;
                $this->debugLogFile = __DIR__ . DIRECTORY_SEPARATOR . "../Logs/DebugLogFile.log";
                $this->errorLogFile = __DIR__ . DIRECTORY_SEPARATOR . "../Logs/ErrorLogFile.log";
                $this->logDateFormat = "Y-m-d\TH:i:s";
                $this->logFormat = "[%datetime%] [%level_name%] [%channel%] : %message%\n";
                $this->logMaxFiles = 3;
                $this->logLevel = "debug";
                $this->enableMasking = false;

                $this->merchantConfigObject();
        }
        //creating merchant config object
        function merchantConfigObject()
        {
                $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
                // if(is_bool($this->enableLog))
                //       $confiData = $config->setDebug($this->enableLog);

                // $confiData = $config->setLogSize(trim($this->logSize));
                // $confiData = $config->setDebugFile(trim(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->logFile));
                // $confiData = $config->setLogFileName(trim($this->logFilename));

                // New logging configuration
                $logConfigData = new \CyberSource\Logging\LogConfiguration();
                $logConfigData->enableLogging($this->enableLogging);
                $logConfigData->setDebugLogFile($this->debugLogFile);
                $logConfigData->setErrorLogFile($this->errorLogFile);
                $logConfigData->setLogDateFormat($this->logDateFormat);
                $logConfigData->setLogFormat($this->logFormat);
                $logConfigData->setLogMaxFiles($this->logMaxFiles);
                $logConfigData->setLogLevel($this->logLevel);
                $logConfigData->enableMasking($this->enableMasking);

                $config->setauthenticationType(strtoupper(trim($this->authType)));
                $config->setMerchantID(trim($this->merchantID));
                $config->setApiKeyID($this->apiKeyID);
                $config->setSecretKey($this->secretKey);
                $config->setKeyFileName(trim($this->keyFilename));
                $config->setKeyAlias($this->keyAlias);
                $config->setKeyPassword($this->keyPass);
                $config->setUseMetaKey($this->useMetaKey);
                $config->setPortfolioID($this->portfolioID);
                $config->setEnableClientCert($this->enableClientCert);
                $config->setClientCertDirectory($this->clientCertDirectory);
                $config->setClientCertFile($this->clientCertFile);
                $config->setClientCertPassword($this->clientCertPassword);
                $config->setClientId($this->clientId);
                $config->setClientSecret($this->clientSecret);
                $config->setKeysDirectory(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $this->keyDirectory);
                $config->setRunEnvironment($this->runEnv);
                $config->setLogConfiguration($logConfigData);
                $config->validateMerchantData();
                return $config;
        }

        function ConnectionHost()
        {
                $merchantConfig = $this->merchantConfigObject();
                $config = new Configuration();
                $config = $config->setHost($merchantConfig->getHost());
                // $config = $config->setDebug($merchantConfig->getDebug());
                // $config = $config->setDebugFile($merchantConfig->getDebugFile() . DIRECTORY_SEPARATOR . $merchantConfig->getLogFileName());
                return $config;
        }

        function FutureDate($format)
        {
                if ($format) {
                        $rdate = date("Y-m-d", strtotime("+7 days"));
                        $retDate = date($format, strtotime($rdate));
                } else {
                        $retDate = date("Y-m", strtotime("+7 days"));
                }
                echo $retDate;
                return $retDate;
        }

        function CallTestLogging($testId, $apiName, $responseMessage)
        {
                $runtime = date('d-m-Y H:i:s');
                $file = fopen("./CSV_Files/TestReport/TestResults.csv", "a+");
                fputcsv($file, array($testId, $runtime, $apiName, $responseMessage));
                fclose($file);
        }

        function downloadReport($downloadData, $fileName)
        {
                $filePathName = __DIR__ . DIRECTORY_SEPARATOR . $fileName;
                $file = fopen($filePathName, "w");
                fwrite($file, $downloadData);
                fclose($file);
                return __DIR__ . '\\' . $fileName;
        }
}
