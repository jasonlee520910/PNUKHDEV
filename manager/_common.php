<?php 
	include_once($root."/cmmInc/_define.php");
	include_once($root."/cmmInc/_session.php");
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
	//MANAGER

	$fileName="/datamanager".$language.".json";
	$fileUrl=$NET_FILE_URL."textdata".$fileName;
	$response = (file_get_contents($fileUrl)); //Converting in json string
	$txtdt=json_decode(urldecode($response),true);
	/*
	$result=curl_get($NET_URL_API_MANAGER, "setting","textdbfront","type=manager");
	$txtdt=json_decode($result,true);
	*/

	checkSession($NET_URL_MEMBER);

	//공통으로 쓰이는 텍스트 js에서 쓰이기 위함 
	$ComTxtdt = array(
			"ERR_1716"=>$txtdt["1716"],//공통 약재로 등록되어 있습니다.
			"ERR_1715"=>$txtdt["1715"],//개별 약재로 등록되어 있습니다.
			"ERR_1714"=>$txtdt["1714"],//해당 조제대에 약재가 등록되어 있습니다.
			"ERR_1526"=>$txtdt["1526"],//중복코드 
			"ERR_1708"=>$txtdt["1708"],//약재함이 존재하지 않거나 사용할수 없습니다.
			"MSG_1206"=>$txtdt["1206"],//약재함이나 약재바코드를 스캔해 주세요. 
			"MSG_1723"=>$txtdt["1723"],//약재가 부족합니다.
			"MSG_1726"=>$txtdt["1726"],//이미 사용중인 약재코드입니다.
			"INSERT_OK"=>$txtdt["1546"],//데이터 등록/수정되었습니다.
			"DELETE_OK"=>$txtdt["1542"],//데이터 삭제되었습니다.
			"NECDATA"=>$txtdt["1478"],//필수데이터
			"DELETE"=>$txtdt["1480"],//삭제하시겠습니까?
			"DENYDEL"=>$txtdt["1941"],//삭제하시겠습니까?
			"MEDIBOXTABLECHK"=>$txtdt["1942"],//1,2약재함과 공동약재함은 함께 사용하실수 없습니다. 다시 확인해주세요

			"MEMBER_DIFFERENT"=>$txtdt["1805"],//다른기기에서 로그인되었습니다. 로그인화면으로 이동합니다.
			"CONFIRM"=>$txtdt["1806"],//확인
			"DAY"=>$txtdt["1846"], //일 
			"UNIT"=>$txtdt["1235"], //원

			"1722"=>$txtdt["1722"], ////독성,상극 약재가 있습니다.
			"1721"=>$txtdt["1721"], //상극 약재가 있습니다.
			"1720"=>$txtdt["1720"], //독성 약재가 있습니다.
			"1831"=>$txtdt["1831"],//[1] 처방은 [2]g 이상부터 주문 가능합니다. 총약재량을 확인해 주세요.

			"EXCEL_UPLOAD_OK"=>$txtdt["1834"],//엑셀 업로드가 완료되었습니다.

			"FILE_UPLOAD_OK"=>$txtdt["1727"],//파일업로드 되었습니다.
			"FILE_DB_FAIL"=>$txtdt["1839"],//파일업로드에 성공하였으나 DB 저장에 실패하였습니다.
			"FILE_UPLOAD_FAIL"=>$txtdt["1728"],//파일업로드에 실패했습니다.
			"FILE_UPLOAD_ERR01"=>$txtdt["1729"],//첨부파일 사이즈는 5MB 이내로 등록 가능합니다.
			"FILE_UPLOAD_ERR02"=>$txtdt["1730"],//허용된 파일형식이 아닙니다.
			"FILE_UPLOAD_ERR03"=>$txtdt["1731"],//파일 오류입니다.
			"FILE_UPLOAD_ERR04"=>$txtdt["1732"]//도메인 관리자에게 문의 바랍니다.
			);

?>

