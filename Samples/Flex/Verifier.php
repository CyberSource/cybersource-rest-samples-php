<?php
class Verifier
{

	public function verifySignature($publicKey, $postParam)
	{
		$dataString = "";
		$arraySting = explode(",", $postParam['signedFields']);
		$lastElement = end($arraySting);
		$postParam = json_decode($postParam);
		foreach ($arraySting as $value) {
			$dataString .= $postParam->$value;
			if($lastElement != $value){
				$dataString .= ",";
			}

		}
		$signature = base64_decode($postParam->signature);
		$signatureVerify = openssl_verify($dataString, $signature, $publicKey, "sha512");
		if ($signatureVerify == 1) {
			echo "True";
		} elseif ($signatureVerify == 0) {
			echo "False";
		} else {
			echo "Error in checking signature";
		}

	}


}

?>