<?php
	$dtdom="";//define에서 적용
	$refer="djmedi";

	$labelAuthkey="S5EK3SSNAR1J7908N5HV3C9QY77ND8YV4AD5SVSSAH9FHZE32MWVPWJK1PY4MUYPU1TBL91UQ0Z5Y36YNTS1M8KCM766ZUURKBS3";

	//====================================================
	//로젠 송장 관련 
	//====================================================
	//로젠 테스트 서버 
	$LOGEN_SERVER_URL="http://1.255.199.16/iLOGEN.EDI.WebService/W_PHPServer.asmx?WSDL";
	//로젠 실운영
	//$LOGEN_SERVER_URL="http://ediweb.ilogen.com/ilogen.edi.webservice/w_phpserver.asmx?WSDL";

	//청연ID/pwd
	$userID="";//사용자아이디 (솔루션업체계약코드)
	$passWord="";//비밀번호

	//최소의 송장 갯수를 체크하기 위함 
	$MIN_SLIP=100;
	//최소 송장 갯수보다 적을시에 업데이트할 송장 갯수 
	$SLIP_UPDATE_CNT=1000;
	//====================================================


	//====================================================
	//우체국 송장 관련
	//====================================================
	//우체국 서버 주소 
	$ePOST_SERVER_URL="http://ship.epost.go.kr/";
	
	//인터넷우체국 회원아이디 정보 
	$postUserID="ckdwjstlf";

	//택배접수에 관한 인증키 
	$securityKey="7e175efb2ad907ff181032";//보안키 
	$certifykey="cb17126a123cd7fe81586166444945";//인증키 

	//집배코드 인증키 
	$delivArecertifykey="cb17126a123cd7fe11586166457032";

	//우편번호 인증키 
	$zipcertifykey="cb17126a123cd7fea1586166442691";
	
	//우체국 실운영으로 보내기 
	$POST_TESTYN="N";
	//====================================================
	/*
	2. 우체국
	계약고객전용시스템 biz.epost.go.kr
	ID : 창전실, ckdwjstlf
	PS : 12345
	*/

	//http://openapi.epost.go.kr:80/postal/retrieveNewAdressAreaCdSearchAllService?_wadl&type=xml

?>