<?php
	$NetLive = "LIVE"; //로컬 : LOCAL, 데브 : DEV, 상용 : LIVE

	//라벨프린트에서 login할때 odcode와 pwd 풀때의 key 
	$labelAuthkey="S5EK3SSNAR1J7908N5HV3C9QY77ND8YV4AD5SVSSAH9FHZE32MWVPWJK1PY4MUYPU1TBL91UQ0Z5Y36YNTS1M8KCM766ZUURKBS3";

	//-------------------------------------------------------------------------------------
	// URL 관련 define 
	//-------------------------------------------------------------------------------------
	$severName=$_SERVER['SERVER_NAME'];
	$severFirstName="tbms";
	
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
	$NET_URL_API = "https://api.pnuh.djmedi.net/";

	$NET_URL_API_TBMS = $NET_URL_API."tbms/";
	$NET_URL_MEMBER = $lastHttps.str_replace($severFirstName,"member",$severName)."/";//"https://member.djmedi.kr/";
	//쿠키도메인 
	$NET_DOMAIN = str_replace($severFirstName,"",$severName);//".djmedi.kr";
	//파일업로드
	$NET_FILE_UPLOAD = $lastHttps.str_replace($severFirstName,"data",$severName)."/ajaxupload.php";//"https://data.djmedi.kr/ajaxupload.php"; 
	//파일업로드 PATH
	$NET_FILE_URL = $lastHttps.str_replace($severFirstName,"data",$severName)."/";//"https://data.djmedi.kr/data/"; 
	//잠시사용
	$NET_FILE_URL="https://data.pnuh.djmedi.net/";
	//-------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------------
	// DOO :: 마킹프린터와 각 프로세스 관련 공통 변수 
	//-------------------------------------------------------------------------------------
	//마킹프린터 출력: true, 미출력: false
	//processing/marking/main.php >> startmarking 함수에서 고침 
	//-------------------------------------------------------------------------------------
	$markingprt = "true"; 
	//-------------------------------------------------------------------------------------
	//프로세스 on:true, off:false 
	//jquery.js >> checkbarcode >> makingdone,decoctiondone,markingdone,releasedone api 호출 
	//jquery에서 써야하므로  index.php containerDiv에 data-value로 추가함 
	//-------------------------------------------------------------------------------------
	$makingprocess = "true";//조제
	$decoctionprocess = "true";//탕전
	$markingprocess = "true";//마킹
	$releaseprocess = "true";//배송 
	$goodsprocess = "true";
	$pillprocess = "true";

	//API, URL array 잡아서 textarea에 json으로 말아서 넣는다. js에서도 호출할수 있다. 
	//위에 API, URL에 추가하면 아래에도 똑같이 추가해야 js에서도 쓸수 잇음. 
	$NetURL = array(
		"API"=>$NET_URL_API,
		"API_TBMS"=>$NET_URL_API_TBMS, 
		"MEMBER"=>$NET_URL_MEMBER,
		"TUTORIAL"=>$NET_URL_TUTORIAL,
		"FILE"=>$NET_FILE_UPLOAD,
		"FILE_DOMAIN"=>$NET_FILE_URL,
		"DOMAIN"=>$NET_DOMAIN
		);
	//-------------------------------------------------------------------------------------
?>