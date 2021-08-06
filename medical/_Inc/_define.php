<?php
	//-------------------------------------------------------------------------------------
	// URL 관련 define 
	//-------------------------------------------------------------------------------------
	$severName=$_SERVER['SERVER_NAME'];
	$severFirstName="ehd";
	
	if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443)
	{
		$lastHttps="https://";
	}
	else
	{
		$lastHttps="http://";
	}

	// API
	$NET_URL_API = $lastHttps.str_replace($severFirstName,"api",$severName);//.djmedi.kr/";

	$NET_URL_API_MEDICAL = $NET_URL_API."/medical/";
	$NET_URL_API_MANAGER = $NET_URL_API."/manager/";
	$NET_URL_API_TBMS = $NET_URL_API."/tbms/";
	$NET_URL_TBMS = $lastHttps.str_replace($severFirstName,"tbms",$severName)."/";//"https://member.djmedi.kr/";
	$NET_URL_MEMBER = $lastHttps.str_replace($severFirstName,"member",$severName)."/";//"https://member.djmedi.kr/";
	//쿠키도메인 
	$NET_DOMAIN = str_replace($severFirstName,"",$severName);//".djmedi.kr";
	//파일업로드 PATH
	$NET_FILE_URL = $lastHttps.str_replace($severFirstName,"data",$severName)."/";//"https://data.djmedi.kr/data/"; 
	//잠시사용
	$NET_FILE_URL="https://data.pnuh.djmedi.net/";
	//파일업로드
	$NET_FILE_UPLOAD = $NET_FILE_URL."ajaxupload.php";//"https://data.djmedi.kr/ajaxupload.php"; 

	//var PG_DOMAIN  = 'https://auth.kocespay.com';		// 운영
	//var PG_DOMAIN  = 'https://authtest.kocespay.com';		// 개발
	//카드결제
	$NET_PG_DOMAIN="https://authtest.kocespay.com";
 

	//-------------------------------------------------------------------------------------
	//API, URL array 잡아서 textarea에 json으로 말아서 넣는다. js에서도 호출할수 있다. 
	//위에 API, URL에 추가하면 아래에도 똑같이 추가해야 js에서도 쓸수 잇음. 
	$NetURL = array(
		"API"=>$NET_URL_API,
		"API_MEDICAL"=>$NET_URL_API_MEDICAL, 
		"API_MANAGER"=>$NET_URL_API_MANAGER, 
		"API_TBMS"=>$NET_URL_API_TBMS,
		"TBMS"=>$NET_URL_TBMS,
		"MEMBER"=>$NET_URL_MEMBER,
		"DOMAIN"=>$NET_DOMAIN,
		"BASE_CHUBCOUNT"=>$BASE_CHUBCOUNT,
		"FILE_DOMAIN"=>$NET_FILE_URL,
		"FILE"=>$NET_FILE_UPLOAD,
		"PG_DOMAIN"=>$NET_PG_DOMAIN,
		"EXCEL"=>$NET_EXCEL_UPLOAD
		);

?>
