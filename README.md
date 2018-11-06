# PHP Sample Code for the CyberSource SDK
This repository contains working code samples which demonstrate PHP integration with the CyberSource REST APIs through the CyberSource PHP SDK.

**__NOTE: THIS REPO OF CODE SAMPLES HAS BEEN MADE PUBLIC FOR SDK TESTING AND SHOULD NOT BE USED FOR PRODUCTION - YET.  PLEASE RAISE AN ISSUE ON THIS REPO IF YOU HAVE FURTHER QUESTIONS AND CHECK BACK SOON FOR GENERAL AVAILABILITY__**

## Requirements
* PHP 5.6+
* Enable cURL PHP Extension
* Enable JSON PHP Extension
* Enable PHP_APCU PHP Extension. You will need to download it for your platform (Windows/Linux/Mac) 
* [CyberSource Account](https://developer.cybersource.com/api/developer-guides/dita-gettingstarted/registration.html)
* [CyberSource API Keys](https://prod.developer.cybersource.com/api/developer-guides/dita-gettingstarted/registration/createCertSharedKey.html)
 
 ## Dependencies
* PHP-JWT              			: JWT token Genearation
* CURL          				: Http communication with the payment gateway
* PHP_APCU						: Caching 
* phpunit-5.7.25               	: unit testing
* phpunit-5.7.25 code coverage 	: Sonar coverage

## Using the Sample Code

The samples are all completely independent and self-contained. You can analyze them to get an understanding of how a particular method works, or you can use the snippets as a starting point for your own project.

You can also run each sample directly from the command line.

### Running the Samples From the Command Line
* Clone this repository:
```
    $ git clone https://github.com/CyberSource/cybersource-rest-samples-php
```
* Run composer with the "update" option in the root directory of the repository.
```
    $ composer update
```
* Run the individual samples by name. For example:
```
    $ php Samples/Payments/CoreServices/[Filename].php
```
e.g.
```
    $ php Samples/Payments/CoreServices/ProcessPayment.php
```
### Installation Notes
Note: If during "composer update", you get the error "composer failed to open stream invalid argument", go to your php.ini file (present where you have installed PHP), and uncomment the following lines:
```
extension=php_openssl.dll
extension=php_curl.dll
extension=php_mbstring.dll
extension=php_apcu.dll
```
On Windows systems, you also have to uncomment:
```
extension_dir = "ext"
```
Then run `composer update` again. You might have to restart your machine before the changes take effect.


### To set your API credentials for an API request,Configure the following information in Configuration.php file:
  
  #### For Http Signature Authentication 
  
  Configure the following information in cybs.properties file
  
*	Authentication Type:  Merchant should enter “HTTP_Signature” for HTTP authentication mechanism.
*	Merchant ID: Merchant will provide the merchant ID, which has taken from EBC portal.
*	MerchantSecretKey: Merchant will provide the secret Key value, which has taken from EBC portal.
*	MerchantKeyId:  Merchant will provide the Key ID value, which has taken from EBC portal.
*	Enable Log: To start the log entry provide true else enter false.
*   LogDirectory :Merchant will provide directory path where logs will be created.
*   LogMaximumSize :Merchant will provide size value for log file.
*   LogFilename  :Merchant will provide log file name.


```
   $this->authType = "HTTP_SIGNATURE";
   $this->runEnv = "cyberSource.environment.SANDBOX";
   $this->merchantID = <merchantID>;
   $this->apiKeyID = <merchantKeyId>;
   $this->screteKey = <merchantsecretKey>;
   
   $this->enableLog = true;
   $this->logSize = <size>;
   $this->logFile = <logDirectory>;
   $this->logFilename = <logFilename>;
   
   $this->proxyUrl = <proxyHost>;
   $this->proxyHost = <proxyPort>;

```
  #### For Jwt Signature Authentication

  Configure the following information in the cybs.properties file
  
*	Authentication Type:  Merchant should enter “JWT” for JWT authentication mechanism.
*	Merchant ID: Merchant will provide the merchant ID, which has taken from EBC portal.
*	keyAlias: Alias of the Merchant ID, to be used while generating the JWT token.
*	keyPassword: Alias of the Merchant password, to be used while generating the JWT token.
*	keyfilepath: Path of the folder where the .P12 file is placed. This file has generated from the EBC portal.
*   Keys Directory: path of the directory,where keys are placed.
*	Enable Log: To start the log entry provide true else enter false.
*   LogDirectory :Merchant will provide directory path where logs will be created.
*   LogMaximumSize :Merchant will provide size value for log file.
*   LogFilename  :Merchant will provide log file name.

```
   authenticationType  = Jwt
   merchantID 	       = <merchantID>
   runEnvironment      = CyberSource.Environment.SANDBOX
   keyAlias		       = <keyAlias>
   keyPassword	       = <keyPassword>
   keyFileName         = <keyFileName>
   keysDirectory       = <keysDirectory>
   enableLog           = true
   logDirectory        = <logDirectory>
   logMaximumSize      = <size>
   logFilename         = <logFilename>
```

### Switching between the sandbox environment and the production environment
CyberSource maintains a complete sandbox environment for testing and development purposes. This sandbox environment is an exact 
duplicate of our production environment with the transaction authorization and settlement process simulated. By default, this SDK is 
configured to communicate with the sandbox environment. To switch to the production environment, set the appropriate property 
in Resources\Configuration.php. For example:

```PHP
// For PRODUCTION use
  $this->runEnv = "cyberSource.environment.PRODUCTION";
```


