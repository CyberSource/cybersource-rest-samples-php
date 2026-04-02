<?php

use Firebase\JWT\JWT as JWT;
use Ramsey\Uuid\Uuid;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';

// Initialization of constant data
// Try with your own credentaials
// Get Key ID, Secret Key and Merchant Id from EBC portal
$request_host = "apitest.cybersource.com";
$merchant_id = "testrest";
$merchant_key_id = "08c94330-f618-42a3-b09d-e1e43be5efda";
$merchant_secret_key = "yBJxy6LjM2TmcPGu+GaJrHtkke25fPpUX+UY6/L/1tE=";

$payload = "{\n" .
        "  \"clientReferenceInformation\": {\n" .
        "    \"code\": \"TC50171_3\"\n" .
        "  },\n" .
        "  \"processingInformation\": {\n" .
        "    \"commerceIndicator\": \"internet\"\n" .
        "  },\n" .
        "  \"orderInformation\": {\n" .
        "    \"billTo\": {\n" .
        "      \"firstName\": \"john\",\n" .
        "      \"lastName\": \"doe\",\n" .
        "      \"address1\": \"201 S. Division St.\",\n" .
        "      \"postalCode\": \"48104-2201\",\n" .
        "      \"locality\": \"Ann Arbor\",\n" .
        "      \"administrativeArea\": \"MI\",\n" .
        "      \"country\": \"US\",\n" .
        "      \"phoneNumber\": \"999999999\",\n" .
        "      \"email\": \"test@cybs.com\"\n" .
        "    },\n" .
        "    \"amountDetails\": {\n" .
        "      \"totalAmount\": \"10\",\n" .
        "      \"currency\": \"USD\"\n" .
        "    }\n" .
        "  },\n" .
        "  \"paymentInformation\": {\n" .
        "    \"card\": {\n" .
        "      \"expirationYear\": \"2031\",\n" .
        "      \"number\": \"5555555555554444\",\n" .
        "      \"securityCode\": \"123\",\n" .
        "      \"expirationMonth\": \"12\",\n" .
        "      \"type\": \"002\"\n" .
        "    }\n" .
        "  }\n" .
        "}";

// Function to parse response headers
// ref/credit: http://php.net/manual/en/function.http-parse-headers.php#112986
function httpParseHeaders($raw_headers)
{
    $headers = [];
    $key = '';
    foreach (explode("\n", $raw_headers) as $h) {
        $h = explode(':', $h, 2);
        if (isset($h[1])) {
            if (!isset($headers[$h[0]])) {
                $headers[$h[0]] = trim($h[1]);
            } elseif (is_array($headers[$h[0]])) {
                $headers[$h[0]] = array_merge($headers[$h[0]], [trim($h[1])]);
            } else {
                $headers[$h[0]] = array_merge([$headers[$h[0]]], [trim($h[1])]);
            }
            $key = $h[0];
        } else {
            if (substr($h[0], 0, 1)  === "\t") {
                $headers[$key] .= "\r\n\t".trim($h[0]);
            } elseif (!$key) {
                $headers[0] = trim($h[0]);
            }
            trim($h[0]);
        }
    }
    return $headers;
}

// Function used to generate the digest for the given payload
function GenerateDigest($requestPayload)
{
    $utf8EncodedString = utf8_encode($requestPayload);
    $digestEncode = hash("sha256", $utf8EncodedString, true);
    return base64_encode($digestEncode);
}

// Function to convert the provided pem cert to der
function PemToDer($Pem)
{
    $lines = explode("\n", trim($Pem));
    unset($lines[count($lines) - 1]);
    unset($lines[0]);
    return implode("\n", $lines);
}

