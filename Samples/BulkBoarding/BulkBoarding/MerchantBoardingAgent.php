<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/MerchantBoardingConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Report.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Csv2Json.php';

use CyberSource\Logging\LogFactory as LogFactory;
use Ramsey\Uuid\Uuid;


/*
 * Exception handling including generating log and update audit trail event in DB 
 * Construct the exception response for reporting purpose
 * 
 * @param int $rowid The DB entry for update (required)
 * @param object $exception Exception object (required)
 * @return array Except response
*/
function exceptionHandling($rowid, $exception)
{
  global $logger;
  
  $body=print_r($exception->getResponseBody(), true);         
  $message=print_r($exception->getMessage(), true);       
  $errorCode = $exception->getCode();
 
  $logger->error($errorCode);
  $logger->error($body);
  $logger->error($message);

  return [ 
      [
          "submitTimeUtc"=> $exception->getResponseBody()->submitTimeUtc,
          "status"=> $exception->getResponseBody()->status,
          "reason"=> $exception->getResponseBody()->reason,
          "message"=> $exception->getResponseBody()->message,
          "details"=> property_exists($exception->getResponseBody(), "details")?$exception->getResponseBody()->details:""
      ], 
      $errorCode, 
      []
    ];
}

/*
 * Take a JSON objects which contains the merchant boarding/product information. 
 * Invoke boarding API if registering new merchant is needed. Otherwise,
 * invoke PECS API to do production configuration update.
 * 
 * @param array $reqObj Merchant boarding information objects (required)
 * @param bool $needCreate Define if a new merchant is being onboard (optional)
 * @return array API responses
*/
function updateRegistration($reqObj, $needCreate=false)
{
  global $api_client, $logger;
  
  $boardapi_instance = new CyberSource\Api\MerchantBoardingApi($api_client);
  $configapi_instance = new CyberSource\Api\MerchantConfigurationApi($api_client);
  
  if (isset($reqObj["addition"]))
  {
    $additionSetups = $reqObj["addition"];
    unset($reqObj["addition"]);
  }

  $organizationId = $reqObj["organizationInformation"]["organizationId"];
  $registerSuccess=false;
  $response = [];
  $rowid = -1;
  try {
    if ($needCreate)
    {
      $logger->info("Start to onboard merchant...");
      $logger->debug(json_encode($reqObj));   

      printf("Registering...\n");
      $res = $boardapi_instance->postRegistration(json_encode($reqObj));
      $registerSuccess=true;
    }
    else
    {
      $logger->info("Start to update merchant...");
      $logger->debug(json_encode($reqObj));   

      printf("Updating...\n");
      $res = $configapi_instance->postConfiguration(json_encode($reqObj), $organizationId);    
    }
  } catch (Cybersource\ApiException $e) {
    // Construct response from exception
    $res = exceptionHandling($rowid, $e);
  }
  $response[] = $res; 
  
  //FIXME: When a product allowing existence of multiple profiles (For example, SA), 
  // Boarding API currently only support 1 profile assignment during registration.
  // Here uses PECS API as a workaround to assign remaining profiles to the MID
  if (isset($additionSetups))
  {
    //FIXME: Seems it needs some time from backend to sync data after registration before PECS can configure card processing on the newly added MID
    if ($registerSuccess)
    {
      print("Do a strategic sleep...\n");
      sleep(5);
    }
    
    printf("Additional product enablement...\n");
    foreach($additionSetups as $additionSetup)
    {
      $logger->info("Extra product configurations");

      try {
      
        $res = $configapi_instance->postConfiguration(json_encode($additionSetup), $organizationId);  
         
      } catch (Cybersource\ApiException $e) {
        // Construct response from exception
        $res = exceptionHandling($rowid, $e);        
      }
      $response[] = $res;        
    }
  }

  return $response;
}

/*
 * Take an array of JSON objects which contains the merchant boarding information and 
 * invoke boarding API to register merchant one by one
 * 
 * @param array $reqObjArr Array of merchant boarding information objects (required)
 * @return array Array of API responses
*/
function createRegistration($reqObjArr)
{ 
  $apiResponseArr=[];
  for ($i=0;$i<sizeof($reqObjArr);$i++)
  {
    $needCreate=false;
    if ($reqObjArr[$i]["operation"] == "board" || $reqObjArr[$i]["operation"] == "update")
    {
      if ($reqObjArr[$i]["operation"] == "board")
        $needCreate=true;
      
      $reqObj = $reqObjArr[$i]["json"];
      $recordId=intval($reqObjArr[$i]["recordId"]);
      
      $apiResponseArr[$recordId] = updateRegistration($reqObj, $needCreate);
      
    }
  }
  
  return $apiResponseArr;
}

/*
 * Get the configuration of a given MID
 * 
 * @param str $organizationId Define the organization ID being query (required)
 * @return object Json object of the MID configuration. False if MID doesn't exist.
*/
function getConfiguration($organizationId)
{
  global $api_client, $logger;

  $api_instance = new CyberSource\Api\MerchantConfigurationApi($api_client);
  
  $logger->info("Retrieving configuration for " . $organizationId); 
  
  try {
    $apiResponse = $api_instance->getConfiguration($organizationId);
    if ($apiResponse[1] >= 200 && $apiResponse[1] <300)
      return $apiResponse[0];
  } catch (Cybersource\ApiException $e) {
    $errorCode = $e->getCode();
  }

  return FALSE;
}

