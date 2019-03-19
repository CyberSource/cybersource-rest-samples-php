<?php
/*
Purpose : Service file which having token and connce
*/
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Core/Authentication.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../SampleApiClient/connection/httpConnection.php';

use CyberSource\Authentication\Core\Authentication as Authentication;

class HttpService
{
	public function httpService($method, $payload, $resourceUrl, $merchantConfig)
	{
		
			$getTok = new Authentication();
			$getToken = $getTok->generateToken($resourceUrl, $payload, $method, $merchantConfig);
			$conn = new HttpConnection();
			$data = $conn->getConnection($getToken, $resourceUrl, $payload, $method, $merchantConfig);
			return $data;
				
	}
}

?>