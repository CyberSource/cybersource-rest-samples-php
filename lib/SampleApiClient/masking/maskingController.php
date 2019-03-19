<?php
namespace CybSource;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/autoload.php';

class Masking
{
	//set Fields to be mask
	public function dataMasking($postData_json)
	{
		$toBeMask = array("number"=>"XXXXX","expirationMonth"=>"XXXX","expirationYear"=>"XXXX","email"=>"XXXXX","firstName"=>"XXXXX","lastName"=>"XXXX","phoneNumber"=>"XXXXX","type"=>"XXXX","securityCode"=>"XXXXX");
		$postData_json = json_decode($postData_json, JSON_UNESCAPED_SLASHES);
		$postData_json = $this->dataMaskingIterate($postData_json, $toBeMask);
		return json_encode($postData_json);
	}

	//Data masking iteration
    public function dataMaskingIterate($responceArr, $callback)
    { 
        if(!empty($responceArr)){
            foreach ($responceArr as $k => $v) 
            {
                if(is_array($v)) {
                    $responceArr[$k] = $this->dataMaskingIterate($v, $callback);
                } 
                else 
                {
                    if(array_key_exists($k, $callback)) 
                    {
                        $responceArr[$k]="XXXXXX";
                    }
                }
            }
        }
        return $responceArr;

    }
	
}


?>