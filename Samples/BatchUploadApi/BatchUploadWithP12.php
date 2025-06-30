<?php
require_once __DIR__ . '/../../vendor/autoload.php';

function BatchUploadWithP12($flag)
{
    if (isset($flag) && $flag == "true") {
        $capture = true;
    } else {
        $capture = false;
    }
    $inputFile = dirname(__DIR__, 2) . '/Resources/batchApiMTLS/batchapiTest.csv';
    $envHostName = 'https://secure-batch-test.cybersource.com';
    $pgpEncryptionCertPath = dirname(__DIR__, 2) . '/Resources/batchApiMTLS/bts-encryption-public.asc';
    $clientCertP12FilePath = dirname(__DIR__, 2) . '/Resources/batchApiMTLS/pushtest.p12';
    $clientCertP12Password = 'changeit';
    $serverTrustCertPath = dirname(__DIR__, 2) . '/Resources/batchApiMTLS/serverCasCert.pem';

    $logConfig = new \CyberSource\Logging\LogConfiguration();

    $logConfig->enableLogging(true);

    $logConfig->setDebugLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "debugTest.log");
    $logConfig->setErrorLogFile(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Log" . DIRECTORY_SEPARATOR . "errorTest.log");    
    $logConfig->setLogDateFormat("Y-m-d\TH:i:s");
    $logConfig->setLogFormat("[%datetime%] [%level_name%] [%channel%] : %message%\n");
    $logConfig->setLogMaxFiles(3);
    $logConfig->setLogLevel("debug");
    $logConfig->enableMasking(true);


    $api_instance = new CyberSource\Api\BatchUploadApi($logConfig);

    try {
        // Call the upload API with P12
        list($response, $status, $headers) = $api_instance->uploadBatchWithP12(
            $inputFile,
            $envHostName,
            $pgpEncryptionCertPath,
            $clientCertP12FilePath,
            $clientCertP12Password,
            $serverTrustCertPath
        );

        print_r(PHP_EOL);
        print_r("HTTP Status: $status\n");
        print_r("Response: $response\n");

        WriteLogAudit($status);
        return [$response, $status, $headers];
    } catch (Exception $e) {
        print_r("\nError: " . $e->getMessage() . "\n");
        WriteLogAudit('Error');
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\BatchUploadWithP12 Sample Code is Running..." . PHP_EOL;
    BatchUploadWithP12('false');
}
?>