// Function to extract serial number from X.509 certificate
function ExtractSerialNumber($x509Certificate)
{
    try {
        $certDetails = openssl_x509_parse($x509Certificate);
        
        if ($certDetails == null) {
            throw new Exception("Failed to parse X.509 certificate.");
        }
        
        if (!isset($certDetails['subject']) || $certDetails['subject'] == null) {
            throw new Exception("Certificate subject field not found or is null.");
        }
        
        if (!isset($certDetails['subject']['serialNumber']) || $certDetails['subject']['serialNumber'] == null) {
            throw new Exception("Serial number not found in certificate subject field.");
        }
        
        return $certDetails['subject']['serialNumber'];
        
    } catch (Exception $e) {
        throw new Exception("Error extracting serial number from certificate: " . $e->getMessage());
    }
}

// Function to extract resource path without query parameters
function ExtractResourcePath($resourcePath)
{
    if (empty($resourcePath)) {
        return "";
    }
    
    // Split the string to remove the query params
    $parts = explode('?', $resourcePath, 2);
    return $parts[0];
}

function GetJWTv2HeaderClaimSet()
{
    $headerClaimSet = array();
    // The 'typ' header claim is set to 'JWT' by default in the JWT::encode method, so there is no need to set it explicitly unless you want to use a different value.
    // The 'alg' and 'kid' header can be set using the algorithm and key ID respectively in the JWT::encode method.
    // Add any header claims to the $headerClaimSet array if needed.
    // e.g. if you want to add a custom header claim, you can do it like this:
    // $headerClaimSet["custom-header"] = "value";
    return $headerClaimSet;
}

// Function to generate JWT v2 payload
function GetJWTv2PayloadClaimSet($resourcePath, $payloadData, $method, $merchantId, $requestHost)
{   
    $method = strtoupper($method);
    $jwtPayloadClaimSet = array();
    
    // Setting the JWT digest and digest Algorithm when a POST, PUT, or PATCH request is made
    if ($method == 'POST' || $method == 'PUT' || $method == 'PATCH') {
        $digest = GenerateDigest($payloadData);
        $jwtPayloadClaimSet["digest"] = $digest;
        $jwtPayloadClaimSet["digestAlgorithm"] = "SHA-256";
    }
    
    // Set the iat and exp claims using epoch timestamps
    $currentTime = time();
    $jwtPayloadClaimSet["iat"] = $currentTime;
    $jwtPayloadClaimSet["exp"] = $currentTime + 120; // The token is set to expire 2 minutes after creation
    
    // Set the request method, host and resource path in the JWT body.
    $jwtPayloadClaimSet["request-method"] = strtoupper($method);
    $jwtPayloadClaimSet["request-host"] = $requestHost;
    $jwtPayloadClaimSet["request-resource-path"] = ExtractResourcePath($resourcePath);
    
    // Using merchant ID for non-metaKey implementation. (Use portfolio ID if metaKey is being used).
    $jwtPayloadClaimSet["iss"] = $merchantId;
    
    // Generate unique JWT ID
    $uuid = Uuid::uuid4();
    $jwtPayloadClaimSet["jti"] = $uuid->toString();
    
    // Set JWT version and merchant ID
    $jwtPayloadClaimSet["v-c-jwt-version"] = "2";
    $jwtPayloadClaimSet["v-c-merchant-id"] = $merchantId;
    
    return $jwtPayloadClaimSet;
}

// Function to generate the JWT v2 token
function GenerateJsonWebTokenv2($jwtPayloadClaimSet, $jwtHeaderClaimSet)
{
    $keyFileName = "testrest"; # This is the filename of the PKCS12 file without the .p12 extension. For example, if the file is named "testrest.p12", then the keyFileName variable should be set to "testrest".
    $keyFilePath = '../../Resources/'; # This is the path to the directory where the PKCS12 file is located, relative to the current file. In this example, the PKCS12 file is located in the "Resources" directory which is two levels up from the current directory, hence the "../../Resources/" path. Please update this variable if your file is located in a different directory.
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . $keyFilePath . $keyFileName . ".p12";
    $keyPass = "testrest";
    $keyalias = "testrest";

    $cert_store = file_get_contents($filePath);

    if (openssl_pkcs12_read($cert_store, $cert_info, $keyPass)) {
        $privateKey = $cert_info['pkey'];
        $x509Certificate = openssl_x509_read($cert_info['cert']);
        
        if (!$x509Certificate) {
            throw new Exception("Failed to read X.509 certificate");
        }
        
        // Extract serial number for kid value in header Claim Sets
        $kid = strval(ExtractSerialNumber($x509Certificate));

        return JWT::encode($jwtPayloadClaimSet, $privateKey, "RS256", $kid, $jwtHeaderClaimSet);
    } else {
        throw new Exception("Failed to read P12 certificate file");
    }
}

