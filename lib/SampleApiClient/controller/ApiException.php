<?php
/**
 * ApiException

 */

namespace CybSource;

use \Exception;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Log/Logger.php';

use CyberSource\Authentication\Log\Logger as Logger;

/**
 * ApiException Class Doc Comment
 *
 * @category Class
 * @package  CyberSource
 */
class ApiException extends Exception
{

    /**
     * The HTTP body of the server response either as Json or string.
     *
     * @var mixed
     */
    protected $responseBody;

    /**
     * The HTTP header of the server response.
     *
     * @var string[]
     */
    protected $responseHeaders;

    /**
     * The deserialized response object
     *
     * @var $responseObject;
     */
    protected $responseObject;

    protected $merchantConfig;

    /**
     * Constructor
     *
     * @param string   $message         Error message
     * @param int      $code            HTTP status code
     * @param string[] $responseHeaders HTTP response header
     * @param mixed    $responseBody    HTTP decoded body of the server response either as \stdClass or string
     */
    public function __construct($message = "", $code = 0, $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

    /**
     * Gets the HTTP response header
     *
     * @return string[] HTTP response headers
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Gets the HTTP body of the server response either as Json or string
     *
     * @return mixed HTTP body of the server response either as \stdClass or string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Sets the deseralized response object (during deserialization)
     *
     * @param mixed $obj Deserialized response object
     *
     * @return void
     */
    public function setResponseObject($obj)
    {
        $this->responseObject = $obj;
    }

    /**
     * Gets the deseralized response object (during deserialization)
     *
     * @return mixed the deserialized response object
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }
    
    /*
    * print the config error log in log file
    */
    public function setExceptionLog($merchantConfig, $exception)
    {
        if($merchantConfig->getDebug())
        {

            $logg = new Logger(get_class($this));
            $logg->initLogFile($merchantConfig);
            $date = date("Y-m-d H:i:s");
            if(is_array($exception))
            {
                
                error_log("[".$date."] [INFO] MERCHCFG:".print_r($exception, true).PHP_EOL, 3, $merchantConfig->getDebugFile().$merchantConfig->getLogFileName());

            }else{
                
                error_log("[".$date."] ".$exception.PHP_EOL, 3, $merchantConfig->getDebugFile().$merchantConfig->getLogFileName());
            }
            



        }
        
    }
    
}


