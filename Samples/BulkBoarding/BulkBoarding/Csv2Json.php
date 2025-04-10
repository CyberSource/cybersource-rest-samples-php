<?php

/*
 * A class to convert CSV Excel file to JSON.
 * First row will be the header defining the key name of each field (column). Dot notation is supported to indicate nested element. 
 * For example, the value "d" of a column with name "a.b.c" will be converted to { "a": { "b": { "c": "d" }}}
 * Each row will be inserted as a JSON element into the final JSON array.
 *
*/
class Csv2Json
{
    private $headerMapping = array();
    private $reverseheaderMapping = array();
    private $header = NULL;
    private $csvRawArr = [];
    private $csvArr = NULL;
    private $jsonObj = NULL;
    private $outJson = NULL;
    private $default = array(
      "productInformation.selectedProducts.payments.cardProcessing.subscriptionInformation.enabled"=>"TRUE",
      "productInformation.selectedProducts.payments.cardProcessing.subscriptionInformation.features.cardNotPresent.enabled"=>"TRUE"
    );
    
    // Constructor 
    // Take a CSV file as input and read in the head in first row.
    public function __construct($inputFile)
    {     
      try  
      {
        $this->csvRawArr = $this->readCSV($inputFile);   
      }
      catch (Exception $e)
      {
        throw new Exception("Reading input file error");
      }
      
      if (sizeof($this->csvRawArr) < 1)
        throw new Exception("Invalid input file error");
                
           
           
      $test=array_shift($this->csvRawArr); // Skip organisation ID and boarding Request ID
      $this->headers = array_shift($this->csvRawArr); // Skip column headers
      $test=array_shift($this->csvRawArr); // Skip column options
      $this->csvArr = $this->jsonObj = $this->outJson = NULL;
      $this->headerMapping = array();
      $this->reverseheaderMapping = array();
    }
    
    // Return the number of data row of input CSV file
    public function getNumOfRecords()
    {
      return sizeof($this->csvRawArr);
    }
    
