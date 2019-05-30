<?php
/*
* Purpose: Api controller Its checks authType, and send it to the Services 
*/
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Util/GlobalParameter.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../services/httpService.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../services/jwtService.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../controller/ApiException.php';

use CyberSource\Authentication\Util\GlobalParameter as GlobalParameter;

class ApiController
{
	//Apicontroller functions begins
	public function apiController($method, $payloadData, $resourcePath, $merchantConfig)
	{
		$authType = $merchantConfig->getAuthenticationType();

		$exception = new ApiException();
		$messageAuthType = " [INFO]: ".GlobalParameter::REQTYPE ."=>".$method;
        $exception->setExceptionLog($merchantConfig, $messageAuthType);
		$exceptionMsg = GlobalParameter::LOG_END_MSG;
		if($authType==GlobalParameter::HTTP_SIGNATURE)
		{

			$callHttp = new HttpService();
			$callHttpData = $callHttp->httpService($method, $payloadData, $resourcePath, $merchantConfig);
			$exception->setExceptionLog($merchantConfig, $exceptionMsg);
			return $callHttpData;

		}
		else if($authType==GlobalParameter::JWT)
		{

			$callJwt = new JwtService();
			$callJwtData = $callJwt->jwtService($method, $payloadData, $resourcePath, $merchantConfig);
			$exception->setExceptionLog($merchantConfig, $exceptionMsg);
			return $callJwtData;

		}
		else
		{
			$error_message = GlobalParameter::AUTH_ERROR;
			$exception = new ApiException($error_message, 0, null, null);
            $exception->setExceptionLog($merchantConfig, $exception);
            throw $exception;
		}
	}
}

