<?php
	include_once($root."/_Inc/_define.php");
	include_once($root."/_Inc/_session.php");
	include_once($root."/_Lib/_lib.php");

	$ip = $_SERVER["REMOTE_ADDR"];
	$url = $_SERVER["REQUEST_URI"];

	$farr= explode("?",$url);
	$pageurl= $farr[0];
	$darr=explode("/",$pageurl);
	$dir= $darr[1];

	$farr= explode("?",basename($url));
	$file= substr($farr[0],0,-4);

	//text data array
	$language=$_COOKIE["ck_language"];
	$languagetxt=$_COOKIE["ck_languageName"];

	if(!$language)
	{
		$language="kor";
		$languagetxt="한글";
	}
	if(!$languagetxt)	
	{
		switch($language)
		{
		case "chn":
			$language = "chn";
			$languagetxt = "中文";
			break;
		case "eng":
			$language = "eng";
			$languagetxt = "eng";
			break;
		default:
			$language = "kor";
			$languagetxt = "한글";
			break;
		}
	}

	$_COOKIE["ck_language"]=$language;
	$_COOKIE["ck_languageName"]=$languagetxt;



	//MEMBER
	$fileName="/datatbms".$language.".json";
	$fileUrl=$NET_FILE_URL."textdata".$fileName;
	//echo $fileUrl;
	$response = (file_get_contents($fileUrl)); //Converting in json string
	$txtdt=json_decode(urldecode($response),true);
	//var_dump($txtdt);

	/*
	$result=curl_get($NET_URL_API_MEMBER,"setting","textdbfront","type=front");
	$txtdt=json_decode($result,true);
	*/

	//공통으로 쓰이는 텍스트 js에서 쓰이기 위함 
	$ComTxtdt = array(
			"CHECKIDPWD"=>$txtdt["checkidpwd"],//아이디와 비밀번호를 다시 확인해주세요.
			"ACCESSERR"=>$txtdt["accesserr"],//접속오류
			"CONFIRMWAIT"=>$txtdt["confirmwait"],//인증대기
			"INFONO"=>$txtdt["infono"],//정보없음

			"CONFIRM"=>$txtdt["confirm"], //확인
			"CANCEL"=>$txtdt["cancel"], //취소

			"9011"=>$txtdt["9011"],//허용된 접속이 아닙니다. 관리자에게 문의주세요.
			

			"CHECKDATA"=>$txtdt["checkdata"],//올바른 정보를 입력하세요
			"EMAILOKLOGIN"=>$txtdt["emailoklogin"]//이메일 인증 후 로그인 가능합니다.
			);

?>
