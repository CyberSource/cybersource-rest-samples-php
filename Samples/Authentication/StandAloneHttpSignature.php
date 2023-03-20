<?php

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
            if (substr($h[0], 0, 1) === "\t") {
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

// Function to generate the HTTP Signature
// param: resourcePath - denotes the resource being accessed
// param: httpMethod - denotes the HTTP verb
// param: currentDate - stores the current timestamp
function GetHttpSignature($resourcePath, $httpMethod, $currentDate)
{
    global $payload;
    global $merchant_id;
    global $request_host;
    global $merchant_secret_key;
    global $merchant_key_id;

    $digest = "";

    if($httpMethod == "get")
    {
        $signatureString = "host: " . $request_host . "\ndate: " . $currentDate . "\n(request-target): " . $httpMethod . " " . $resourcePath . "\nv-c-merchant-id: " . $merchant_id;
        $headerString = "host date (request-target) v-c-merchant-id";

    }
    else if($httpMethod == "post")
    {
        //Get digest data
        $digest = GenerateDigest($payload);

        $signatureString = "host: " . $request_host . "\ndate: " . $currentDate . "\n(request-target): " . $httpMethod . " " . $resourcePath . "\ndigest: SHA-256=" . $digest . "\nv-c-merchant-id: " . $merchant_id;
        $headerString = "host date (request-target) digest v-c-merchant-id";
    }

    $signatureByteString = utf8_encode($signatureString);
    $decodeKey = base64_decode($merchant_secret_key);
    $signature = base64_encode(hash_hmac("sha256", $signatureByteString, $decodeKey, true));
    $signatureHeader = array(
        'keyid="' . $merchant_key_id . '"',
        'algorithm="HmacSHA256"',
        'headers="' . $headerString . '"',
        'signature="' . $signature . '"'
    );

    $signatureToken = "Signature:" . implode(", ", $signatureHeader);

    $host = "Host:" . $request_host;
    $vcMerchant = "v-c-merchant-id:" . $merchant_id;
    $headers = array(
        $vcMerchant,
        $signatureToken,
        $host,
        'Date:' . $currentDate
    );

    if($httpMethod == "post"){
        $digestArray = array("Digest: SHA-256=" . $digest);
        $headers = array_merge($headers, $digestArray);
        echo "\t" . $digestArray[0] . PHP_EOL;
    }

    echo "\t" . $signatureToken . PHP_EOL;

    return $headers;
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

    $date = date("D, d M Y G:i:s ") . "GMT";

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
    echo "\tDate : " . $date . PHP_EOL;
    echo "\tHost : " . $request_host . PHP_EOL;

    $authHeaders = GetHttpSignature($resource, $method, $date);
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

    $resource = '/reporting/v3/reports?startTime=2021-02-01T00:00:00.0Z&endTime=2021-02-02T23:59:59.0Z&timeQueryType=executedTime&reportMimeType=application/xml';
    $method = "get";
    $statusCode = -1;
    $url = "https://" . $request_host . $resource;

    $resource = utf8_encode($resource);

    $date = date("D, d M Y G:i:s ") . "GMT";

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
    echo "\tDate : " . $date . PHP_EOL;
    echo "\tHost : " . $request_host . PHP_EOL;

    $authHeaders = GetHttpSignature($resource, $method, $date);
    $headerParams = array_merge($headers, $authHeaders);

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerParams);

    curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/cacert.pem');

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

function ProcessStandaloneHttpSignature()
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
    echo "StandAloneHttpSignature Sample Code is running...\n";
    ProcessStandaloneHttpSignature();
}

?>