<?php
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/cybersource/rest-client-php/lib/Authentication/Core/Authentication.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../SampleApiClient/connection/jwtUrlConnection.php';

class JwtService
{
	public function jwtService($method, $payload, $resourceUrl, $merchantConfig)
	{
		$getTok = new Authentication();
		$getToken = $getTok->getToken($resourceUrl, $payload, $method, $merchantConfig); 
		$conn = new JwtUrlConnection();
		$data = $conn->getConnection($getToken, $resourceUrl, $payload, $method, $merchantConfig);
		return $data;			
	}
}
?>