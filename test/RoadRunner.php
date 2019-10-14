<?php

define("DO_NOT_RUN_SAMPLES", "true");

class Test extends PHPUnit\Framework\TestCase {
	public static $fieldmap = array();
    /**
    *@dataProvider valueLoader
    */
    public function test_cases($road) {
        $value_list = array();

        $pathval = $road['sampleClassNames']['php'];
		$pathval = str_replace(".", "\\", $pathval);
		$path_arr = explode("\\", $pathval);
        
		$function_name = $path_arr[count($path_arr) - 1];
		$pathval = $pathval . ".php";

		$start_line = PHP_EOL . PHP_EOL . '##### RUNNING SAMPLE CODE FOR ' . $pathval . ' #####' . PHP_EOL;
		$end_line = '##### ENDING SAMPLE CODE FOR ' . $pathval . ' #####' . PHP_EOL . PHP_EOL;
		$console_line = 'RUNNING SAMPLE CODE FOR ' . $pathval . PHP_EOL;

		$name = $road['uniqueName'];
        $dependent_name = $road['prerequisiteRoad'];
		$dependent_fields = $road['dependentFieldMapping'];
		
		if (strpos($pathval, "GetReportDefinition") !== false) {
			array_push($value_list, "TransactionRequestClass");
		} else if (strpos($pathval, "Token_Management") !== false) {
			array_push($value_list, "93B32398-AD51-4CC2-A682-EA3E93614EB1");
		}

        //Fetching various dependency fields and pushing it to the argument list
        for($i = 0; $i < count($dependent_fields); $i++) {
            if(self::$fieldmap[$dependent_name.$dependent_fields[$i]] != null) {
                 array_push($value_list, self::$fieldmap[$dependent_name.$dependent_fields[$i]]);
            }
		}
		
		if (strpos($pathval, "RetrieveTransaction") !== false || strpos($pathval, "DeleteInstrumentIdentifier") !== false || 
			strpos($pathval, "RetrieveAvailableReports") !== false || strpos($pathval, "RetrieveAllPaymentInstruments") !== false) {
				sleep(20);
			}
        
		fwrite(STDOUT, print_r($start_line, TRUE));
		fwrite(STDERR, print_r($console_line, TRUE));
        
		require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $pathval;
		
        //Calling the sample code function with the argument list
        $resp = $function_name(...$value_list);
        $data = $resp[0];
        
		$assertions = $road['Assertions'];
        $storedFields = $road['storedResponseFields'];
        
		//Storing all the stored response fields into the global map
        for($i = 0; $i < count($storedFields); $i++) {
			$body = $data;
			if($body == null) {
				break;
			}			
			
			$req_field_arr = explode(".", $storedFields[$i]);
			for($j = 0; $j < count($req_field_arr); $j++) {
				if (strpos($req_field_arr[$j], "[") !== false) {
					$array_field = (explode("[", $req_field_arr[$j]))[0];
					$array_index = (int)(explode("]", ((explode("[", $req_field_arr[$j]))[1])))[0];
					$body = ($body[$array_field])[$array_index];
				} else {
					$body = $body[$req_field_arr[$j]];
				}
			}
			
			self::$fieldmap[$name.$storedFields[$i]] = $body;
        }
		
        //Asserting for HTTP Status
        if($assertions != null) {
			if($assertions['httpStatus'] != '') {
				$this->assertEquals($assertions['httpStatus'], $resp[1]);
			} 
			$expectedValues = $assertions['expectedValues'];
			//Asserting for Expected Values
			for($i = 0; $i < count($expectedValues); $i++) {
				$body = $data;
				$field_arr = explode(".", $expectedValues[$i]['field']);
				
				for($j = 0; $j < count($field_arr); $j++) {
					$body = $body[$field_arr[$j]];
				}
				
				$this->assertEquals($expectedValues[$i]['value'], $body, $function_name . ": " . $expectedValues[$i]['field'] . " not matching expected value.\n");
			}
			
			$requiredFields = $assertions['requiredFields'];
			
			//Asserting for required fields
			for($i = 0; $i < count($requiredFields); $i++) {
				$body = $data;
				$req_field_arr = explode(".", $requiredFields[$i]);
				
				for($j = 0; $j < count($req_field_arr); $j++) {
					$body = $body[$req_field_arr[$j]];
				}
				
				$this->assertNotNull($body, $requiredFields[$i]." is null.\n");
			}
		}
		
		fwrite(STDOUT, print_r($end_line, TRUE));
    }

    //Data Provider function which passes the road array element by element to the test function
    public function valueLoader() {
		$array = json_decode(file_get_contents("test" . DIRECTORY_SEPARATOR . "executor.json"), true);
		$roads = $array['Execution Order'];

		$road_array = array();

		for($i = 0; $i < count($roads); $i++) {
			$road_array[] = array($roads[$i]);
		}
		
		return $road_array;
    }
}

?>