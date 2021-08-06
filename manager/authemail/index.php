<?php 
$root = "..";
include_once ($root.'/cmmInc/_define.php');

	function djDecrypt($endata, $authkey)
	{
		$crypt_iv = "abcdefghij123456";//"#@$%^&*()_+=-";
		$endata = base64_decode($endata);
		$endata = openssl_decrypt($endata, "aes-256-cbc", $authkey, true, $crypt_iv);
		return $endata;
	}
	function curl_post($domain,$url,$code,$data)
	{
		$language=$_COOKIE["ck_language"];
		if(!$language){$language="kor";}
		$url=$domain."".$url."/";
		$post_data["apiCode"]=$code;
		$post_data["language"]=$language;
		$post_data["postdata"]=$data;
		//var_dump($post_data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1); //0이 default 값이며 POST 통신을 위해 1로 설정해야 함
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //POST로 보낼 데이터 지정하기
		curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0); //이 값을 0으로 해야 알아서 &post_data 크기를 측정하는듯
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}

	$key= djDecrypt($_GET["key"], "chkemail");
	$result=curl_post($NET_URL_API, "common/mailer","sendchk",$key);

	$result=json_decode($result,true);
	if($result["resultCode"]=="204")  //인증안됨
	{
		echo "<script>alert('인증번호 오류입니다.');</script>";
		echo("<script>location.href='".$NET_URL_EHD."'</script>");
	}
	else if($result["resultCode"]=="200") //인증됨
	{
		//var_dump($result["key"]);
		//echo $result["key"][1];
		echo "<script>alert('인증되었습니다.');</script>";
		$resultdata=curl_post($NET_URL_API, "common/mailer","mestatusupdate",$result["key"][1]);
		//var_dump($resultdata);
		echo("<script>location.href='".$NET_URL_EHD."'</script>");
		
	}
?>
