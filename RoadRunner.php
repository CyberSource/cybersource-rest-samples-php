<?php
require_once 'Data.php';
define("DO_NOT_RUN_SAMPLES", "true");
class Test extends PHPUnit\Framework\TestCase{
    /**
     *@dataProvider valueLoader
    */
    public function test_cases($road){     
     $value_list = array();
     $name = $road['uniqueName'];
     $dependent_name = $road['prerequisiteRoad'];
     $dependent_fields = $road['dependentFieldMapping'];
     //Fetching various dependency fields and pushing it to the argument list
     for($i = 0; $i < count($dependent_fields); $i++){
         if(Data::$fieldmap[$dependent_name.$dependent_fields[$i]] != null){
           array_push($value_list, Data::$fieldmap[$dependent_name.$dependent_fields[$i]]);
         }
     }
     $pathval = $road['sampleClassNames']['php'];
	 $pathval = str_replace(".", "\\", $pathval);
	 $path_arr = explode("\\", $pathval);
     $function_name = $path_arr[count($path_arr)-1];
	 $pathval = $pathval . ".php";
     require_once __DIR__. DIRECTORY_SEPARATOR . $pathval;
     //Calling the sample code function with the argument list
     $resp = $function_name(...$value_list);
     $data = $resp[0];
     $assertions = $road['Assertions'];
     $storedFields = $road['storedResponseFields'];
     //Storing all the stored response fields into the global map
     for($i = 0; $i < count($storedFields); $i++){
        $body = $data;
        $req_field_arr = explode(".", $storedFields[$i]);
        for($j = 0; $j < count($req_field_arr); $j++){
           if($body == null)break;
           $body = $body[$req_field_arr[$j]];
        }
        Data::$fieldmap[$name.$storedFields[$i]] = $body;
     }
     //Asserting for HTTP Status
     if($assertions != null){
        if($assertions['httpStatus'] != ''){
             $this->assertEquals($assertions['httpStatus'], $resp[1]);
        } 
        $expectedValues = $assertions['expectedValues'];
        //Asserting for Expected Values
        for($i = 0; $i < count($expectedValues); $i++){
           $body = $data;
           $field_arr = explode(".", $expectedValues[$i]['field']);
           for($j = 0; $j < count($field_arr); $j++){
                $body = $body[$field_arr[$j]];
            }
            $this->assertEquals($expectedValues[$i]['value'], $body, $function_name. ": ". $expectedValues[$i]['field']." not matching expected value. \n");
        }
        $requiredFields = $assertions['requiredFields'];
        //Asserting for required fields
        for($i = 0; $i < count($requiredFields); $i++){
            $body = $data;
            $req_field_arr = explode(".", $requiredFields[$i]);
            for($j = 0; $j < count($req_field_arr); $j++){
                $body = $body[$req_field_arr[$j]];
            }
            $this->assertNotNull($body, $requiredFields[$i]." is null.\n");
        }
     }

    }
    //Data Provider function which passes the road array element by element to the test function
    public function valueLoader(){
        $array = json_decode(file_get_contents("executor.json"),true);
        $roads = $array['Execution Order'];
        $road_array = array();
        for($i = 0; $i < count($roads); $i++){
            $road_array[] = array($roads[$i]);
        }
        return $road_array;
    }

}
?>