# PHP Sample Code for the CyberSource SDK

[![Build Status](https://app.travis-ci.com/CyberSource/cybersource-rest-samples-php.svg?branch=master)](https://app.travis-ci.com/CyberSource/cybersource-rest-samples-php)

This repository contains working code samples which demonstrate PHP integration with the CyberSource REST APIs through the [CyberSource PHP SDK](https://github.com/CyberSource/cybersource-rest-client-php).
 

## Using the Sample Code

The samples are all completely independent and self-contained. You can analyze them to get an understanding of how a particular method works, or you can use the snippets as a starting point for your own project.

You can also run each sample directly from the command line.

## Requirements

* PHP 5.6+
* Enable cURL PHP Extension
* Enable JSON PHP Extension
* Enable PHP_APCU PHP Extension. You will need to download it for your platform (Windows/Linux/Mac) 
* [CyberSource Account](https://developer.cybersource.com/api/developer-guides/dita-gettingstarted/registration.html)
* [CyberSource API Keys](https://developer.cybersource.com/api/developer-guides/dita-gettingstarted/registration/createCertSharedKey.html)

### Running the Samples From the Command Line

* Clone this repository:

```bash
    git clone https://github.com/CyberSource/cybersource-rest-samples-php
```
* Run composer with the "update" option in the root directory of the repository.

```bash
    composer update
```

* Run the individual samples by name. For example:

```bash
    php Samples/Payments/Payments/[Filename].php
```

e.g.

```bash
    php Samples/Payments/Payments/SimpleAuthorizationInternet.php
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

### To set your own sandbox credentials for an API request, configure the following information in Resources/ExternalConfiguration.php file:

* Http

```php
    $this->authType           = "http_signature";
    $this->merchantID         = "your_merchant_id";
    $this->apiKeyID           = "your_key_serial_number";
    $this->secretKey          = "your_shared_secret";
```

* Jwt

```php
    $this->authType           = "jwt";
    $this->merchantID         = "your_merchant_id";
    $this->keyAlias           = "your_merchant_id";
    $this->keyPass            = "your_merchant_id";
    $this->keyFilename        = "your_merchant_id";
    $this->keyDirectory       = "./Resources/";
```

* MetaKey Http

```php
    $this->authType           = "http_Signature";
    $this->merchantID         = "your_child_merchant_id";
    $this->apiKeyId           = "your_metakey_serial_number";
    $this->secretKey          = "your_metakey_shared_secret";
    $this->portfolioId        = "your_portfolio_id";
    $this->useMetaKey         = true;
```

* MetaKey JWT

```php
    $this->authType            = "jwt";
    $this->merchantID          = "your_child_merchant_id";
    $this->keyAlias            = "your_child_merchant_id";
    $this->keyPass             = "your_portfolio_id";
    $this->keyFilename         = "your_portfolio_id";
    $this->keyDirectory        = "./Resources/";
    $this->useMetaKey          = true;
```

## Run Environments

The run environments that were supported in CyberSource PHP SDK have been deprecated.
Moving forward, the SDKs will only support the direct hostname as the run environment.

For the old run environments previously used, they should be replaced by the following hostnames:

|              Old Run Environment              |               New Hostname Value               |
|-----------------------------------------------|------------------------------------------------|
|`cybersource.environment.SANDBOX`              |`apitest.cybersource.com`                       |
|`cybersource.environment.PRODUCTION`           |`api.cybersource.com`                           |
|`cybersource.environment.mutualauth.SANDBOX`   |`api-matest.cybersource.com`                    |
|`cybersource.environment.mutualauth.PRODUCTION`|`api-ma.cybersource.com`                        |
|`cybersource.in.environment.SANDBOX`           |`apitest.cybersource.com`                       |
|`cybersource.in.environment.PRODUCTION`        |`api.in.cybersource.com`                        |

For example, replace the following code in the Configuration file:

```php
   // For TESTING use
      $this->runEnv      = "cyberSource.environment.SANDBOX"
   // For PRODUCTION use
   // $this->runEnv      = "cyberSource.environment.PRODUCTION"
```

with the following code:

```php
   // For TESTING use
      $this->runEnv      = "apitest.cybersource.com"
   // For PRODUCTION use
   // $this->runEnv      = "api.cybersource.com"
```

### Switching between the sandbox environment and the production environment

CyberSource maintains a complete sandbox environment for testing and development purposes. This sandbox environment is an exact duplicate of our production environment with the transaction authorization and settlement process simulated. By default, this SDK is configured to communicate with the sandbox environment. To switch to the production environment, set the appropriate environment constant.  For example:

```php
   // For TESTING use
      $this->runEnv = "apitest.cybersource.com";
   // For PRODUCTION use
   // $this->runEnv = "api.cybersource.com";
```

The [API Reference Guide](https://developer.cybersource.com/api/reference/api-reference.html) provides examples of what information is needed for a particular request and how that information would be formatted. Using those examples, you can easily determine what methods would be necessary to include that information in a request using this SDK.

### Logging

[![Generic badge](https://img.shields.io/badge/LOGGING-NEW-GREEN.svg)](https://shields.io/)

Since v0.0.24, a new logging framework has been introduced in the SDK. This new logging framework makes use of Monolog, and standardizes the logging so that it can be integrated with the logging in the client application.

More information about this new logging framework can be found in this file : [Logging.md](Logging.md)
