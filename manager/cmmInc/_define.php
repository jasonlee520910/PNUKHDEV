<?php	
	$NetLive = "LIVE"; //로컬 : LOCAL, 데브 : DEV, 상용 : LIVE

	//-------------------------------------------------------------------------------------
	// URL 관련 define 
	//-------------------------------------------------------------------------------------
	$severName=$_SERVER['SERVER_NAME'];
	$severFirstName="manager";
	
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
	$NET_URL_API_MANAGER = $NET_URL_API."manager/";
	$NET_URL_API_TBMS = $NET_URL_API."tbms/";
	$NET_URL_TBMS = $lastHttps.str_replace($severFirstName,"tbms",$severName)."/";//"https://member.djmedi.kr/";
	$NET_URL_MEMBER = $lastHttps.str_replace($severFirstName,"member",$severName)."/";//"https://member.djmedi.kr/";
	$NET_URL_EHD = $lastHttps.str_replace($severFirstName,"ehd",$severName)."/";//.djmedi.kr/";
	//쿠키도메인 
	$NET_DOMAIN = str_replace($severFirstName,"",$severName);//".djmedi.kr";
	//파일업로드 PATH
	$NET_FILE_URL = $lastHttps.str_replace($severFirstName,"data",$severName)."/";//"https://data.djmedi.kr/data/"; 
	//파일업로드
	$NET_FILE_UPLOAD = $NET_FILE_URL."ajaxupload.php";//"https://data.djmedi.kr/ajaxupload.php"; 
	//엑셀 업로드 
	$NET_EXCEL_UPLOAD = $NET_FILE_URL."ajaxexcelupload.php";//"https://data.djmedi.kr/ajaxupload.php"; 
	//curl업로드
	$NET_CURL_UPLOAD = $NET_FILE_URL."curlupload.php";//"https://data.djmedi.kr/ajaxupload.php"; 

	//-------------------------------------------------------------------------------------
	$BASE_CHUBCOUNT=20;//기본베이스첩수 odChubcnt
	$BASE_PACKCOUNT=45;//기본베이스팩수 odPackcnt
	$BASE_PACKCAPA=120;//기본베이스팩용량 odPackcapa
	$BASE_MAXCAPA=400;//기본베이스제환일때 처방낼수있는 총약재량 
	$BASE_DCTIME=80;//기본베이스탕전시간 20190924 : 기본탕전시간을 150분에서 130분으로 수정 //20191004 탕전시간 80분
	$BASE_NOK_DCTIME=120;//20191010 녹용은 탕전시간을 120으로 수정 
	$BASE_ADDCYPACK=4;//탕전물량 계산할때 추가할 파우치 갯수 
	$BASE_ADDPACK=$BASE_ADDCYPACK;//탕전물량 계산할때 추가할 파우치 갯수 
	//-------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------------
	//API, URL array 잡아서 textarea에 json으로 말아서 넣는다. js에서도 호출할수 있다. 
	//위에 API, URL에 추가하면 아래에도 똑같이 추가해야 js에서도 쓸수 잇음. 
	$NetURL = array(
		"NETLIVE"=>$NetLive,
		"SERVERNAME"=>$severName,
		"API"=>$NET_URL_API,
		"API_MANAGER"=>$NET_URL_API_MANAGER, 
		"API_TBMS"=>$NET_URL_API_TBMS,
		"TBMS"=>$NET_URL_TBMS,
		"MEMBER"=>$NET_URL_MEMBER,
		"DOMAIN"=>$NET_DOMAIN,
		"BASE_CHUBCOUNT"=>$BASE_CHUBCOUNT,
		"FILE_DOMAIN"=>$NET_FILE_URL,
		"FILE"=>$NET_FILE_UPLOAD,
		"EXCEL"=>$NET_EXCEL_UPLOAD
		);

	//-------------------------------------------------------------------------------------
	// 계정에 따른 등록 수정 삭제 권한  (group으로 추가수정(0822) -> admin: 기존과 동일(약재목록과 환경설정 제외), manager: 등록삭제수정 불가능, djmedi 테스트용 모든 권한)
	//-------------------------------------------------------------------------------------
	//group 최고관리자그룹은 모두  manage 그룹하고분리
	
	$modifyAuth = "";  

	switch($_COOKIE["ck_stAuth"])
	{
		case "manager": 
		$modifyAuth = "false";
		break;

		case "admin": 
		$modifyAuth = "true";
		break;

		case "djmedi": 
		$modifyAuth = "true";
		break;
	}
?>
