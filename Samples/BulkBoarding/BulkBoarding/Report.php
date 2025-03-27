<?php

/*
 * A class to generate GPAP-specific CSV report from boarding and PECS API response
 *
*/
class Report
{
    // Constructor 
    public function __construct()
    {     
    }

    public function safeRead($object, $propertyPath) 
    {
      $properties = explode('->', $propertyPath);
      
      // For PECS, productInformationSetups[0] doesn't exist
      if (is_object($object) && $properties[0] == "productInformationSetups" && !property_exists($object, "productInformationSetups"))
        array_splice($properties, 0, 2);
      
      foreach ($properties as $property) {
          if (is_array($object))
            $object = isset($object[$property])? $object[$property]:"";
          elseif (is_object($object) && property_exists($object, $property)) {
              $object = $object->$property;
          } else {
              return "";
          }
      }
      return $object;
    }
    
    public function safeReadList($object, $propertyPath)
    {      
      $list = $this->safeRead($object, $propertyPath);
      $output = "";
      if (is_array($list))
      {
        foreach ($list as $ele)
          $output = $output . "Field:" . $ele->field . ",Reason:" . $ele->reason . "\n";      
      }
      else
        new Exception("Unknown object while expecting an array."); 
      
      return $output;
    }
    
    public function output($outputFile, $errorFile, $responses)
    {
      print("Response for report...\n");
      print_r($responses);   

      // Read in Report Column Definition file
      $file = fopen("report.def", "r");
      if ($file == false)
        return;
      
      while ($column =fgetcsv($file, 0, ","))
          $columns[] = $column;
      fclose($file);

      // Create report and error files
      $file = fopen($outputFile, "w");
      $errfile = fopen($errorFile, "w");
      $headers=[];
      $headers[]="Record ID";
      // Generate column headers for files
      foreach ($columns as $column)
        $headers[]=$column[1];
      fputcsv($file, $headers, ",");
      fputcsv($errfile, $headers, ",");
      
      $outarray=[];
      // For each merchant in row
      foreach ($responses as $index => $rowResponse)
      {
        // Each merchant may need extra PECI API to config, mulitple responses may be recevied
        foreach ($rowResponse as $rindex => $response)
        {
          $outarray[$index]=[];
          $outarray[$index][] = $index;
          $errflag = false;
          foreach ($columns as $column)
          {
            if ($column[0]=="direct")
              $outarray[$index][] = $response[$column[2]];
            elseif ($column[0]=="single")
            {
              $val = $this->safeRead($response[$column[2]], $column[3]);
              $outarray[$index][] = $val;
              if (strpos($column[1], "Config Status") || strpos($column[1], "Subs Status"))
                if (strtolower($val) != "success" && strtolower($val) != "complete")
                  $errflag = true;
            }
            elseif ($column[0]=="list")
              $outarray[$index][] = $this->safeReadList($response[$column[2]], $column[3]);
            else
              new Exception("Unknown report column type ". $column[0]); 
          }
          fputcsv($file, $outarray[$index], ",");
          if ($errflag)
            fputcsv($errfile, $outarray[$index], ",");
        }
      }
      fclose($file);
      fclose($errfile);
      printf("Report stored to " . $outputFile);
    }
}

?>