    // Internal function to read in CSV file
    private function readCSV($filename) 
    {
      $rows = array();
      
      if (($handle = fopen($filename, "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
              $rows[] = $data;
          }
          fclose($handle);
      }
      
      return $rows;   
    }
    
    // Suppose "Alias" of column name
    // A mapping file can be used. The input CSV column name will be mapped to the actual JSON key names defined in the mapping file.
    public function readMapping($mapFile)
    {
      try
      {
        $this->mapArr = $this->readCSV($mapFile);  

        foreach ($this->mapArr as $row) {
          $this->headerMapping[$row[0]]["type"] = $row[2];
          $this->headerMapping[$row[0]]["map"] = $row[1];
          $this->reverseheaderMapping[$row[1]]["type"] = $row[2];
          $this->reverseheaderMapping[$row[1]]["map"] = $row[0];
        }      
      }
      catch (Exception $e)
      {
        throw new Exception("Reading mapping file error");
      }      
    }
    
    // Return the mapping array
    public function getMapping()
    {
      return $this->headerMapping;
    }

    // Apply the mapping (if any) and convert the CSV data array to array of key-value pairs.
    public function applyMapping()
    {
      // Generate the final array with custom indices
      $this->csvArr = array();
      foreach ($this->csvRawArr as $row) {
          $rowArray = array();
          foreach ($row as $index => $value) {
              
              $header = $this->headers[$index];
              //printf("%d %s %s\n", $index, $value, $header);
              if (isset($this->headerMapping[$header])) {
                  $rowArray[$this->headerMapping[$header]["map"]] = $value;
              }
              else
              {
                  printf("Mapping for $header is not found. Ignore.\n");
                  //$rowArray[$header] = $value;
              }
          }
          $this->csvArr[] = $rowArray;
      }      
    }
    
    private function &walkKey($keys, &$pointer)
    {
      $keyArr = explode(".", $keys);      
      for ($i=0;$i<(sizeof($keyArr));$i++)
      {
        $key=NULL;
        $pos = strpos($keyArr[$i], "[");
        if ($pos)
        {
            $key = substr($keyArr[$i], 0, $pos);
            $cpos = strpos($keyArr[$i], "]");
            $idx = substr($keyArr[$i], $pos+1, $cpos-$pos-1);
        }
        else
        {
            $key = $keyArr[$i];
        }
        if (!isset($pointer[$key]))
          $pointer[$key]=[];
        
        if ($pos)
        {
          if (!isset($pointer[$key][(int)$idx]))
            $pointer[$key][(int)$idx]=[];  
          $pointer=&$pointer[$key][(int)$idx];  
        }
        else
          $pointer=&$pointer[$key];
        /*
        printf("===============================" . PHP_EOL);
        printf($keyArr[$i] . PHP_EOL);
        print_r($this->jsonObj[$index]);
        sleep(5);
        */
      } 
      
      return $pointer;
    }
    
    private function addKey($keys, &$pointer, $value)
    {
      $p = &$this->walkKey($keys, $pointer);
      
      //print("-----------addKey-------\n");
      //print($keys);
      //print($this->reverseheaderMapping[$keys]["type"]);
      if ($this->reverseheaderMapping[$keys]["type"] == "bool")
      {
        if (strtolower($value) == "false")
          $p = false;
        elseif (strtolower($value) == "true")
          $p = true;
        else
          throw new Exception("$value is not boolean value."); 
      }
      elseif ($this->reverseheaderMapping[$keys]["type"] == "num")
      {
        $p = (int)$value;
        //print($value);
        //print($p);
        //print('\n');
      }
      elseif ($this->reverseheaderMapping[$keys]["type"] == "array")
      {
        $valueArray = explode(",", $value); 
        $p=$valueArray;
      }
      else
        $p=$value;  
    }
    
    // Decode the dot notation and construct the JSON structure
    public function toJsonObj()
    {
      if ($this->csvArr == NULL)
        $this->applyMapping();
      
      // Convert the array into JSON array which can be consumed by boarding API
      $this->jsonObj = [];
      foreach ($this->csvArr as $index => $row)
      {      
          if (!isset($this->jsonObj[$index]))
          {
            $this->jsonObj[$index]=[];
            $this->jsonObj[$index]["recordId"]=$row["recordId"];
            $this->jsonObj[$index]["operation"]=$row["operation"];
            $this->jsonObj[$index]["json"]=[];
          }
          
          $element = '$this->jsonObj[$index]';
          foreach ($row as $keys => $value)
          {        
            if ($this->reverseheaderMapping[$keys]["type"]=='invisible' ||
                $value == "")
              continue;
              
            $this->addKey($keys, $this->jsonObj[$index]["json"], $value);
          }
          
          if (isset($this->jsonObj[$index]["json"]["productInformation"]["selectedProducts"]["payments"]["cardProcessing"]))
          {
            foreach ($this->default as $keys => $value)
            {
              $this->addKey($keys, $this->jsonObj[$index]["json"], $value);
            }            
          }
          
          //FIXME: Need a better way to trigger some flags setup when its dependent fields are set
          if (isset($this->jsonObj[$index]["json"]["productInformation"]["selectedProducts"]["payments"]["cardProcessing"]["configurationInformation"]["configurations"]["common"]["processors"]))
          {
            $pointer = &$this->walkKey("productInformation.selectedProducts.payments.cardProcessing.configurationInformation.configurations.common.processors", $this->jsonObj[$index]["json"]);
            
            if (isset($pointer["vdchsbcbank"]))
            {
              $vpointer = &$pointer["vdchsbcbank"]["paymentTypes"];
            
              foreach ($vpointer as $keys => $value)
              {
                $vpointer[$keys]["enabled"] = true;
              }

              foreach ($vpointer as $keys => $value)
              {
                  $vpointer[$keys]["enabled"] = true;
                  foreach ($vpointer[$keys]["currencies"] as $keys2 => $value2)
                  {
                    $vpointer[$keys]["currencies"][$keys2]["enabled"] = true;
                    $vpointer[$keys]["currencies"][$keys2]["enabledCardPresent"] = false;
                    $vpointer[$keys]["currencies"][$keys2]["enabledCardNotPresent"] = true;
                  }
              }            
            }
            
            foreach (["amexdirect", "cupgpap"] as $processor)
            {
              if (isset($pointer[$processor]))
              {
                $vpointer = &$pointer[$processor];
                
                foreach ($vpointer["paymentTypes"] as $keys => $value)
                {
                    $vpointer["paymentTypes"][$keys]["enabled"] = true;
                } 
                foreach ($vpointer["currencies"] as $keys2 => $value2)
                {
                  $vpointer["currencies"][$keys2]["enabled"] = true;
                  $vpointer["currencies"][$keys2]["enabledCardPresent"] = false;
                  $vpointer["currencies"][$keys2]["enabledCardNotPresent"] = true;
                }              
              }              

            }            
          }

      }    

      return $this->jsonObj;
    }
    
    // Return the JSON structure object
    public function getJsonObj()
    {
      return $this->jsonObj;
    }
    
    // Convert JSON object to JSON string and return
    public function toJson()
    {
      if ($this->jsonObj == NULL)
        $this->toJsonObj();
      
      $this->outJson = json_encode($this->jsonObj, JSON_PRETTY_PRINT);
      
      return $this->outJson;
    }    
}

?>