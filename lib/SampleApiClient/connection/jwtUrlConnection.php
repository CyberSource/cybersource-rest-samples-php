<?php
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Util/GlobalParameter.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Util/PropertiesUtil.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Core/MerchantConfiguration.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../controller/ApiException.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../masking/maskingController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../connection/connection.php';

class JwtUrlConnection implements ConnectionHeaders
{
    
    //REST API services using CURL 
    public function getConnection($token, $resourcePath, $postData, $method, $merchantConfig)
    { 
        $headers = [];
        $response = [];
        $headers = array(
            'Content-Type:application/json',
            'User-Agent:Mozilla/5.0',
            'Authorization:'.$token

           
        ); 
        if($method == GlobalParameter::POST || $method == GlobalParameter::PUT){
            $digestCon = new GetPayloadDigest();
            $digest = $digestCon->digestGenerate($postData);
            $digestArry = array(GlobalParameter::POSTHTTPDIGEST.$digest);
            $headers = array_merge($headers, $digestArry);
        }
        if($headers)
            echo "<pre>";print_r($headers);

        $url = GlobalParameter::HTTPURL.$merchantConfig->getHost().$resourcePath;

        //Curl initialization
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if($merchantConfig->getCurlProxyHost()){
            curl_setopt($ch, CURLOPT_PROXY, $merchantConfig->getCurlProxyHost());
        }
        if($merchantConfig->getCurlProxyPort()){
            curl_setopt($ch, CURLOPT_PROXYPORT, $merchantConfig->getCurlProxyPort());
        }
        
        if ($method === GlobalParameter::POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method === GlobalParameter::HEAD) {
            curl_setopt($ch, CURLOPT_NOBODY, true);
        } elseif ($method === GlobalParameter::OPTIONS) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "OPTIONS");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method === GlobalParameter::PATCH) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method === GlobalParameter::PUT) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method === GlobalParameter::DELETE) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        } elseif ($method !== GlobalParameter::GET) {
            throw new ApiException('Method ' . $method . ' is not recognized.');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        $dateTime = date("Y-m-d H:i:s");
        //Masking the response code
        $masking = new Masking();
        // debugging for curl
        if ($merchantConfig->getDebug()) {
            
            $logg = new Logger();
            $logg->loggerDirectory($merchantConfig);
            
            if($method == GlobalParameter::POST)
                $postData = $masking->dataMasking($postData);
            //loggerDirectory
            error_log("[".$dateTime."] [DEBUG] HTTP Request body  ~BEGIN~".PHP_EOL.print_r($postData, true).PHP_EOL."~END~".PHP_EOL, 3, $merchantConfig->getDebugFile().$merchantConfig->getLogFileName());
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_STDERR, fopen($merchantConfig->getDebugFile().$merchantConfig->getLogFileName(), 'a'));
        } else {
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
        }

        // obtain the HTTP response headers
        curl_setopt($ch, CURLOPT_HEADER, 1);
        // Make the request
        if(!$response = curl_exec($ch)) 
        { 
            trigger_error(curl_error($ch)); 
        }
        $http_header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $http_header = $this->httpParseHeaders(substr($response, 0, $http_header_size));
        $http_body = substr($response, $http_header_size);
        $response_info = curl_getinfo($ch);
        $responseType = null;

        // debug HTTP response body
        if ($merchantConfig->getDebug()) {
            $http_body = $masking->dataMasking($http_body);
            error_log("[".$dateTime."] [DEBUG] HTTP Response body ~BEGIN~".PHP_EOL.print_r($http_body, true).PHP_EOL."~END~".PHP_EOL, 3, $merchantConfig->getDebugFile().$merchantConfig->getLogFileName());
        }

        // Handle the response
        if ($response_info['http_code'] === 0) {
            $ch_error_message = curl_error($ch);

            // curl_exec can sometimes fail but still return a blank message from curl_error().
            if (!empty($ch_error_message)) {
                $error_message = "API call to $url failed: $ch_error_message";
            } else {
                $error_message = "API call to $url failed, but for an unknown reason. " .
                    "This could happen if you are disconnected from the network.";
            }

            $exception = new ApiException($error_message, 0, null, null);
            $exception->setResponseObject($response_info);
            throw $exception;
        } elseif ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299) {
            // return raw body if response is a file
            if ($responseType === '\SplFileObject' || $responseType === 'string') {
                return [$http_body, $response_info['http_code'], $http_header];
            }

            if(!empty($http_body)){
                $data = stripslashes($http_body);
            } 
        } else {
            if(!empty($http_body)){
                $data = stripslashes($http_body);
            } 
            throw new ApiException(
                "[".$response_info['http_code']."] Error connecting to the API ($url)",
                $response_info['http_code'],
                $http_header,
                $data
            );
        }
        return [$data, $response_info['http_code'], $http_header];
    }   

    public function httpParseHeaders($raw_headers)
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
    

} 

?>