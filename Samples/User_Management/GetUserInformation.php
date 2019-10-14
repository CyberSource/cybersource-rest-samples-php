<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function GetUserInformation()
{
	$organizationId = "testrest";
	$userName = null;
	$permissionId = "CustomerProfileViewPermission";
	$roleId = null;

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\UserManagementApi($api_client);

	try {
		$apiResponse = $api_instance->getUsers($organizationId, $userName, $permissionId, $roleId);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nGetUserInformation Sample Code is Running..." . PHP_EOL;
	echo "\nInput missing query parameter <organizationId>: ";
	$organizationId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <userName>: ";
	$userName = trim(fgets(STDIN));
	echo "\nInput missing query parameter <permissionId>: ";
	$permissionId = trim(fgets(STDIN));
	echo "\nInput missing query parameter <roleId>: ";
	$roleId = trim(fgets(STDIN));
	GetUserInformation($organizationId, $userName, $permissionId, $roleId);
}
?>
