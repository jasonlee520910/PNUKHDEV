<?php
	function curl_get($domain,$url,$code,$data)
	{
		$language=$_COOKIE["ck_language"];
		if(!$language){$language="kor";}		
		$url=$domain."".$url."/?apiCode=".$code."&language=".$language."&".$data;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		curl_close ($ch);
		return $result;
	}
	function curl_getFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
	function isEmpty($value)
	{
		if( $value == "" || $value == '' || $value == null || $value == NULL || empty($value) || $value == "null" || !isset($value))
		{
			return true;
		}
		else
		{
			if($value)
				return false;
			else 
				return true;
		}
	}
?>