/*
 * Get a full list of MID under a portfolio
 * 
 * @return object Json object of the MIDs
*/
function getOrganization()
{
  global $api_client, $logger;

  $api_instance = new CyberSource\Api\MerchantConfigurationApi($api_client);
  
  $logger->info("Retrieving organization list...");

  $apiResponse = $api_instance->getOrganizations();
  
  if ($apiResponse[1] >= 200 && $apiResponse[1] <300)
    return $apiResponse[0];
  
  return FALSE;
}

/*
 * Backup all input files to specific path for future reference
 * 
 * @param array $inputFiles Array of input files (required)
 * @param str $outputPath Output destination path (required)
 * @return UUID generated for this execution
*/
function backupFiles($inputFiles, $outputPath)
{
  $uuid = Uuid::uuid4();
  $path = $outputPath . $uuid->toString() . "/";
  mkdir($path, 0777, true);
  foreach ($inputFiles as $fn)
  {
    if (file_exists($fn))
      copy($fn, $path . basename($fn));
  }
  
  return $uuid->toString();
}

/*
  Main entry point
  
  Input: None
  Output: True, exit gracefully
          False, exit with error
*/
function MerchantBoardingAgent()
{
    global $logger, $reporter;
    static $LOGPATH="Log/backup/";
  
    // Parse the command line options
    $shortopts  = "dg:hi:j:lm:";  
    $longopts  = array(
    );
    $options = getopt($shortopts, $longopts);

    // Print usage
    if (isset($options["h"]))
    {
      printf("Usage: php " . basename(__FILE__) . " [options...]\n");
      printf(" -d\t\t\tDry run\n");
      printf(" -i <file>\t\t\tMerchant CSV file\n");
      printf(" -j <file>\t\t\tMerchant JSON file\n");
      printf(" -m <file>\t\t\tHeader Mapping definition file\n");
      printf(" -l\t\t\tList all organizations\n");
      printf(" -g <organization ID>\t\t\tObtain the MID configurations\n");
      return TRUE;
    }
    
    if (isset($options["g"]))
    {
      $cfgJson = getConfiguration($options["g"]);      
      
      if ($cfgJson)
      {
        printf("%s", json_encode($cfgJson, JSON_PRETTY_PRINT));
        return TRUE;
      }
      else
      {
        printf($options["g"] . " is not found\n");
        return FALSE;
      }
    }

    if (isset($options["l"]))
    {
      $cfgJson = getOrganization();      
      
      if ($cfgJson)
      {
        printf("%s", json_encode($cfgJson, JSON_PRETTY_PRINT));
        return TRUE;
      }
      else
        return FALSE;
    }

    // Merchant CSV file and header mapping definition file are required
    if (!isset($options["i"]) && !isset($options["j"]))
    {    
      $logger->error("Merchant file must be provided.");
      return FALSE;
    }
    elseif (isset($options["i"]) && !isset($options["m"]))
    {
      $logger->error("Column mapping must be provided if CSV is used as input.");
      return FALSE;
    }
    
    if (isset($options["j"]))
    {
      $jsonStr = file_get_contents($options["j"]);
      $jsonObjs = json_decode($jsonStr, true);
      
      if ($jsonObjs != true)
      {
        printf("Invalid Json file format.\n");
        return FALSE;
      }      
      // Backup the input files for investigation
      $execId = backupFiles([$options["j"]], $LOGPATH);
    }
    else
    {
      // Convert the rows in CSV file into array of JSON objects
      printf("Converting files...\n");
      $ci = new Csv2Json($options["i"]);
      $ci->readMapping($options["m"]);
      $ci->applyMapping();
      $jsonObjs = $ci->toJsonObj();   
      
      //print_r($ci->getMapping());
      
      // Backup the input files for investigation
      $execId = backupFiles([$options["i"], $options["m"]], $LOGPATH);
      file_put_contents($options["i"] . ".json", json_encode($jsonObjs, JSON_PRETTY_PRINT));      
    }

    $logger->info("Input files are backuped to $LOGPATH/$execId");

    if (!isset($options["d"]))
    {
      // Invoke boarding API for merchant registrations
      $res = createRegistration($jsonObjs);

      //TODO: A output module to put the result in a file or on to console
      $reporter->output("report.csv", "error.csv", $res);
    }

    return True;   
}

// Set the timezone to Hong Kong
date_default_timezone_set('Asia/Hong_Kong');

// Create all required objects
$reporter = new Report();
$commonElement = new CyberSource\MerchantBoardingConfiguration();
$config = $commonElement->ConnectionHost();
$merchantConfig = $commonElement->merchantBoardingConfigObject();

$api_client = new CyberSource\ApiClient($config, $merchantConfig);
$logger = (new LogFactory())->getLogger(\CyberSource\Utilities\Helpers\ClassHelper::getClassName(get_class($api_client)), $api_client->merchantConfig->getLogConfiguration());

// Call the main program entry
if(!defined('DO_NOT_RUN_SAMPLES')){
    $username = getenv('USERNAME');
    $ipAddress = getHostByName(getHostName());
    
    $logger->info("Merchant Boarding Agent is Running on $ipAddress by $username ..." . PHP_EOL);
    MerchantBoardingAgent();
}
?>
