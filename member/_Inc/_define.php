<?php
	//cy LIVE

	$NetLive = "LIVE"; //로컬 : LOCAL, 데브 : DEV, 상용 : LIVE

	//-------------------------------------------------------------------------------------
	// URL 관련 define 
	//-------------------------------------------------------------------------------------
	$severName=$_SERVER['SERVER_NAME'];
	$severFirstName="member";
	
	if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443)
	{
		$lastHttps="https://";
	}
	else
	{
		$lastHttps="http://";
	}

	// API
	$NET_URL_API = $lastHttps.str_replace($severFirstName,"api",$severName)."/";//.djmedi.kr/";
	//잠시사용
	$NET_URL_API="https://api.pnuh.djmedi.net/";
	$NET_URL_API_MEMBER = $NET_URL_API."member/";
	//쿠키도메인 
	$NET_DOMAIN = str_replace($severFirstName,"",$severName);//".djmedi.kr";
	//파일업로드 PATH
	$NET_FILE_URL = $lastHttps.str_replace($severFirstName,"data",$severName)."/";//"https://data.djmedi.kr/data/"; 
	//잠시사용
	$NET_FILE_URL="https://data.pnuh.djmedi.net/";

	//-------------------------------------------------------------------------------------
	//API, URL array 잡아서 textarea에 json으로 말아서 넣는다. js에서도 호출할수 있다. 
	//위에 API, URL에 추가하면 아래에도 똑같이 추가해야 js에서도 쓸수 잇음. 
	$NetURL = array(
		"API"=>$NET_URL_API,
		"API_MEMBER"=>$NET_URL_API_MEMBER,
		"LIVE"=>$NetLive,
		"DOMAIN"=>$NET_DOMAIN
		);
	//-------------------------------------------------------------------------------------
?>