// Function to get the JWT v2 token
// param: resourcePath - denotes the resource being accessed
// param: httpMethod - denotes the HTTP verb
// param: payloadData - the request payload (for POST/PUT/PATCH requests)
function GetJsonWebTokenv2($resourcePath, $httpMethod, $payloadData = null)
{
    global $merchant_id;
    global $request_host;

    try {
        // Generate JWT v2 payload with all required claims
        $jwtPayloadClaimSet = GetJWTv2PayloadClaimSet($resourcePath, $payloadData, $httpMethod, $merchant_id, $request_host);
        //Generate the JWT v2 header claim set
        $jwtHeaderClaimSet = GetJWTv2HeaderClaimSet();
        // Generate the JWT v2 token
        $tokenHeader = GenerateJsonWebTokenv2($jwtPayloadClaimSet, $jwtHeaderClaimSet);
        return "Bearer " . $tokenHeader;
        
    } catch (Exception $e) {
        echo PHP_EOL . " -- JWT v2 ERROR --" . PHP_EOL;
        echo "Error generating JWT v2 token: " . $e->getMessage();
        throw $e;
    }
}


// HTTP POST request
function ProcessPost()
{
    global $payload;
    global $request_host;
    global $merchant_id;

    $resource = "/pts/v2/payments/";
    $method = "post";
    $statusCode = -1;
    $url = "https://" . $request_host . $resource;

    $resource = utf8_encode($resource);

    $signatureString ="";

    $headerParams = [];
    $headers = [];

    $headerParams['Accept'] = 'application/hal+json;charset=utf-8';
    $headerParams['Content-Type'] = 'application/json;charset=utf-8';

    foreach ($headerParams as $key => $val) {
        $headers[] = "$key: $val";
    }

    echo "\n -- RequestURL -- " . PHP_EOL;
    echo "\tURL : " . $url;
    echo "\n -- HTTP Headers -- " . PHP_EOL;
    echo "\tContent-Type : " . 'application/json;charset=utf-8' . PHP_EOL;
    echo "\tv-c-merchant-id : " . $merchant_id . PHP_EOL;
    echo "\tHost : " . $request_host . PHP_EOL;

    $jsonWebToken = GetJsonWebTokenv2($resource, $method, $payload);
    $authHeaders = array(
                'Authorization:' . $jsonWebToken
            );
    $headerParams = array_merge($headers, $authHeaders);

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerParams);

    curl_setopt($curl, CURLOPT_CAINFO, __DIR__. DIRECTORY_SEPARATOR . '../../Resources/cacert.pem');

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_HEADER, 1);

    curl_setopt($curl, CURLOPT_VERBOSE, 0);

    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0");

    $response = curl_exec($curl);

    $http_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $http_header = httpParseHeaders(substr($response, 0, $http_header_size));
    $http_body = substr($response, $http_header_size);
    $response_info = curl_getinfo($curl);

    if ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299)
    {
        $statusCode = 0;
        $data = json_decode($http_body);
        if (json_last_error() > 0)
        {
            $data = $http_body;
        }
    }

    echo "\n -- Response Message -- " . PHP_EOL;
    echo "\tResponse Code :" . strval($response_info['http_code']) . PHP_EOL;
    echo "\tv-c-correlation-id :" . $http_header['v-c-correlation-id'] . PHP_EOL;
    echo "\tResponse Data :\n";
    print_r(strval($http_body));
    echo PHP_EOL . PHP_EOL;

    return $statusCode;
}

