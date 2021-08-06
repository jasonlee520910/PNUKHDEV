<?php
	function curl_get($domain,$url,$code,$data)
	{
		$language=$_COOKIE["ck_language"];
		if(!$language){$language="kor";}
		$url=$domain."/".$url."/?apiCode=".$code."&language=".$language."&".$data;
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
		if( $value == "" || $value == null || $value == NULL || empty($value) || $value == "null")
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
	function logOutCookie($url)
	{
		$past = time() - 3600; 
		foreach ( $_COOKIE as $key => $value ) {  unset($_COOKIE[$key]); setcookie( $key, "", $past, '/'); } 
		header("Location: ".$url); 
	}
	function checkSession($url)
	{
		//세션이 있는지 여부 체크 (로그인)
		if(!isset($_COOKIE["ck_stUserid"]) || isEmpty($_COOKIE["ck_stUserid"]))
		{
			logOutCookie($url);
		}
		else
		{
			switch($_COOKIE["ck_stDepart"])
			{
			case "making":case "decoction":case "marking":case "release":case "goods":case "pharmacy":case "delivery":case "pill"://20191022 추가 
				break;
			default:
				logOutCookie($url);
				break;
			}
		}

	}
	/// 20200325:암호화(OK)
	function djEncrypt($data, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$endata = openssl_encrypt($data, 'aes-256-cbc', $authkey, true, $crypt_iv);
		$endata = base64_encode($endata);
		return $endata;
	}
	/// 20200325:복호화(OK)
	function djDecrypt($endata, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$data = base64_decode($endata);
		$endata = openssl_decrypt($data, "aes-256-cbc", $authkey, true, $crypt_iv);
		return $endata;
	}
?>
