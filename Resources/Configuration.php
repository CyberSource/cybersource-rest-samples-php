<?php
/*
* Purpose : passing merchant config object to the configuration
*/

require_once 'autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/cybersource/rest-client-php/lib/Authentication/Core/MerchantConfiguration.php';

class Configuration
{
        //initialize variable on constructor
        function __construct()
        {
                $this->authType = "http_signature";
                $this->enableLog = true;
                $this->logSize = "1048576";
                $this->logFile = "Log";
                $this->logFilename = "Cybs.log";
                $this->merchantID = "testrest";
                $this->apiKeyID = "08c94330-f618-42a3-b09d-e1e43be5efda";
                $this->screteKey = "yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=";
                //$this->proxyUrl = "https.proxy.url";
                //$this->proxyHost = "443";
                $this->keyAlias = "testrest";
                $this->keyPass = "testrest";
                $this->keyFilename = "testrest";
                $this->keyDirectory = "Resources/";
                $this->runEnv = "apitest.cybersource.com";
                $this->merchantConfigObject();
        }
        //creating merchant config object
	function merchantConfigObject()
	{     
		$config = new CyberSource\Authentication\Core\MerchantConfiguration();
                if(is_bool($this->enableLog))
		      $confiData = $config->setDebug($this->enableLog);

                $confiData = $config->setLogSize(trim($this->logSize));
                $confiData = $config->setDebugFile(trim($this->logFile));
                $confiData = $config->setLogFileName(trim($this->logFilename));
                $confiData = $config->setAuthenticationType(strtoupper(trim($this->authType)));
                $confiData = $config->setMerchantID(trim($this->merchantID));
                $confiData = $config->setApiKeyID($this->apiKeyID);
                $confiData = $config->setSecreteKey($this->screteKey);
                //$confiData = $config->setCurlProxyHost($this->proxyUrl);
                //$confiData = $config->setCurlProxyPort($this->proxyHost);
                $confiData = $config->setKeyFileName(trim($this->keyFilename));
                $confiData = $config->setKeyAlias($this->keyAlias);
                $confiData = $config->setKeyPassword($this->keyPass);
                $confiData = $config->setKeysDirectory($this->keyDirectory);
                $confiData = $config->setRunEnvironment($this->runEnv);
                $config->validateMerchantData($confiData);
		return $config;
	}
}	

?>