// HTTP GET request
function ProcessGet()
{
    global $request_host;
    global $merchant_id;

    $resource = '/tms/v2/customers/AB695DA801DD1BB6E05341588E0A3BDC/shipping-addresses/AB6A54B97C00FCB6E05341588E0A3935';
    $method = "get";
    $statusCode = -1;
    $url = "https://" . $request_host . $resource;

    $resource = utf8_encode($resource);

    $signatureString ="";

    $headerParams = [];
    $headers = [];

    $headerParams['Accept'] = 'application/json;charset=utf-8';
    $headerParams['Content-Type'] = 'application/json;charset=utf-8';

    foreach ($headerParams as $key => $val) {
        $headers[] = "$key: $val";
    }

    echo "\n -- RequestURL -- " . PHP_EOL;
    echo "\tURL : " . $url;
    echo "\n -- HTTP Headers -- " . PHP_EOL;
    echo "\tContent-Type : " . 'application/json;charset=utf-8' . PHP_EOL;
    echo "\tv-c-merchant-id : " . $merchant_id . PHP_EOL;
    echo "\tHost : " . $request_host . PHP_EOL;

    $jsonWebToken = GetJsonWebTokenv2($resource, $method);
    $authHeaders = array(
                'Authorization:' . $jsonWebToken
            );
    $headerParams = array_merge($headers, $authHeaders);

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerParams);

    curl_setopt($curl, CURLOPT_CAINFO, __DIR__. DIRECTORY_SEPARATOR . '../../Resources/cacert.pem');

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_HEADER, 1);

    curl_setopt($curl, CURLOPT_VERBOSE, 0);

    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0");

    $response = curl_exec($curl);

    $http_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $http_header = httpParseHeaders(substr($response, 0, $http_header_size));
    $http_body = substr($response, $http_header_size);
    $response_info = curl_getinfo($curl);

    if ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299)
    {
        $statusCode = 0;
        $data = json_decode($http_body);
        if (json_last_error() > 0)
        {
            $data = $http_body;
        }
    }

    echo "\n -- Response Message -- " . PHP_EOL;
    echo "\tResponse Code :" . strval($response_info['http_code']) . PHP_EOL;
    echo "\tv-c-correlation-id :" . $http_header['v-c-correlation-id'] . PHP_EOL;
    echo "\tResponse Data :\n";
    print_r(strval($http_body));
    echo PHP_EOL . PHP_EOL;

    return $statusCode;
}

function ProcessStandAloneJWT()
{
    // HTTP POST REQUEST
    echo "\n\nSample 1: POST call - CyberSource Payments API - HTTP POST Payment request";
    $statusCode = ProcessPost();
    $statusCodePost = $statusCode;

    if ($statusCode == 0)
    {
        echo "STATUS : SUCCESS (HTTP Status = " . strval($statusCode) . ")";
    }
    else
    {
        echo "STATUS : ERROR (HTTP Status = " . strval($statusCode) . ")";
    }

    // HTTP GET REQUEST
    echo "\n\nSample 2: GET call - CyberSource Reporting API - HTTP GET Reporting request";
    $statusCode = ProcessGet();
    $statusCodeGet = $statusCode;

    if ($statusCode == 0)
    {
        echo "STATUS : SUCCESS (HTTP Status = " . strval($statusCode) . ")";
    }
    else
    {
        echo "STATUS : ERROR (HTTP Status = " . strval($statusCode) . ")";
    }

    if ($statusCodeGet == 0 && $statusCodePost == 0)
    {
        WriteLogAudit(200);
    }
    else
    {
        WriteLogAudit(400);
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status\n");
    }
}

if (!defined('DO_NOT_RUN_SAMPLES'))
{
    echo "StandAloneJWT Sample Code is running...\n";
    ProcessStandAloneJWT();
}

?>